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

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Sonata\CoreBundle\Model\Metadata;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This block offers a button to share current page by email.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
final class EmailShareButtonBlockService extends AbstractAdminBlockService
{
    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'template' => '@SonataSeo/Block/block_email_share_button.html.twig',
            'subject' => null,
            'body' => null,
        ]);
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block): void
    {
        $formMapper->add('settings', ImmutableArrayType::class, [
            'keys' => [
                ['subject', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_subject',
                ]],
                ['body', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_body',
                ]],
            ],
            'translation_domain' => 'SonataSeoBundle',
        ]);
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $block = $blockContext->getBlock();
        $settings = array_merge($blockContext->getSettings(), $block->getSettings());

        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
        ], $response);
    }

    public function getBlockMetadata($code = null)
    {
        return new Metadata($this->getName(), (null !== $code ? $code : $this->getName()), false, 'SonataSeoBundle', [
            'class' => 'fa fa-envelope-o',
        ]);
    }
}
