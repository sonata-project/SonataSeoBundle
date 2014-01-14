<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Block\Social;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template'     => 'SonataSeoBundle:Block:block_twitter_share_button.html.twig',
            'url'          => null,
            'text'         => null,
            'show_count'   => true,
            'via'          => null,
            'recommend'    => null,
            'hashtag'      => null,
            'large_button' => false,
            'opt_out'      => false,
            'language'     => $this->languageList['en'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('url',          'url',      array('required' => false)),
                array('text',         'text',     array('required' => false)),
                array('show_count',   'checkbox', array('required' => false)),
                array('via',          'text',     array('required' => false)),
                array('recommend',    'text',     array('required' => false)),
                array('hashtag',      'text',     array('required' => false)),
                array('large_button', 'checkbox', array('required' => false)),
                array('opt_out',      'checkbox', array('required' => false)),
                array('language',     'choice',   array('required' => true, 'choices' => $this->languageList)),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Twitter button - Share link';
    }
}
