<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Block\Social;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Sonata\CoreBundle\Model\Metadata;
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
class TwitterShareButtonBlockService extends BaseTwitterButtonBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => 'SonataSeoBundle:Block:block_twitter_share_button.html.twig',
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

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', ImmutableArrayType::class, [
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

    /**
     * {@inheritdoc}
     */
    public function getBlockMetadata($code = null)
    {
        return new Metadata($this->getName(), (null !== $code ? $code : $this->getName()), false, 'SonataSeoBundle', [
            'class' => 'fa fa-twitter',
        ]);
    }
}
