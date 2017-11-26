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

use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use PHPUnit\Framework\TestCase;
use Sonata\BlockBundle\Menu\MenuRegistryInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class BaseBreadcrumbMenuBlockServiceTest extends TestCase
{
    /**
     * @group legacy
     * @expectedDeprecation Calling "Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService::__construct" without a "Sonata\BlockBundle\Menu\MenuRegistryInterface" argument is deprecated since 2.x and will no longer be possible in 3.0.
     */
    public function testConstructorLegacy()
    {
        $this->getMockForAbstractClass(
            BaseBreadcrumbMenuBlockService::class,
            [
                'my_context',
                'some name',
                $this->createMock(EngineInterface::class),
                $this->createMock(MenuProviderInterface::class),
                $this->createMock(FactoryInterface::class),
            ]
        );
    }

    public function testItSInitializable()
    {
        $this->assertInstanceOf(
            BaseBreadcrumbMenuBlockService::class,
            $blockService = $this->getMockForAbstractClass(
                BaseBreadcrumbMenuBlockService::class,
                [
                    'my_context',
                    'some name',
                    $this->createMock(EngineInterface::class),
                    $this->createMock(MenuProviderInterface::class),
                    $this->createMock(FactoryInterface::class),
                    $this->createMock(MenuRegistryInterface::class),
                ]
            )
        );

        $this->assertTrue($blockService->handleContext('my_context'));
    }
}
