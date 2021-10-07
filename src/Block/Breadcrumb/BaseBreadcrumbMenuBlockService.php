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

namespace Sonata\SeoBundle\Block\Breadcrumb;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

/**
 * Abstract class for breadcrumb menu services.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseBreadcrumbMenuBlockService extends AbstractBlockService implements BreadcrumbBlockService
{
    private FactoryInterface $factory;

    public function __construct(Environment $twig, FactoryInterface $factory)
    {
        parent::__construct($twig);

        $this->factory = $factory;
    }

    public function handleContext(string $context): bool
    {
        return $this->getContext() === $context;
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        parent::configureSettings($resolver);

        $resolver->setDefaults([
            'menu_template' => '@SonataSeo/Block/breadcrumb.html.twig',
            'include_homepage_link' => true,
            'context' => false,
        ]);
    }

    final protected function getFactory(): FactoryInterface
    {
        return $this->factory;
    }

    abstract protected function getContext(): string;

    /**
     * Initialize breadcrumb menu.
     */
    protected function getRootMenu(BlockContextInterface $blockContext): ItemInterface
    {
        $settings = $blockContext->getSettings();
        /*
         * @todo : Use the router to get the homepage URI
         */

        $menu = $this->factory->createItem('breadcrumb');

        $menu->setChildrenAttribute('class', 'breadcrumb');

        if (method_exists($menu, 'setCurrentUri')) {
            $menu->setCurrentUri($settings['current_uri']);
        }

        $menu->setCurrent(true);
        $menu->setUri($settings['current_uri']);

        if ($settings['include_homepage_link']) {
            $menu->addChild('sonata_seo_homepage_breadcrumb', ['uri' => '/']);
        }

        return $menu;
    }
}
