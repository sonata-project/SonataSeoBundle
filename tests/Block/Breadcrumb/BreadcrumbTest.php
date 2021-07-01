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
use Knp\Menu\MenuFactory;
use Knp\Menu\Provider\MenuProviderInterface;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Templating\TemplateNameParser;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

final class BreadcrumbMenuBlockService_Test extends BaseBreadcrumbMenuBlockService
{
    protected function getMenu(BlockContextInterface $blockContext)
    {
        return $this->getRootMenu($blockContext);
    }
}

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
final class BreadcrumbTest extends BlockServiceTestCase
{
    public function testBlockService()
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

    public function testGetMenu(): void
    {
        $blockService = new BreadcrumbMenuBlockService_Test(
            'context',
            'name',
            new TwigEngine(
                new Environment(new ArrayLoader([
                    'breadcrumbs.txt.twig' => 'This is a breadcrumbs with URI {{ menu.uri }}',
                ])),
                new TemplateNameParser(),
                new FileLocator()
            ),
            $this->createStub(MenuProviderInterface::class),
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
        self::assertStringContainsString(
            '/foo/bar',
            $blockService->execute($context)->getContent()
        );
    }
}
