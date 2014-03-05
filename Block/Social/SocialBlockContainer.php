<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\SeoBundle\Block\Social;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\ContainerBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Class SocialBlockContainer
 *
 * @package Sonata\SeoBundle\Block\Social
 *
 * @author  Hugo Briand <briand@ekino.com>
 */
class SocialBlockContainer extends ContainerBlockService
{
    /**
     * Returns the mapping between service and associated sdk template
     *
     * @return array
     */
    public static function getSdkTemplateMapping()
    {
        return array(
            'facebook'  => "SonataSeoBundle:Block:_facebook_sdk.html.twig",
            'twitter'   => "SonataSeoBundle:Block:_twitter_sdk.html.twig",
            'pinterest' => "SonataSeoBundle:Block:_pinterest_sdk.html.twig"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $includeTemplates = array();

        if (is_array($sdks = $blockContext->getSetting('load_sdks'))) {
            $mapping = SocialBlockContainer::getSdkTemplateMapping();
            $mappingKeys = array_keys($mapping);

            foreach ($sdks as $sdk) {
                $includeTemplates[] = $mapping[$mappingKeys[$sdk]];
            }
        }

        return $this->renderResponse(
            $blockContext->getTemplate(),
            array(
                'block'             => $blockContext->getBlock(),
                'decorator'         => $this->getDecorator($blockContext->getSetting('layout')),
                'settings'          => $blockContext->getSettings(),
                'include_templates' => $includeTemplates
            ),
            $response
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'code'      => '',
                'layout'    => '{{ CONTENT }}',
                'class'     => '',
                'template'  => 'SonataSeoBundle:Block:block_social_container.html.twig',
                'load_sdks' => array(),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('enabled');

        $formMapper->add(
            'settings',
            'sonata_type_immutable_array',
            array(
                'keys' => array(
                    array('layout', 'textarea', array()),
                    array('class', 'text', array('required' => false)),
                    array(
                        'load_sdks', 'choice', array(
                            'required'   => false,
                            'multiple'   => true,
                            'choices'    => array_keys(SocialBlockContainer::getSdkTemplateMapping()),
                        )
                    ),
                )
            ),
            array('help' => "The SDK must be added once and only once on each page for the services you wish to use")
        );

        $formMapper->add('children', 'sonata_type_collection', array(), array(
            'edit'     => 'inline',
            'inline'   => 'table',
            'sortable' => 'position'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return parent::getName() ? : "Social Blocks Container";
    }
}