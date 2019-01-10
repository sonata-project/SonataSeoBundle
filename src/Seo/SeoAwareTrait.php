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

namespace Sonata\SeoBundle\Seo;

trait SeoAwareTrait
{
    /**
     * @var SeoPageInterface|null
     *
     * @required
     */
    protected $seoPage;

    public function setSeoPage(SeoPageInterface $seoPage = null)
    {
        $this->seoPage = $seoPage;
    }
}
