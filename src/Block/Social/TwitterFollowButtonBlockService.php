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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Twitter follow button integration.
 *
 * @see https://about.twitter.com/resources/buttons#follow
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class TwitterFollowButtonBlockService extends BaseTwitterButtonBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => '@SonataSeo/Block/block_twitter_follow_button.html.twig',
            'user' => null,
            'show_username' => true,
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
                ['user', TextType::class, [
                    'required' => true,
                    'label' => 'form.label_user',
                ]],
                ['show_username', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_show_username',
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
