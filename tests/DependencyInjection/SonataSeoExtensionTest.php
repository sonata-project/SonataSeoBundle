<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\DependencyInjection\SonataSeoExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Tests SonataSeoExtension.
 *
 * @author Vincent Tommasi <tommasi.v@gmail.com>
 */
class SonataSeoExtensionTest extends TestCase
{
    /**
     * Tests the loading of blocks.xml file.
     */
    public function testBlocksLoading()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', [
            'SonataBlockBundle' => 'Sonata\BlockBundle\SonataBlockBundle',
            'KnpMenuBundle' => 'Knp\Bundle\MenuBundle\KnpMenuBundle',
        ]);

        $extension = new SonataSeoExtension();
        $extension->load([[]], $container);

        $this->assertTrue($container->hasDefinition('sonata.seo.block.breadcrumb.homepage'));

        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', []);
        $extension->load([[]], $container);

        $this->assertFalse($container->hasDefinition('sonata.seo.block.breadcrumb.homepage'));
    }
}
