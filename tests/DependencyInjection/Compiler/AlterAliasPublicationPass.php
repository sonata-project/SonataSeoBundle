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

namespace Sonata\SeoBundle\Tests\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AlterAliasPublicationPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $service;

    public function __construct(string $service)
    {
        $this->service = $service;
    }

    public function process(ContainerBuilder $container)
    {
        if (null === $definition = $this->getDefinitionOrAlias($container)) {
            return;
        }

        $definition->setPublic(true);
    }

    private function getDefinitionOrAlias(ContainerBuilder $container)
    {
        if ($container->hasAlias($this->service)) {
            return $container->getAlias($this->service);
        }

        if ($container->hasDefinition($this->service)) {
            return $container->getDefinition($this->service);
        }

        return null;
    }
}
