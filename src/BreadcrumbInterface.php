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

namespace Sonata\SeoBundle;

use Sonata\BlockBundle\Block\Service\BlockServiceInterface;

/**
 * @deprecated since sonata-project/seo-bundle 2.x, to be removed in 3.0. Use Sonata\SeoBundle\Block\Breadcrumb\Breadcrumb instead.
 */
interface BreadcrumbInterface extends BlockServiceInterface
{
    /**
     * @param string $context
     *
     * @return bool
     */
    public function handleContext($context);
}
