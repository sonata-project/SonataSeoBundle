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

use Sonata\SeoBundle\DependencyInjection\SonataSeoExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Tests SonataSeoExtension.
 *
 * @author Vincent Tommasi <tommasi.v@gmail.com>
 */
class SonataSeoExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the loading of blocks.xml file.
     */
    public function testBlocksLoading()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', array(
            'SonataBlockBundle' => 'Sonata\BlockBundle\SonataBlockBundle',
            'KnpMenuBundle' => 'Knp\Bundle\MenuBundle\KnpMenuBundle',
        ));

        $extension = new SonataSeoExtension();
        $extension->load(array(array()), $container);

        $this->assertTrue($container->hasDefinition('sonata.seo.block.breadcrumb.homepage'));

        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', array());
        $extension->load(array(array()), $container);

        $this->assertFalse($container->hasDefinition('sonata.seo.block.breadcrumb.homepage'));
    }
}
