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
 * Facebook like button integration.
 *
 * @see https://developers.facebook.com/docs/plugins/like-button/
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class FacebookLikeButtonBlockService extends BaseFacebookSocialPluginsBlockService
{
    /**
     * @var string[]
     */
    protected $layoutList = array(
        'standard' => 'form.label_layout_standard',
        'box_count' => 'form.label_layout_box_count',
        'button_count' => 'form.label_layout_button_count',
        'button' => 'form.label_layout_button',
    );

    /**
     * @var string[]
     */
    protected $actionTypes = array(
        'like' => 'form.label_action_like',
        'recommend' => 'form.label_action_recommend',
    );

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'SonataSeoBundle:Block:block_facebook_like_button.html.twig',
            'url' => null,
            'width' => null,
            'show_faces' => true,
            'share' => true,
            'layout' => $this->layoutList['standard'],
            'colorscheme' => $this->colorschemeList['light'],
            'action' => $this->actionTypes['like'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('url', 'url', array(
                    'required' => false,
                    'label' => 'form.label_url',
                )),
                array('width', 'integer', array(
                    'required' => false,
                    'label' => 'form.label_width',
                )),
                array('show_faces', 'checkbox', array(
                    'required' => false,
                    'label' => 'form.label_show_faces',
                )),
                array('share', 'checkbox', array(
                    'required' => false,
                    'label' => 'form.label_share',
                )),
                array('layout', 'choice', array(
                    'required' => true,
                    'choices' => $this->layoutList,
                    'label' => 'form.label_layout',
                )),
                array('colorscheme', 'choice', array(
                    'required' => true,
                    'choices' => $this->colorschemeList,
                    'label' => 'form.label_colorscheme',
                )),
                array('action', 'choice', array(
                    'required' => true,
                    'choices' => $this->actionTypes,
                    'label' => 'form.label_action',
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
            'class' => 'fa fa-facebook-official',
        ));
    }
}
