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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

/**
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

    final public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        $responseSettings = [
            'menu' => $this->getMenu($blockContext),
            'menu_options' => $this->getMenuOptions($blockContext->getSettings()),
            'block' => $blockContext->getBlock(),
            'context' => $blockContext,
        ];

        $template = $blockContext->getTemplate();

        \assert(\is_string($template));

        if ('private' === $blockContext->getSetting('cache_policy')) {
            return $this->renderPrivateResponse($template, $responseSettings, $response);
        }

        return $this->renderResponse($template, $responseSettings, $response);
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
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
        ]);
    }

    protected function getMenu(BlockContextInterface $blockContext): ItemInterface
    {
        $settings = $blockContext->getSettings();

        $menu = $this->factory->createItem('breadcrumb');
        $menu->setChildrenAttribute('class', 'breadcrumb');
        $menu->setCurrent(true);
        $menu->setUri($settings['current_uri']);

        if (true === $settings['include_homepage_link']) {
            $menu->addChild('sonata_seo_homepage_breadcrumb', ['uri' => '/']);
        }

        return $menu;
    }

    final protected function getFactory(): FactoryInterface
    {
        return $this->factory;
    }

    /**
     * Replaces setting keys with knp menu item options keys.
     *
     * @param array<string, mixed> $settings
     *
     * @return array<string, mixed>
     */
    private function getMenuOptions(array $settings): array
    {
        $mapping = [
            'current_class' => 'currentClass',
            'first_class' => 'firstClass',
            'last_class' => 'lastClass',
            'safe_labels' => 'allow_safe_labels',
            'menu_template' => 'template',
        ];

        $options = [];

        foreach ($settings as $key => $value) {
            if (null !== $value && \array_key_exists($key, $mapping)) {
                $options[$mapping[$key]] = $value;
            }
        }

        return $options;
    }
}
