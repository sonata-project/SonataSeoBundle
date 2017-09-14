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
 * Twitter mention button integration.
 *
 * @see https://about.twitter.com/resources/buttons#mention
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class TwitterMentionButtonBlockService extends BaseTwitterButtonBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'SonataSeoBundle:Block:block_twitter_mention_button.html.twig',
            'user' => null,
            'text' => null,
            'recommend' => null,
            'large_button' => false,
            'opt_out' => false,
            'language' => $this->languageList['en'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('user', 'text', array(
                    'required' => true,
                    'label' => 'form.label_user',
                )),
                array('text', 'text', array(
                    'required' => false,
                    'label' => 'form.label_text',
                )),
                array('recommend', 'text', array(
                    'required' => false,
                    'label' => 'form.label_recommend',
                )),
                array('large_button', 'checkbox', array(
                    'required' => false,
                    'label' => 'form.label_large_button',
                )),
                array('opt_out', 'checkbox', array(
                    'required' => false,
                    'label' => 'form.label_opt_out',
                )),
                array('language', 'choice', array(
                    'required' => true,
                    'choices' => $this->languageList,
                    'label' => 'form.label_language',
                )),
            ),
            'translation_domain' => 'SonataSeoBundle',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockMetadata($code = null)
    {
        return new Metadata($this->getName(), (!is_null($code) ? $code : $this->getName()), false, 'SonataSeoBundle', array(
            'class' => 'fa fa-twitter',
        ));
    }
}
