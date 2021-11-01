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
use Knp\Menu\ItemInterface;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class BreadcrumbMenuBlockService_Test extends BaseBreadcrumbMenuBlockService
{
    public function handleContext(string $context): bool
    {
        return true;
    }
}

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
final class BreadcrumbTest extends BlockServiceTestCase
{
    public function testBlockService(): void
    {
        $blockService = new BreadcrumbMenuBlockService_Test(
            $this->createStub(Environment::class),
            $this->createStub(FactoryInterface::class)
        );

        static::assertTrue($blockService->handleContext('test'));
    }

    public function testBlockExectute(): void
    {
        $menuFactory = $this->createMock(FactoryInterface::class);

        $blockService = new BreadcrumbMenuBlockService_Test(
            $this->createStub(Environment::class),
            $menuFactory
        );

        $menu = $this->createStub(ItemInterface::class);
        $menuFactory->expects(static::once())->method('createItem')->with('breadcrumb')
            ->willReturn($menu);

        $blockContext = new BlockContext(new Block(), [
            'current_uri' => null,
            'include_homepage_link' => false,
            'cache_policy' => 'public',
            'template' => '@SonataBlock/Block/block_core_menu.html.twig',
        ]);
        $blockService->execute($blockContext, new Response());
    }

    public function testDefaultSettings(): void
    {
        $blockService = new BreadcrumbMenuBlockService_Test(
            $this->createStub(Environment::class),
            $this->createStub(FactoryInterface::class)
        );

        $blockContext = $this->getBlockContext($blockService);

        $this->assertSettings([
            'cache_policy' => 'public',
            'template' => '@SonataBlock/Block/block_core_menu.html.twig',
            'safe_labels' => false,
            'current_class' => 'active',
            'first_class' => false,
            'last_class' => false,
            'current_uri' => null,
            'menu_class' => 'list-group',
            'children_class' => 'list-group-item',
            'menu_template' => '@SonataSeo/Block/breadcrumb.html.twig',
            'include_homepage_link' => true,
            'context' => null,
        ], $blockContext);
    }
}
