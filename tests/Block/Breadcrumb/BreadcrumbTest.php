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
use Knp\Menu\MenuFactory;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

final class BreadcrumbMenuBlockService_Test extends BaseBreadcrumbMenuBlockService
{
    protected function getContext(): string
    {
        return 'test';
    }

    protected function getMenu(BlockContextInterface $blockContext): ItemInterface
    {
        return $this->getRootMenu($blockContext);
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
            $this->createMock(Environment::class),
            $this->createMock(FactoryInterface::class)
        );

        static::assertTrue($blockService->handleContext('test'));
    }

    public function testGetMenu(): void
    {
        static::markTestSkipped(
            'Skipped until https://github.com/sonata-project/SonataSeoBundle/issues/446 is resolved'
        );
        $blockService = new BreadcrumbMenuBlockService_Test(
            new Environment(new ArrayLoader([
                'breadcrumbs.txt.twig' => 'This is a breadcrumbs with URI {{ menu.uri }}',
            ])),
            new MenuFactory()
        );

        $context = new BlockContext(
            $this->createStub(BlockInterface::class),
            [
                'current_uri' => '/foo/bar',
                'include_homepage_link' => false,
                'cache_policy' => 'public',
                'template' => 'breadcrumbs.txt.twig',
            ]
        );
        static::assertStringContainsString(
            '/foo/bar',
            $blockService->execute($context)->getContent()
        );
    }
}
