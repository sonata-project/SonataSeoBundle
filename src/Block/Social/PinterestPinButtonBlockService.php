<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Block\Social;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Block\Service\EditableBlockService;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Meta\MetadataInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Type\ImmutableArrayType;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Pinterest pin button integration.
 *
 * @see http://fr.business.pinterest.com/widget-builder/#do_pin_it_button
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
final class PinterestPinButtonBlockService extends AbstractBlockService implements EditableBlockService
{
    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'template' => '@SonataSeo/Block/block_pinterest_pin_button.html.twig',
            'size' => null,
            'shape' => null,
            'url' => null,
            'image' => null,
            'description' => null,
        ]);
    }

    public function configureCreateForm(FormMapper $form, BlockInterface $block): void
    {
        $this->configureEditForm($form, $block);
    }

    public function configureEditForm(FormMapper $form, BlockInterface $block): void
    {
        $form->add('settings', ImmutableArrayType::class, [
            'keys' => [
                ['url', UrlType::class, [
                    'required' => false,
                    'label' => 'form.label_url',
                ]],
                ['image', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_image',
                ]],
                ['description', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_description',
                ]],
                ['size', IntegerType::class, [
                    'required' => false,
                    'label' => 'form.label_size',
                ]],
                ['shape', ChoiceType::class, [
                    'required' => false,
                    'choices' => [
                        'rectangular' => 'form.label_shape_rectangular',
                        'round' => 'form.label_shape_round',
                    ],
                    'label' => 'form.label_shape',
                ]],
            ],
            'translation_domain' => 'SonataSeoBundle',
        ]);
    }

    public function validate(ErrorElement $errorElement, BlockInterface $block): void
    {
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null): Response
    {
        $block = $blockContext->getBlock();
        $settings = array_merge($blockContext->getSettings(), $block->getSettings());

        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
        ], $response);
    }

    public function getMetadata(): MetadataInterface
    {
        return new Metadata('sonata.seo.block.pinterest.pin_button', null, null, 'SonataSeoBundle', [
            'class' => 'fa fa-envelope-o',
        ]);
    }
}
