<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 */
class SonataSeoExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $config = $this->fixConfiguration($config);

        $bundles = $container->getParameter('kernel.bundles');

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (isset($bundles['SonataBlockBundle']) && isset($bundles['KnpMenuBundle'])) {
            $loader->load('blocks.xml');
        }

        $loader->load('event.xml');
        $loader->load('services.xml');

        $this->configureSeoPage($config['page'], $container);
        $this->configureSitemap($config['sitemap'], $container);
        $this->configureClassesToCompile();

        $container->getDefinition('sonata.seo.twig.extension')
            ->replaceArgument(1, $config['encoding']);
    }

    /**
     * Add class to compile.
     */
    public function configureClassesToCompile()
    {
        $this->addClassesToCompile(array(
            'Sonata\\SeoBundle\\Seo\\SeoPage',
            'Sonata\\SeoBundle\\Seo\\SeoPageInterface',
            'Sonata\\SeoBundle\\Sitemap\\SourceManager',
            'Sonata\\SeoBundle\\Twig\\Extension\\SeoExtension',
        ));
    }

    /**
     * Configure the default seo page.
     *
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
     * Configure the sitemap source manager.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function configureSitemap(array $config, ContainerBuilder $container)
    {
        $source = $container->getDefinition('sonata.seo.sitemap.manager');

        if (method_exists($source, 'setShared')) { // Symfony 2.8+
            $source->setShared(false);
        } else {
            // For Symfony <2.8 compatibility
            $source->setScope(ContainerInterface::SCOPE_PROTOTYPE);
        }

        foreach ($config['doctrine_orm'] as $pos => $sitemap) {
            // define the connectionIterator
            $connectionIteratorId = 'sonata.seo.source.doctrine_connection_iterator_'.$pos;

            $connectionIterator = new Definition('%sonata.seo.exporter.database_source_iterator.class%', array(
                new Reference($sitemap['connection']),
                $sitemap['query'],
            ));

            $connectionIterator->setPublic(false);
            $container->setDefinition($connectionIteratorId, $connectionIterator);

            // define the sitemap proxy iterator
            $sitemapIteratorId = 'sonata.seo.source.doctrine_sitemap_iterator_'.$pos;

            $sitemapIterator = new Definition('%sonata.seo.exporter.sitemap_source_iterator.class%', array(
                new Reference($connectionIteratorId),
                new Reference('router'),
                $sitemap['route'],
                $sitemap['parameters'],
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
     * Fix the sitemap configuration.
     *
     * @param array $config
     *
     * @return array
     */
    protected function fixConfiguration(array $config)
    {
        foreach ($config['sitemap']['doctrine_orm'] as $pos => $sitemap) {
            $sitemap['group'] = isset($sitemap['group']) ? $sitemap['group'] : false;
            $sitemap['types'] = isset($sitemap['types']) ? $sitemap['types'] : array();
            $sitemap['connection'] = isset($sitemap['connection']) ? $sitemap['connection'] : 'doctrine.dbal.default_connection';
            $sitemap['route'] = isset($sitemap['route']) ? $sitemap['route'] : false;
            $sitemap['parameters'] = isset($sitemap['parameters']) ? $sitemap['parameters'] : false;
            $sitemap['query'] = isset($sitemap['query']) ? $sitemap['query'] : false;

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

        foreach ($config['sitemap']['services'] as $pos => $sitemap) {
            if (!is_array($sitemap)) {
                $sitemap = array(
                    'group' => false,
                    'types' => array(),
                    'id' => $sitemap,
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
}
