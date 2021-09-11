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

use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\DependencyInjection\Compiler\ServiceCompilerPass;
use Sonata\SeoBundle\DependencyInjection\SonataSeoExtension;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Sonata\SeoBundle\Tests\Stubs\SeoPageStub;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServiceCompilerPassTest extends TestCase
{
    public function testServicesExistsAndCanBeOverridden()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', []);

        $container->register('sonata.seo.custom.page', SeoPageStub::class);

        $config = [
            'page' => [
                'default' => 'sonata.seo.custom.page',
            ],
        ];

        $extension = new SonataSeoExtension();
        $extension->load([$config], $container);

        (new ServiceCompilerPass())->process($container);

        static::assertTrue($container->has('sonata.seo.page'));
        static::assertTrue($container->has(SeoPageInterface::class));
        static::assertSame($container->get('sonata.seo.page'), $container->get(SeoPageInterface::class));

        static::assertInstanceOf(SeoPageStub::class, $container->get(SeoPageInterface::class));
    }
}
