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
 * Facebook like box integration.
 *
 * @see https://developers.facebook.com/docs/plugins/like-box-for-pages/
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class FacebookLikeBoxBlockService extends BaseFacebookSocialPluginsBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'SonataSeoBundle:Block:block_facebook_like_box.html.twig',
            'url' => null,
            'width' => null,
            'height' => null,
            'colorscheme' => $this->colorschemeList['light'],
            'show_faces' => true,
            'show_header' => true,
            'show_posts' => false,
            'show_border' => true,
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
                array('height', 'integer', array(
                    'required' => false,
                    'label' => 'form.label_height',
                )),
                array('colorscheme', 'choice', array(
                    'required' => true,
                    'choices' => $this->colorschemeList,
                    'label' => 'form.label_colorscheme',
                )),
                array('show_faces', 'checkbox', array(
                    'required' => false,
                    'label' => 'form.label_show_faces',
                )),
                array('show_header', 'checkbox', array(
                    'required' => false,
                    'label' => 'form.label_show_header',
                )),
                array('show_posts', 'checkbox', array(
                    'required' => false,
                    'label' => 'form.label_show_posts',
                )),
                array('show_border', 'checkbox', array(
                    'required' => false,
                    'label' => 'form.label_show_border',
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
