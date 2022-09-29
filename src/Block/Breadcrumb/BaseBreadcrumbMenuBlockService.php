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
use Sonata\BlockBundle\Block\Service\AbstractMenuBlockService;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Meta\MetadataInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseBreadcrumbMenuBlockService extends AbstractMenuBlockService implements BreadcrumbBlockService
{
    private FactoryInterface $factory;

    public function __construct(Environment $twig, FactoryInterface $factory)
    {
        parent::__construct($twig);

        $this->factory = $factory;
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        parent::configureSettings($resolver);

        $resolver->setDefaults([
            'menu_template' => '@SonataSeo/Block/breadcrumb.html.twig',
            'include_homepage_link' => true,
            'current_uri' => null,
            'context' => null,
        ]);
    }

    /**
     * NEXT_MAJOR: Remove this method.
     */
    public function getMetadata(): MetadataInterface
    {
        return new Metadata('sonata.block.service.menu', null, null, 'SonataBlockBundle', [
            'class' => 'fa fa-bars',
        ]);
    }

    protected function getFormSettingsKeys(): array
    {
        return array_merge(
            parent::getFormSettingsKeys(),
            [
                ['include_homepage_link', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_include_homepage_link',
                    'translation_domain' => 'SonataSeoBundle',
                ]],
                ['current_uri', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_current_uri',
                    'translation_domain' => 'SonataSeoBundle',
                ]],
                ['context', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_context',
                    'translation_domain' => 'SonataSeoBundle',
                ]],
            ]
        );
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
}
