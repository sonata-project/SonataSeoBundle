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

namespace Sonata\SeoBundle\Tests\Block\Breadcrumb;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Sonata\BlockBundle\Test\AbstractBlockServiceTestCase;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

final class BreadcrumbMenuBlockService_Test extends BaseBreadcrumbMenuBlockService
{
}

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
final class BreadcrumbTest extends AbstractBlockServiceTestCase
{
    public function testBlockService(): void
    {
        $blockService = new BreadcrumbMenuBlockService_Test(
            'context',
            'name',
            $this->createMock(EngineInterface::class),
            $this->createMock(MenuProviderInterface::class),
            $this->createMock(FactoryInterface::class)
        );

        $this->assertTrue($blockService->handleContext('context'));
    }
}
