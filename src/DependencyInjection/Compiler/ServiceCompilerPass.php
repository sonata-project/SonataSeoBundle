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
use Sonata\SeoBundle\Seo\SeoTitleInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Christian Gripp <mail@core23.de>
 */
final class ServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('sonata.seo.config');

        $definition = $container->findDefinition($config['default']);

        $definitionClass = $this->getDefinitionClassname($container, $definition);
        if (is_subclass_of($definitionClass, SeoTitleInterface::class)) {
            $definition->addMethodCall('setTitlePrefix', [$config['title']['prefix']]);
            $definition->addMethodCall('setTitleSuffix', [$config['title']['suffix']]);
        } else {
            $definition->addMethodCall('setTitle', [$config['title']['suffix']]);
        }

        $definition->addMethodCall('setMetas', [$config['metas']]);
        $definition->addMethodCall('setHtmlAttributes', [$config['head']]);
        $definition->addMethodCall('setSeparator', [$config['separator']]);

        if ($alias = $container->setAlias('sonata.seo.page', $config['default'])) {
            $alias->setPublic(true);
        }

        $container->setAlias(SeoPageInterface::class, $config['default']);
    }

    private function getDefinitionClassname(ContainerBuilder $container, Definition $definition): ?string
    {
        $definitionClass = $definition->getClass();

        if (class_exists($definitionClass)) {
            return $definitionClass;
        }

        if (!$container->hasParameter(trim($definitionClass, '%'))) {
            return null;
        }

        $definition = new Definition($container->getParameter(trim($definitionClass, '%')));

        return $this->getDefinitionClassname($container, $definition);
    }
}
