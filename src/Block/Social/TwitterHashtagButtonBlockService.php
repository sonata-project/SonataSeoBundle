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
use Sonata\CoreBundle\Model\Metadata;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Twitter hashtag button integration.
 *
 * @see https://about.twitter.com/resources/buttons#hashtag
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class TwitterHashtagButtonBlockService extends BaseTwitterButtonBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => 'SonataSeoBundle:Block:block_twitter_hashtag_button.html.twig',
            'url' => null,
            'hashtag' => null,
            'text' => null,
            'recommend' => null,
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
        $formMapper->add('settings', 'sonata_type_immutable_array', [
            'keys' => [
                ['hashtag', 'text', [
                    'required' => true,
                    'label' => 'form.label_hashtag',
                ]],
                ['text', 'text', [
                    'required' => false,
                    'label' => 'form.label_text',
                ]],
                ['recommend', 'text', [
                    'required' => false,
                    'label' => 'form.label_recommend',
                ]],
                ['url', 'url', [
                    'required' => false,
                    'label' => 'form.label_url',
                ]],
                ['large_button', 'checkbox', [
                    'required' => false,
                    'label' => 'form.label_large_button',
                ]],
                ['opt_out', 'checkbox', [
                    'required' => false,
                    'label' => 'form.label_opt_out',
                ]],
                ['language', 'choice', [
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
        return new Metadata($this->getName(), (!is_null($code) ? $code : $this->getName()), false, 'SonataSeoBundle', [
            'class' => 'fa fa-twitter',
        ]);
    }
}
