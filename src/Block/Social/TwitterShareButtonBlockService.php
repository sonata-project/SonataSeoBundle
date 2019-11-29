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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Twitter share button integration.
 *
 * @see https://about.twitter.com/resources/buttons#tweet
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
final class TwitterShareButtonBlockService extends BaseTwitterButtonBlockService implements EditableBlockService
{
    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'template' => '@SonataSeo/Block/block_twitter_share_button.html.twig',
            'url' => null,
            'text' => null,
            'show_count' => true,
            'via' => null,
            'recommend' => null,
            'hashtag' => null,
            'large_button' => false,
            'opt_out' => false,
            'language' => $this->languageList['en'],
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
                ['text', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_text',
                ]],
                ['show_count', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_show_count',
                ]],
                ['via', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_via',
                ]],
                ['recommend', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_recommend',
                ]],
                ['hashtag', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_hashtag',
                ]],
                ['large_button', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_large_button',
                ]],
                ['opt_out', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_opt_out',
                ]],
                ['language', ChoiceType::class, [
                    'required' => true,
                    'choices' => $this->languageList,
                    'label' => 'form.label_language',
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
        return new Metadata('sonata.seo.block.twitter.share_button', null, null, 'SonataSeoBundle', [
            'class' => 'fa fa-twitter',
        ]);
    }
}
