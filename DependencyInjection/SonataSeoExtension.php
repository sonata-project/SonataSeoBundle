<?php

namespace Sonata\SeoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SonataSeoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $config = $this->fixConfiguration($configs);

        $this->configureSeoPage($config, $container);

        $container->getDefinition('sonata.seo.twig.extension')
            ->replaceArgument(1, $config['encoding']);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function configureSeoPage(array $config, ContainerBuilder $container)
    {
        $definition = $container->getDefinition($config['page']['default']);

        $definition->addMethodCall('setTitle', array($config['page']['title']));
        $definition->addMethodCall('setMetas', array($config['page']['metas']));
        $definition->addMethodCall('setHtmlAttributes', array($config['page']['head']));

        $container->setAlias('sonata.seo.page', $config['page']['default']);
    }

    /**
     * @param array $configs
     *
     * @return array
     */
    protected function fixConfiguration(array $configs)
    {
        // for now this configuration cannot be used as the key are normalized
        // $configuration = new Configuration();
        // $config = $this->processConfiguration($configuration, $configs);
        $config = $configs[0];

        // page settings
        $config['page']              = isset($config['page']) && is_array($config['page'])  ? $config['page'] : array();
        $config['page']['default']   = isset($config['page']['default'])  ? $config['page']['default']  : 'sonata.seo.page.default';
        $config['page']['title']     = isset($config['page']['title'])    ? $config['page']['title']    : 'Sonata Project';
        $config['page']['metas']     = isset($config['page']['metas'])    ? $config['page']['metas']    : array();
        $config['page']['head']      = isset($config['page']['head'])     ? $config['page']['head']     : array();

        // twig settings
        $config['encoding']          = isset($config['encoding']) ? $config['encoding'] : 'UTF-8';

        return $config;
    }
}
