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

final class AlterAliasOrDefinitionPublicationPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $service;

    public function __construct(string $service)
    {
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasAlias($this->service)) {
            $container->getAlias($this->service)->setPublic(true);
            return;
        }

        if ($container->hasDefinition($this->service)){
            $container->getDefinition($this->service)->setPublic(true);
            return;
        }

        return;
    }
}
