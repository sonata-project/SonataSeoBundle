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
 * Facebook share button integration.
 *
 * @see https://developers.facebook.com/docs/plugins/share-button/
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class FacebookShareButtonBlockService extends BaseFacebookSocialPluginsBlockService
{
    /**
     * @var string[]
     */
    protected $layoutList = array(
        'box_count' => 'form.label_layout_box_count',
        'button_count' => 'form.label_layout_button_count',
        'button' => 'form.label_layout_button',
        'icon_link' => 'form.label_layout_icon_link',
        'icon' => 'form.label_layout_icon',
        'link' => 'form.label_layout_link',
    );

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'SonataSeoBundle:Block:block_facebook_share_button.html.twig',
            'url' => null,
            'width' => null,
            'layout' => $this->layoutList['box_count'],
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
                array('layout', 'choice', array(
                    'required' => true,
                    'choices' => $this->layoutList,
                    'label' => 'form.label_layout',
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
