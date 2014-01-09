<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Block\Breadcrumb;

/**
 * BlockService for homepage breadcrumb.
 *
 * @author Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
class HomepageBreadcrumbBlockService extends BaseBreadcrumbMenuBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata.seo.block.breadcrumb.homepage';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(array $settings)
    {
        $menu = $this->getRootMenu($settings);

        return $menu;
    }
}