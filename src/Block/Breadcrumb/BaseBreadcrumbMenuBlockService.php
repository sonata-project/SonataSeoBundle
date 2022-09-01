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
use Sonata\BlockBundle\Block\Service\EditableBlockService;
use Sonata\BlockBundle\Block\Service\MenuBlockService;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Meta\MetadataInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseBreadcrumbMenuBlockService extends AbstractBlockService implements EditableBlockService, BreadcrumbBlockService
{
    private MenuBlockService $menuBlock;

    private FactoryInterface $factory;

    public function __construct(Environment $twig, MenuBlockService $menuBlock, FactoryInterface $factory)
    {
        parent::__construct($twig);

        $this->menuBlock = $menuBlock;
        $this->factory = $factory;
    }

    final public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        $template = $blockContext->getTemplate();
        \assert(null !== $template);

        $responseSettings = [
            'menu' => $this->getMenu($blockContext),
            'menu_options' => $this->getMenuOptions($blockContext->getSettings()),
            'block' => $blockContext->getBlock(),
            'context' => $blockContext,
        ];

        return $this->renderResponse($template, $responseSettings, $response);
    }

    final public function configureCreateForm(FormMapper $form, BlockInterface $block): void
    {
        $this->menuBlock->configureCreateForm($form, $block);
    }

    final public function configureEditForm(FormMapper $form, BlockInterface $block): void
    {
        $this->menuBlock->configureEditForm($form, $block);
    }

    public function getMetadata(): MetadataInterface
    {
        return $this->menuBlock->getMetadata();
    }

    final public function validate(ErrorElement $errorElement, BlockInterface $block): void
    {
        $this->menuBlock->validate($errorElement, $block);
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $this->menuBlock->configureSettings($resolver);

        $resolver->setDefaults([
            'menu_template' => '@SonataSeo/Block/breadcrumb.html.twig',
            'include_homepage_link' => true,
            'context' => null,
        ]);
    }

    abstract public function handleContext(string $context): bool;

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
            if (\array_key_exists($key, $mapping) && null !== $value) {
                $options[$mapping[$key]] = $value;
            }
        }

        return $options;
    }
}
