<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class BreadcrumbBlockServicesCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $listener = $container->getDefinition('sonata.seo.event.breadcrumb');

        foreach ($container->findTaggedServiceIds('sonata.breadcrumb') as $id => $tags) {
            foreach ($tags as $tag) {
                if (empty($tag['context'])) {
                    continue;
                }

                $listener->addMethodCall('addBlockContext', [$tag['context'], $id]);
            }

            $listener->addMethodCall('addBlockService', [$id, new Reference($id)]);
        }
    }
}
