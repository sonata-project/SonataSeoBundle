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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Model\BlockInterface;

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
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template'    => 'SonataSeoBundle:Block:block_pinterest_pin_button.html.twig',
            'size'        => null,
            'shape'       => null,
            'url'         => null,
            'image'       => null,
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
                array('url', 'url', array('required' => false)),
                array('image', 'text', array('required' => false)),
                array('description', 'text', array('required' => false)),
                array('size', 'integer', array('required' => false)),
                array('shape', 'choice', array(
                    'required' => false,
                    'choices' => array(
                        'rectangular' => 'rectangular',
                        'round' => 'round',
                    )
                )),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $block    = $blockContext->getBlock();
        $settings = array_merge($blockContext->getSettings(), $block->getSettings());

        return $this->renderResponse($blockContext->getTemplate(), array(
            'block'    => $blockContext->getBlock(),
            'settings' => $settings,
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Pinterest - Pin button';
    }
}
