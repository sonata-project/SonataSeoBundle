<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Abstract class for breadcrumb menu builders.
 *
 * @author Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
abstract class BaseBreadcrumbMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var string
     */
    protected $currentUri;

    /**
     * @param FactoryInterface    $factory
     * @param TranslatorInterface $translator
     */
    public function __construct(FactoryInterface $factory, TranslatorInterface $translator)
    {
        $this->factory    = $factory;
        $this->translator = $translator;
    }

    /**
     * Initialize breadcrumb menu.
     *
     * @param boolean $includeHomepage Add the homepage to the breadcrumb?
     *
     * @return ItemInterface
     */
    public function getRootMenu($includeHomepage = true)
    {
        /*
         * @todo : Use the router to get the homepage URI
         */

        $menu = $this->factory->createItem('breadcrumb');

        $menu->setChildrenAttribute('class', 'breadcrumb');
        $menu->setCurrentUri($this->currentUri);

        if ($includeHomepage) {
            $menu->addChild(
                $this->translator->trans('sonata_seo_homepage_breadcrumb', array(), 'SonataSeoBundle'),
                array('uri' => '/')
            );
        }

        return $menu;
    }

    /**
     * Set the current URI.
     *
     * @param string $currentUri
     */
    public function setCurrentUri($currentUri)
    {
        $this->currentUri = $currentUri;
    }
}
