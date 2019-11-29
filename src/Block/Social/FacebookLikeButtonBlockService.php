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

namespace Sonata\SeoBundle\Block\Social;

use Sonata\BlockBundle\Block\Service\EditableBlockService;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Meta\MetadataInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Type\ImmutableArrayType;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Facebook like button integration.
 *
 * @see https://developers.facebook.com/docs/plugins/like-button/
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
final class FacebookLikeButtonBlockService extends BaseFacebookSocialPluginsBlockService implements EditableBlockService
{
    /**
     * @var string[]
     */
    protected $layoutList = [
        'standard' => 'form.label_layout_standard',
        'box_count' => 'form.label_layout_box_count',
        'button_count' => 'form.label_layout_button_count',
        'button' => 'form.label_layout_button',
    ];

    /**
     * @var string[]
     */
    protected $actionTypes = [
        'like' => 'form.label_action_like',
        'recommend' => 'form.label_action_recommend',
    ];

    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'template' => '@SonataSeo/Block/block_facebook_like_button.html.twig',
            'url' => null,
            'width' => null,
            'show_faces' => true,
            'share' => true,
            'layout' => $this->layoutList['standard'],
            'colorscheme' => $this->colorschemeList['light'],
            'action' => $this->actionTypes['like'],
        ]);
    }

    public function configureCreateForm(FormMapper $form, BlockInterface $block): void
    {
        $this->configureEditForm($form, $block);
    }

    public function configureEditForm(FormMapper $form, BlockInterface $block): void
    {
        $form->add('settings', ImmutableArrayType::class, [
            'keys' => [
                ['url', UrlType::class, [
                    'required' => false,
                    'label' => 'form.label_url',
                ]],
                ['width', IntegerType::class, [
                    'required' => false,
                    'label' => 'form.label_width',
                ]],
                ['show_faces', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_show_faces',
                ]],
                ['share', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_share',
                ]],
                ['layout', ChoiceType::class, [
                    'required' => true,
                    'choices' => $this->layoutList,
                    'label' => 'form.label_layout',
                ]],
                ['colorscheme', ChoiceType::class, [
                    'required' => true,
                    'choices' => $this->colorschemeList,
                    'label' => 'form.label_colorscheme',
                ]],
                ['action', ChoiceType::class, [
                    'required' => true,
                    'choices' => $this->actionTypes,
                    'label' => 'form.label_action',
                ]],
            ],
            'translation_domain' => 'SonataSeoBundle',
        ]);
    }

    public function validate(ErrorElement $errorElement, BlockInterface $block): void
    {
    }

    public function getMetadata(): MetadataInterface
    {
        return new Metadata('sonata.seo.block.facebook.like_button', null, null, 'SonataSeoBundle', [
            'class' => 'fa fa-facebook-official',
        ]);
    }
}
