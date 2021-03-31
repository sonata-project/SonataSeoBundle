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

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sonata_seo');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('encoding')->defaultValue('UTF-8')->end()
                ->arrayNode('page')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default')->defaultValue('sonata.seo.page.default')->end()
                        ->arrayNode('head')
                            ->normalizeKeys(false)
                            ->useAttributeAsKey('attribute')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('metas')
                            ->normalizeKeys(false)
                            ->useAttributeAsKey('element')
                            ->prototype('array')
                                ->normalizeKeys(false)
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                        ->scalarNode('separator')->defaultValue(' - ')->end()
                        // NEXT_MAJOR: Make this field required
                        ->scalarNode('title')->defaultValue('Project name')->end()
                    ->end()
                ->end()
                ->arrayNode('sitemap')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('doctrine_orm')
                            ->prototype('variable')->end()
                        ->end()
                        ->arrayNode('services')
                            ->prototype('variable')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        $this->addHttpClientSection($rootNode);

        return $treeBuilder;
    }

    private function addHttpClientSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('http')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('client')
                            ->defaultNull()
                            ->info('Alias of the http client.')
                        ->end()
                        ->scalarNode('message_factory')
                            ->defaultNull()
                            ->info('Alias of the message factory.')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
