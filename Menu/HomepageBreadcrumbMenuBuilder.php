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

/**
 * Homepage breadcrumb menu builder.
 *
 * @author Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
class HomepageBreadcrumbMenuBuilder extends BaseBreadcrumbMenuBuilder implements BreadcrumbMenuBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBreadcrumbMenu($parameters = array())
    {
        $menu = $this->getRootMenu();

        return $menu;
    }
}
