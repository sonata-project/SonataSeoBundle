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
        // for now this configuration cannot be used as the key are normalized
//        $configuration = new Configuration();
//        $config = $this->processConfiguration($configuration, $configs);

        $config = $configs[0];

        $config['default'] = isset($config['default']) ? $config['default'] : 'sonata.seo.page.default';
        $config['title']   = isset($config['title'])   ? $config['title']   : 'Sonata Project';
        $config['metas']   = isset($config['metas'])   ? $config['metas']   : array();
        $config['head']    = isset($config['head'])    ? $config['head']    : array();

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $definition = $container->getDefinition($config['default']);
        $definition->addMethodCall('setTitle', array($config['title']));
        $definition->addMethodCall('setMetas', array($config['metas']));
        $definition->addMethodCall('setHtmlAttributes', array($config['head']));

        $container->setAlias('sonata.seo.page', $config['default']);
    }
}
