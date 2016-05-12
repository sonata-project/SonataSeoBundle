<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\Block\Breadcrumb;

use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Sonata\SeoBundle\Tests\Block\BaseBlockTest;

class BreadcrumbMenuBlockService_Test extends BaseBreadcrumbMenuBlockService
{
}

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
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
            $this->getMock('Knp\Menu\FactoryInterface')
        );

        $this->assertTrue($blockService->handleContext('context'));
    }
}
