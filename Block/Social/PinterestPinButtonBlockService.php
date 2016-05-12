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
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Model\Metadata;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Pinterest pin button integration.
 *
 * @see http://fr.business.pinterest.com/widget-builder/#do_pin_it_button
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class PinterestPinButtonBlockService extends BaseBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'SonataSeoBundle:Block:block_pinterest_pin_button.html.twig',
            'size' => null,
            'shape' => null,
            'url' => null,
            'image' => null,
            'description' => null,
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
                array('image', 'text', array(
                    'required' => false,
                    'label' => 'form.label_image',
                )),
                array('description', 'text', array(
                    'required' => false,
                    'label' => 'form.label_description',
                )),
                array('size', 'integer', array(
                    'required' => false,
                    'label' => 'form.label_size',
                )),
                array('shape', 'choice', array(
                    'required' => false,
                    'choices' => array(
                        'rectangular' => 'form.label_shape_rectangular',
                        'round' => 'form.label_shape_round',
                    ),
                    'label' => 'form.label_shape',
                )),
            ),
            'translation_domain' => 'SonataSeoBundle',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $block = $blockContext->getBlock();
        $settings = array_merge($blockContext->getSettings(), $block->getSettings());

        return $this->renderResponse($blockContext->getTemplate(), array(
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockMetadata($code = null)
    {
        return new Metadata($this->getName(), (!is_null($code) ? $code : $this->getName()), false, 'SonataSeoBundle', array(
            'class' => 'fa fa-pinterest-p',
        ));
    }
}
