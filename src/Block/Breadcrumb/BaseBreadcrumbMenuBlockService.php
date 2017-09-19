<?php

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
use Knp\Menu\ItemInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\MenuBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Abstract class for breadcrumb menu services.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseBreadcrumbMenuBlockService extends MenuBlockService
{
    /**
     * @var string
     */
    private $context;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param string                $context
     * @param string                $name
     * @param EngineInterface       $templating
     * @param MenuProviderInterface $menuProvider
     * @param FactoryInterface      $factory
     */
    public function __construct($context, $name, EngineInterface $templating, MenuProviderInterface $menuProvider, FactoryInterface $factory)
    {
        parent::__construct($name, $templating, $menuProvider, array());

        $this->context = $context;
        $this->factory = $factory;
    }

    /**
     * Return true if current BlockService handles the given context.
     *
     * @param string $context
     *
     * @return bool
     */
    public function handleContext($context)
    {
        return $this->context === $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return sprintf('Breadcrumb %s', $this->context);
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        parent::configureSettings($resolver);

        $resolver->setDefaults(array(
            'menu_template' => 'SonataSeoBundle:Block:breadcrumb.html.twig',
            'include_homepage_link' => true,
            'context' => false,
        ));
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return string
     */
    protected function getContext()
    {
        return $this->context;
    }

    /**
     * Initialize breadcrumb menu.
     *
     * @param BlockContextInterface $blockContext
     *
     * @return ItemInterface
     */
    protected function getRootMenu(BlockContextInterface $blockContext)
    {
        $settings = $blockContext->getSettings();
        /*
         * @todo : Use the router to get the homepage URI
         */

        $menu = $this->factory->createItem('breadcrumb');

        $menu->setChildrenAttribute('class', 'breadcrumb');

        if (method_exists($menu, 'setCurrentUri')) {
            $menu->setCurrentUri($settings['current_uri']);
        }

        if (method_exists($menu, 'setCurrent')) {
            $menu->setCurrent($settings['current_uri']);
        }

        if ($settings['include_homepage_link']) {
            $menu->addChild('sonata_seo_homepage_breadcrumb', array('uri' => '/'));
        }

        return $menu;
    }
}
