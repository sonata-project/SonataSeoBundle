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
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Sonata\CoreBundle\Model\Metadata;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Facebook send button integration.
 *
 * @see https://developers.facebook.com/docs/plugins/send-button/
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class FacebookSendButtonBlockService extends BaseFacebookSocialPluginsBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => 'SonataSeoBundle:Block:block_facebook_send_button.html.twig',
            'url' => null,
            'width' => null,
            'height' => null,
            'colorscheme' => $this->colorschemeList['light'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', ImmutableArrayType::class, [
            'keys' => [
                ['url', UrlType::class, [
                    'required' => false,
                    'label' => 'form.label_url',
                ]],
                ['width', IntegerType::class, [
                    'required' => false,
                    'label' => 'form.label_width',
                ]],
                ['height', IntegerType::class, [
                    'required' => false,
                    'label' => 'form.label_height',
                ]],
                ['colorscheme', ChoiceType::class, [
                    'required' => true,
                    'choices' => $this->colorschemeList,
                    'label' => 'form.label_colorscheme',
                ]],
            ],
            'translation_domain' => 'SonataSeoBundle',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockMetadata($code = null)
    {
        return new Metadata($this->getName(), (null !== $code ? $code : $this->getName()), false, 'SonataSeoBundle', [
            'class' => 'fa fa-facebook-official',
        ]);
    }
}
