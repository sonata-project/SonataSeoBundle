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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('sonata_seo')
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
                        ->scalarNode('title')->defaultValue('Sonata Project')->end()
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
                ->arrayNode('robotstxt')
                    ->info('Array of robots.txt sections')
                    ->prototype('array')
                        ->normalizeKeys(false)
                        ->validate()
                           ->always(function ($v) {
                               if (empty($v['sitemap'])){
                                   unset($v['sitemap']);
                               }
                               
                               return $v;
                           })
                        ->end()
                        ->children()
                            ->arrayNode('user-agent')
                                ->info('Array of User-Agent such as *, googlebot, ...')
                                ->isRequired()
                                ->prototype('scalar')->end()
                            ->end()
                            ->integerNode('crawl-delay')
                                ->info('The crawl-delay value is supported by some crawlers to throttle their visits to the host')
                                ->min(0)
                            ->end()
                            ->arrayNode('access-control')
                                ->info('Array of disallow or allow directives')
                                ->isRequired()
                                ->prototype('variable')->end()
                            ->end()
                            ->arrayNode('sitemap')
                                ->info('Array of sitemap links')
                                ->prototype('scalar')->defaultNull()->end()
                            ->end()
                            ->scalarNode('host')
                                ->info('Allowing websites with multiple mirrors to specify their preferred domain')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
