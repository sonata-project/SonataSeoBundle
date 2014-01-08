<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\Block;

use Sonata\SeoBundle\Block\BaseBreadcrumbMenuBlockService;
use Sonata\SeoBundle\Menu\BaseBreadcrumbMenuBuilder;

class BreadcrumbMenuBlockService_Test extends BaseBreadcrumbMenuBlockService {}
class BreadcrumbMenuBuilder_Test extends BaseBreadcrumbMenuBuilder {}

/**
 * @author Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
class BreadcrumbTest extends BaseBlockTest
{
    public function testBlockService()
    {
        $blockService = new BreadcrumbMenuBlockService_Test(
            'context',
            'name',
            $this->getMock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface'),
            $this->getMock('Knp\Menu\Provider\MenuProviderInterface'),
            $this->getMock('Sonata\SeoBundle\Menu\BreadcrumbMenuBuilderInterface')
        );

        $this->assertTrue($blockService->handleContext('context'));
    }

    public function testMenuBuilder()
    {
        $factory = $this->getMock('Knp\Menu\FactoryInterface');

        $factory->expects($this->any())->method('createItem')->will($this->returnValue($this->getMock('Knp\Menu\ItemInterface')));

        $menuBuilder = new BreadcrumbMenuBuilder_Test(
            $factory,
            $this->getMock('Symfony\Component\Translation\TranslatorInterface')
        );

        $menu = $menuBuilder->getRootMenu(false);

        $this->assertInstanceOf('Knp\Menu\ItemInterface', $menu);
    }
}
