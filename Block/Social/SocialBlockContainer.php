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

use Sonata\BlockBundle\Block\Service\ContainerBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Class SocialBlockContainer
 *
 * @package Sonata\SeoBundle\Block\Social
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class SocialBlockContainer extends ContainerBlockService
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'code'        => '',
            'layout'      => '{{ CONTENT }}',
            'class'       => '',
            'template'    => 'SonataSeoBundle:Block:block_social_container.html.twig',
        ));
    }

}