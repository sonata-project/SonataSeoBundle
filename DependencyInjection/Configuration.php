<?php

namespace Sonata\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sonata_seo');

        $rootNode
            ->children()
                ->arrayNode('page')
                    ->scalarNode('encoding')->defaultValue('UTF-8')->end()
                    ->scalarNode('default')->defaultValue('sonata.seo.page.default')->end()
                    ->scalarNode('separator')->defaultValue(' - ')->end()
                    ->scalarNode('title')->defaultValue('Sonata Project')->end()
                    ->arrayNode('metas')
                        ->useAttributeAsKey('id')
                        ->prototype('array')
                            ->useAttributeAsKey('id')
                            ->prototype('variable')->end()
                        ->end()
                    ->end()
                    ->arrayNode('head')
                        ->useAttributeAsKey('id')
                        ->children()
                            ->arrayNode('attributes')
                                ->useAttributeAsKey('id')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
