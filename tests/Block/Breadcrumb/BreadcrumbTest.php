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
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Twig\Environment;

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
}
