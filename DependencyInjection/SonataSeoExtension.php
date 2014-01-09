<?php

namespace Sonata\SeoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
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
        $bundles = $container->getParameter('kernel.bundles');

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (isset($bundles['SonataBlockBundle'])) {
            $loader->load('blocks.xml');
        }

        $loader->load('event.xml');
        $loader->load('services.xml');

        $config = $this->fixConfiguration($configs);

        $this->configureSeoPage($config['page'], $container);
        $this->configureSitemap($config['sitemap'], $container);
        $this->configureClassesToCompile();

        $container->getDefinition('sonata.seo.twig.extension')
            ->replaceArgument(1, $config['encoding']);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function configureSeoPage(array $config, ContainerBuilder $container)
    {
        $definition = $container->getDefinition($config['default']);

        $definition->addMethodCall('setTitle', array($config['title']));
        $definition->addMethodCall('setMetas', array($config['metas']));
        $definition->addMethodCall('setHtmlAttributes', array($config['head']));
        $definition->addMethodCall('setSeparator', array($config['separator']));

        $container->setAlias('sonata.seo.page', $config['default']);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function configureSitemap(array $config, ContainerBuilder $container)
    {
        $source = $container->getDefinition('sonata.seo.sitemap.manager');
        $source->setScope(ContainerInterface::SCOPE_PROTOTYPE);

        foreach ($config['doctrine_orm'] as $pos => $sitemap) {
            // define the connectionIterator
            $connectionIteratorId = 'sonata.seo.source.doctrine_connection_iterator_'.$pos;

            $connectionIterator = new Definition('%sonata.seo.exporter.database_source_iterator.class%', array(
                new Reference($sitemap['connection']),
                $sitemap['query']
            ));

            $connectionIterator->setPublic(false);
            $container->setDefinition($connectionIteratorId, $connectionIterator);

            // define the sitemap proxy iterator
            $sitemapIteratorId = 'sonata.seo.source.doctrine_sitemap_iterator_'.$pos;

            $sitemapIterator = new Definition('%sonata.seo.exporter.sitemap_source_iterator.class%', array(
                new Reference($connectionIteratorId),
                new Reference('router'),
                $sitemap['route'],
                $sitemap['parameters']
            ));

            $sitemapIterator->setPublic(false);

            $container->setDefinition($sitemapIteratorId, $sitemapIterator);

            $source->addMethodCall('addSource', array($sitemap['group'], new Reference($sitemapIteratorId), $sitemap['types']));
        }

        foreach ($config['services'] as $service) {
            $source->addMethodCall('addSource', array($service['group'], new Reference($service['id']), $service['types']));
        }
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
        $config['page']['separator'] = isset($config['page']['separator'])? $config['page']['separator']: ' - ';
        $config['page']['title']     = isset($config['page']['title'])    ? $config['page']['title']    : 'Sonata Project';
        $config['page']['metas']     = isset($config['page']['metas'])    ? $config['page']['metas']    : array();
        $config['page']['head']      = isset($config['page']['head'])     ? $config['page']['head']     : array();

        // twig settings
        $config['encoding']          = isset($config['encoding']) ? $config['encoding'] : 'UTF-8';

        // sitemap
        $config['sitemap']                  = isset($config['sitemap']) && is_array($config['sitemap'])  ? $config['sitemap'] : array();
        $config['sitemap']['doctrine_orm']  = isset($config['sitemap']['doctrine_orm']) && is_array($config['sitemap']['doctrine_orm'])  ? $config['sitemap']['doctrine_orm'] : array();

        foreach ($config['sitemap']['doctrine_orm'] as $pos => $sitemap) {
            $sitemap['group']      = isset($sitemap['group']) ? $sitemap['group'] : false;
            $sitemap['types']      = isset($sitemap['types']) ? $sitemap['types'] : array();
            $sitemap['connection'] = isset($sitemap['connection']) ? $sitemap['connection'] : 'doctrine.dbal.default_connection';
            $sitemap['route']      = isset($sitemap['route']) ? $sitemap['route'] : false;
            $sitemap['parameters'] = isset($sitemap['parameters']) ? $sitemap['parameters'] : false;
            $sitemap['query']      = isset($sitemap['query']) ? $sitemap['query'] : false;

            if ($sitemap['route'] === false) {
                throw new \RuntimeException('Route cannot be empty, please review the sonata_seo.sitemap configuration');
            }

            if ($sitemap['query'] === false) {
                throw new \RuntimeException('Query cannot be empty, please review the sonata_seo.sitemap configuration');
            }

            if ($sitemap['parameters'] === false) {
                throw new \RuntimeException('Route\'s parameters cannot be empty, please review the sonata_seo.sitemap configuration');
            }

            $config['sitemap']['doctrine_orm'][$pos] = $sitemap;
        }

        $config['sitemap']['services']  = isset($config['sitemap']['services']) && is_array($config['sitemap']['services'])  ? $config['sitemap']['services'] : array();

        foreach ($config['sitemap']['services'] as $pos => $sitemap) {
            if (!is_array($sitemap)) {
                $sitemap = array(
                    'group' => false,
                    'types' => array(),
                    'id'    => $sitemap
                );
            } else {
                $sitemap['group'] = isset($sitemap['group']) ? $sitemap['group'] : false;
                $sitemap['types'] = isset($sitemap['types']) ? $sitemap['types'] : array();

                if (!isset($sitemap['id'])) {
                    throw new \RuntimeException('Service id must to be defined, please review the sonata_seo.sitemap configuration');
                }
            }

            $config['sitemap']['services'][$pos] = $sitemap;
        }

        return $config;
    }

    /**
     * Add class to compile
     */
    public function configureClassesToCompile()
    {
        $this->addClassesToCompile(array(
            "Sonata\\SeoBundle\\Seo\\SeoPage",
            "Sonata\\SeoBundle\\Seo\\SeoPageInterface",
            "Sonata\\SeoBundle\\Sitemap\\SourceManager",
            "Sonata\\SeoBundle\\Twig\\Extension\\SeoExtension",
        ));
    }
}
