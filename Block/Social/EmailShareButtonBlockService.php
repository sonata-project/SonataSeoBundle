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
 * This block offers a button to share current page by email.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class EmailShareButtonBlockService extends BaseBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'SonataSeoBundle:Block:block_email_share_button.html.twig',
            'subject' => null,
            'body' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('subject', 'text', array(
                    'required' => false,
                    'label' => 'form.label_subject',
                )),
                array('body', 'text', array(
                    'required' => false,
                    'label' => 'form.label_body',
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
            'class' => 'fa fa-envelope-o',
        ));
    }
}
