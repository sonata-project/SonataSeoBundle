<?php

namespace Sonata\SeoBundle\Menu;

use Knp\Menu\ItemInterface;

/**
 * Interface for breadcrumb menu builders.
 *
 * @author Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
interface BreadcrumbMenuBuilderInterface
{
    /**
     * Get the menu.
     *
     * @param array $parameters
     *
     * @return ItemInterface
     */
    public function getBreadcrumbMenu($parameters = array());
}
