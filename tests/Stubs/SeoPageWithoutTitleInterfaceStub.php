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

namespace Sonata\SeoBundle\Tests\Stubs;

use Sonata\SeoBundle\Seo\SeoPageInterface;

class SeoPageWithoutTitleInterfaceStub implements SeoPageInterface
{
    public function setTitle($title)
    {
    }

    public function addTitle($title)
    {
    }

    public function getTitle()
    {
    }

    public function addMeta($type, $name, $value, array $extras = [])
    {
    }

    public function hasMeta($type, $name)
    {
    }

    public function getMetas()
    {
    }

    public function setMetas(array $metas)
    {
    }

    public function setHtmlAttributes(array $attributes)
    {
    }

    public function addHtmlAttributes($name, $value)
    {
    }

    public function getHtmlAttributes()
    {
    }

    public function setHeadAttributes(array $attributes)
    {
    }

    public function addHeadAttribute($name, $value)
    {
    }

    public function getHeadAttributes()
    {
    }

    public function setLinkCanonical($link)
    {
    }

    public function getLinkCanonical()
    {
    }

    public function setSeparator($separator)
    {
    }

    public function setLangAlternates(array $langAlternates)
    {
    }

    public function addLangAlternate($href, $hrefLang)
    {
    }

    public function getLangAlternates()
    {
    }

    public function addOEmbedLink($title, $link)
    {
    }

    public function getOEmbedLinks()
    {
    }
}
