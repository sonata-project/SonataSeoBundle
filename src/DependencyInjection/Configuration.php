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
        $treeBuilder = new TreeBuilder('sonata_seo');

        // Keep compatibility with symfony/config < 4.2
        if (!method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->root('sonata_seo');
        } else {
            $rootNode = $treeBuilder->getRootNode();
        }

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
                        ->arrayNode('title')
                            ->beforeNormalization()
                                ->ifString()
                                ->then(function ($v) {return ['suffix' => $v]; })
                            ->end()
                            ->addDefaultsIfNotSet()
                            ->treatNullLike(['suffix' => ''])
                            ->children()
                                ->scalarNode('prefix')->defaultValue('')->treatNullLike('')->end()
                                ->scalarNode('suffix')->defaultValue('Project name')->treatNullLike('')->end()
                            ->end()
                        ->end()
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
            ->end()
        ;

        return $treeBuilder;
    }
}
