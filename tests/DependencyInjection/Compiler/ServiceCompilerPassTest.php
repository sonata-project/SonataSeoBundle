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

namespace Sonata\SeoBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\DependencyInjection\Compiler\BreadcrumbBlockServicesCompilerPass;
use Sonata\SeoBundle\DependencyInjection\Compiler\ServiceCompilerPass;
use Sonata\SeoBundle\DependencyInjection\SonataSeoExtension;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Sonata\SeoBundle\Tests\Stubs\SeoPageStub;
use Sonata\SeoBundle\Tests\Stubs\SeoPageWithoutTitleInterfaceStub;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServiceCompilerPassTest extends TestCase
{
    public function testServicesExistsAndCanBeOverridden()
    {
        $container = new ContainerBuilder();
        $container->register('sonata.seo.custom.page', SeoPageStub::class);
        $config = [
            'page' => [
                'default' => 'sonata.seo.custom.page',
            ],
        ];

        $container->addCompilerPass(
            new AlterAliasOrDefinitionPublicationPass(SeoPageInterface::class),
            PassConfig::TYPE_BEFORE_REMOVING
        );

        $this->processConfiguration($config, $container);

        $this->assertTrue($service = $container->has('sonata.seo.page'));
        $this->assertTrue($alias = $container->has(SeoPageInterface::class));
        $this->assertSame($service, $alias);

        $this->assertInstanceOf(SeoPageStub::class, $container->get(SeoPageInterface::class));
    }

    public function testServiceWithoutTitleInterfaceApplied()
    {
        $container = new ContainerBuilder();
        $container->register('sonata.seo.custom.page', SeoPageWithoutTitleInterfaceStub::class);
        $config = [
            'page' => [
                'default' => 'sonata.seo.custom.page',
            ],
        ];

        $this->processConfiguration($config, $container);

        $container->get('sonata.seo.page');
    }

    public function testSimpleTitleConfiguration()
    {
        $container = new ContainerBuilder();
        $config = [
            'page' => [
                'title' => 'My Title',
            ],
        ];
        $this->processConfiguration($config, $container);

        $page = $container->get('sonata.seo.page');
        $this->assertEquals('My Title', $page->getTitle());
    }

    public function testAdvancedTitleConfiguration()
    {
        $container = new ContainerBuilder();

        $config = [
            'page' => [
                'title' => [
                    'prefix' => 'Prefix',
                    'suffix' => 'My Title',
                ],
            ],
        ];
        $this->processConfiguration($config, $container);

        $page = $container->get('sonata.seo.page');
        $this->assertEquals('Prefix - My Title', $page->getTitle());
    }

    private function processConfiguration(array $config, ContainerBuilder $container)
    {
        $container->setParameter('kernel.bundles', []);

        $container->registerExtension($extension = new SonataSeoExtension());

        $container->loadFromExtension($extension->getAlias(), $config);

        $container
            ->addCompilerPass(new ServiceCompilerPass())
            ->addCompilerPass(new BreadcrumbBlockServicesCompilerPass());

        $container->compile();
    }
}
