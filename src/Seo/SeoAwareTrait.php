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

@trigger_error(
    'The '.__NAMESPACE__.'\SeoAwareTrait trait deprecated since version 2.8 and will be removed in 3.0. '.
    'Inject the Sonata\SeoBundle\Seo\SeoPageInterface in your classes instead.', 
    E_USER_DEPRECATED
);

/**
 * @deprecated SeoAwareTrait is deprecated since version 2.8 and will be removed in 3.0. Inject the Sonata\SeoBundle\Seo\SeoPageInterface in your classes instead.
 */
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
