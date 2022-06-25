<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\DependencyInjection;

use Sonata\Exporter\Source\DoctrineDBALConnectionSourceIterator;
use Sonata\Exporter\Source\SymfonySitemapSourceIterator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 */
final class SonataSeoExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $config = $this->fixConfiguration($config);

        /** @var array<string, mixed> $bundles */
        $bundles = $container->getParameter('kernel.bundles');

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (isset($bundles['SonataBlockBundle'], $bundles['KnpMenuBundle'])) {
            $loader->load('blocks.php');
        }

        $loader->load('event.php');
        $loader->load('services.php');
        $loader->load('commands.php');

        $this->configureSeoPage($config['page'], $container);
        $this->configureSitemap($config['sitemap'], $container);

        $container->getDefinition('sonata.seo.twig.extension')
            ->replaceArgument(1, $config['encoding']);
    }

    /**
     * Configure the default seo page.
     *
     * @param mixed[] $config
     */
    private function configureSeoPage(array $config, ContainerBuilder $container): void
    {
        $container->setParameter('sonata.seo.config', $config);
    }

    /**
     * Configure the sitemap source manager.
     *
     * @param mixed[] $config
     */
    private function configureSitemap(array $config, ContainerBuilder $container): void
    {
        $source = $container->getDefinition('sonata.seo.sitemap.manager');

        $source->setShared(false);

        foreach ($config['doctrine_orm'] as $pos => $sitemap) {
            // define the connectionIterator
            $connectionIteratorId = 'sonata.seo.source.doctrine_connection_iterator_'.$pos;

            $connectionIterator = new Definition(DoctrineDBALConnectionSourceIterator::class, [
                new Reference($sitemap['connection']),
                $sitemap['query'],
            ]);

            $connectionIterator->setPublic(false);
            $container->setDefinition($connectionIteratorId, $connectionIterator);

            // define the sitemap proxy iterator
            $sitemapIteratorId = 'sonata.seo.source.doctrine_sitemap_iterator_'.$pos;

            $sitemapIterator = new Definition(SymfonySitemapSourceIterator::class, [
                new Reference($connectionIteratorId),
                new Reference('router'),
                $sitemap['route'],
                $sitemap['parameters'],
            ]);

            $sitemapIterator->setPublic(false);

            $container->setDefinition($sitemapIteratorId, $sitemapIterator);

            $source->addMethodCall('addSource', [$sitemap['group'], new Reference($sitemapIteratorId), $sitemap['types']]);
        }

        foreach ($config['services'] as $service) {
            $source->addMethodCall('addSource', [$service['group'], new Reference($service['id']), $service['types']]);
        }
    }

    /**
     * Fix the sitemap configuration.
     *
     * @param mixed[] $config
     *
     * @return mixed[]
     */
    private function fixConfiguration(array $config): array
    {
        foreach ($config['sitemap']['doctrine_orm'] as $pos => $sitemap) {
            $sitemap['group'] ??= false;
            $sitemap['types'] ??= [];
            $sitemap['connection'] ??= 'doctrine.dbal.default_connection';
            $sitemap['route'] ??= false;
            $sitemap['parameters'] ??= false;
            $sitemap['query'] ??= false;

            if (false === $sitemap['route']) {
                throw new \RuntimeException('Route cannot be empty, please review the sonata_seo.sitemap configuration');
            }

            if (false === $sitemap['query']) {
                throw new \RuntimeException('Query cannot be empty, please review the sonata_seo.sitemap configuration');
            }

            if (false === $sitemap['parameters']) {
                throw new \RuntimeException('Route\'s parameters cannot be empty, please review the sonata_seo.sitemap configuration');
            }

            $config['sitemap']['doctrine_orm'][$pos] = $sitemap;
        }

        foreach ($config['sitemap']['services'] as $pos => $sitemap) {
            if (!\is_array($sitemap)) {
                $sitemap = [
                    'group' => false,
                    'types' => [],
                    'id' => $sitemap,
                ];
            } else {
                $sitemap['group'] ??= false;
                $sitemap['types'] ??= [];

                if (!isset($sitemap['id'])) {
                    throw new \RuntimeException('Service id must to be defined, please review the sonata_seo.sitemap configuration');
                }
            }

            $config['sitemap']['services'][$pos] = $sitemap;
        }

        return $config;
    }
}
