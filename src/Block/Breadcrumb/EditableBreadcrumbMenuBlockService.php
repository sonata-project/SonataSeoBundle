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

namespace Sonata\SeoBundle\Block\Breadcrumb;

use Knp\Menu\FactoryInterface;
use Sonata\BlockBundle\Block\Service\BlockServiceInterface;
use Sonata\BlockBundle\Block\Service\EditableBlockService;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Meta\MetadataInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

abstract class EditableBreadcrumbMenuBlockService extends BaseBreadcrumbMenuBlockService implements EditableBlockService
{
    /**
     * @var BlockServiceInterface&EditableBlockService
     */
    private BlockServiceInterface $menuBlock;

    /**
     * @param BlockServiceInterface&EditableBlockService $menuBlock
     */
    public function __construct(Environment $twig, BlockServiceInterface $menuBlock, FactoryInterface $factory)
    {
        // TODO: Remove this check and add the intersection typehint when dropping support for PHP < 8.1
        if (!$menuBlock instanceof EditableBlockService) {
            throw new \TypeError(sprintf(
                'Argument 2 should be an instance of %s and %s',
                BlockServiceInterface::class,
                EditableBlockService::class
            ));
        }

        parent::__construct($twig, $factory);

        $this->menuBlock = $menuBlock;
    }

    final public function configureCreateForm(FormMapper $form, BlockInterface $block): void
    {
        $this->menuBlock->configureCreateForm($form, $block);
    }

    final public function configureEditForm(FormMapper $form, BlockInterface $block): void
    {
        $this->menuBlock->configureEditForm($form, $block);
    }

    public function getMetadata(): MetadataInterface
    {
        return $this->menuBlock->getMetadata();
    }

    final public function validate(ErrorElement $errorElement, BlockInterface $block): void
    {
        $this->menuBlock->validate($errorElement, $block);
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $this->menuBlock->configureSettings($resolver);

        $resolver->setDefaults([
            'menu_template' => '@SonataSeo/Block/breadcrumb.html.twig',
            'include_homepage_link' => true,
            'context' => null,
        ]);
    }
}
