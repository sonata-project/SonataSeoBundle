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
use Sonata\SeoBundle\Seo\SeoPage;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ServiceCompilerPassTest extends TestCase
{
    public function testServicesExistsAndCanBeOverridden()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', []);

        $container->register('sonata.seo.custom.page', SeoPage::class);

        $config = [
            'page' => [
                'default' => 'sonata.seo.custom.page',
            ],
        ];

        $extension = new SonataSeoExtension();
        $extension->load([$config], $container);

        (new ServiceCompilerPass())->process($container);

        static::assertTrue($service = $container->has('sonata.seo.page'));
        static::assertTrue($alias = $container->has(SeoPageInterface::class));
        static::assertSame($service, $alias);

        static::assertInstanceOf(SeoPage::class, $container->get(SeoPageInterface::class));
    }
}
