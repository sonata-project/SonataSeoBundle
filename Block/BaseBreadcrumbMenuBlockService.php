<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Block;

use Knp\Menu\Provider\MenuProviderInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\MenuBlockService;
use Sonata\SeoBundle\Menu\BreadcrumbMenuBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Abstract class for breadcrumb menu services.
 *
 * @author Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
abstract class BaseBreadcrumbMenuBlockService extends MenuBlockService
{
    /**
     * @var string
     */
    protected $context;

    /**
     * @var BreadcrumbMenuBuilderInterface
     */
    protected $menuBuilder;

    /**
     * @param string                         $context
     * @param string                         $name
     * @param EngineInterface                $templating
     * @param MenuProviderInterface          $menuProvider
     * @param BreadcrumbMenuBuilderInterface $menuBuilder
     */
    public function __construct($context, $name, EngineInterface $templating, MenuProviderInterface $menuProvider, BreadcrumbMenuBuilderInterface $menuBuilder)
    {
        parent::__construct($name, $templating, $menuProvider, array());

        $this->context     = $context;
        $this->menuBuilder = $menuBuilder;
    }

    /**
     * Return true if current BlockService handles the given context.
     *
     * @param string $context
     *
     * @return boolean
     */
    public function handleContext($context)
    {
        return $this->context === $context;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        parent::setDefaultSettings($resolver);

        $resolver->setDefaults(array(
            'menu_template' => 'SonataSeoBundle:Block:breadcrumb.html.twig',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $this->menuBuilder->setCurrentUri($blockContext->getBlock()->getSetting('current_uri'));

        return parent::execute($blockContext, $response);
    }
}
