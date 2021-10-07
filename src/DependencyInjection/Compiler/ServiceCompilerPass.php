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

namespace Sonata\SeoBundle\DependencyInjection\Compiler;

use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Christian Gripp <mail@core23.de>
 */
final class ServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        /** @var array<string, mixed> $config */
        $config = $container->getParameter('sonata.seo.config');

        $definition = $container->findDefinition($config['default']);

        $definition->addMethodCall('setTitle', [$config['title']]);
        if (null !== $config['title_prefix']) {
            $definition->addMethodCall('addTitlePrefix', [$config['title_prefix']]);
        }
        if (null !== $config['title_suffix']) {
            $definition->addMethodCall('addTitleSuffix', [$config['title_suffix']]);
        }

        $definition->addMethodCall('setMetas', [$config['metas']]);
        $definition->addMethodCall('setHtmlAttributes', [$config['head']]);
        $definition->addMethodCall('setSeparator', [$config['separator']]);

        $container->setAlias('sonata.seo.page', $config['default'])->setPublic(true);
        $container->setAlias(SeoPageInterface::class, $config['default']);
    }
}
