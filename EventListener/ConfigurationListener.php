<?php

namespace Sonata\SeoBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Yaml\Yaml;
use Sonata\SeoBundle\Seo\SeoPage;

class ConfigurationListener
{
    /** @var Sonata\SeoBundle\Seo\SeoPage $sonata */
    private $sonata;

    /** @var Symfony\Component\HttpKernel\Config\FileLocator $kernel */
    private $fileLocator;

    /** @var Symfony\Component\HttpKernel\Log\LoggerInterface $logger */
    private $logger;

    /**
     * __construct.
     *
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(
        FileLocator $fileLocator,
        SeoPage $sonata,
        LoggerInterface $logger
    ) {
        $this->sonata = $sonata;
        $this->logger = $logger;
        $this->fileLocator = $fileLocator;
    }

    /**
     * onKernelController.
     *
     * @param Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        // $controller passed can be either a class or a Closure. This is not
        // usual in Symfony but it may happen. If it is a class, it comes in
        // array format
        if (!is_array($controller)) {
            return;
        }

        // Get the request with namespace and others information we need and
        // construct the bundle namespace
        $request = $this->getRequest($event);

        $namespace = array('_namespace', '_bundle');
        foreach ($namespace as $key => $value) {
            $namespace[$key] = $request->attributes->get($value);
        }

        array_unshift($namespace, '@');
        $namespace = implode('', $namespace);
        $namespace = array($namespace, 'Resources', 'config', 'sonata.yml');
        $namespace = implode('/', $namespace);

        // Get the configuration file from the configuration into the
        // corresponding bundle
        try {
            $path = $this->fileLocator->locate($namespace);
        } catch (\InvalidArgumentException $e) {
            // Nothing to do because there's no SEO file
            return;
        }

        try {
            $config = Yaml::parse($path);
        } catch (Symfony\Component\Yaml\Exception\ParseException $e) {
            // Do nothing on error. Just log error
            $this->logger->err('YAML returns a parse error', array('exception' => $e));

            return;
        }

        $controller = $request->attributes->get('_controller');
        $action = $request->attributes->get('_action');

        if (array_key_exists($controller, $config)) {
            $config = $config[$controller];

            if (array_key_exists($action, $config)) {
                $config = $config[$action];
                $title  = $this->getConfiguration($config, 'title');
                $metas  = $this->getConfiguration($config, 'metas');

                if (!empty($title)) {
                    $this->sonata->setTitle($title);
                }

                foreach ($metas as $key => $values) {
                    foreach ($values as $head => $value) {
                        $this->sonata->addMeta($key, $head, $value);
                    }
                }
            }
        }
    }

    /**
     * Return the configuration if exists.
     *
     * @param array  $config
     * @param string $key
     *
     * @return array
     */
    private function getConfiguration(array $config, $key)
    {
        if (array_key_exists($key, $config)) {
            return $config[$key];
        }

        return array();
    }

    /**
     * Return generated request.
     *
     * @param Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     *
     * @return Symfony\Component\HttpFoundation\Request;
     */
    private function getRequest(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // Get the controller full namespace in order to get informations
        $controller = $request->attributes->get('_controller');
        $pattern = '/^(.*)\\\(.*Bundle)\\\Controller\\\(.*Controller)::(.*Action)$/';

        preg_match($pattern, $controller, $matches);
        $request->attributes->set('_namespace', $matches[1]);
        $request->attributes->set('_bundle', $matches[2]);
        $request->attributes->set('_controller', $matches[3]);
        $request->attributes->set('_action', $matches[4]);

        return $request;
    }
}
