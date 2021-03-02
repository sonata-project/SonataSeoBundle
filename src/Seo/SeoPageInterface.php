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

/**
 * @method SeoPageInterface removeMeta(string $type, string $name)
 * @method SeoPageInterface removeHtmlAttributes(string $name)
 * @method bool             hasHtmlAttribute(string $name)
 * @method SeoPageInterface removeHeadAttribute(string $name)
 * @method bool             hasHeadAttribute(string $name)
 * @method SeoPageInterface removeLangAlternate(string $href)
 * @method bool             hasLangAlternate(string $href)
 */
interface SeoPageInterface
{
    /**
     * @param string $title
     *
     * @return SeoPageInterface
     */
    public function setTitle($title);

    /**
     * @param string $title
     *
     * @return SeoPageInterface
     */
    public function addTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string               $type
     * @param string               $name
     * @param string               $value
     * @param array<string, mixed> $extras
     *
     * @return SeoPageInterface
     */
    public function addMeta($type, $name, $value, array $extras = []);

    /**
     * @param string $type
     * @param string $name
     *
     * @return bool
     */
    public function hasMeta($type, $name);

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getMetas();

    /**
     * @param array<string, array<string, mixed>> $metas
     *
     * @return SeoPageInterface
     */
    public function setMetas(array $metas);

    /**
     * @param array<string, string> $attributes
     *
     * @return SeoPageInterface
     */
    public function setHtmlAttributes(array $attributes);

    /**
     * @param string $name
     * @param string $value
     *
     * @return SeoPageInterface
     */
    public function addHtmlAttributes($name, $value);

    /**
     * @return array<string, string>
     */
    public function getHtmlAttributes();

    /**
     * @param array<string, string> $attributes
     *
     * @return SeoPageInterface
     */
    public function setHeadAttributes(array $attributes);

    /**
     * @param string $name
     * @param string $value
     *
     * @return SeoPageInterface
     */
    public function addHeadAttribute($name, $value);

    /**
     * @return array<string, string>
     */
    public function getHeadAttributes();

    /**
     * @param string $link
     *
     * @return SeoPageInterface
     */
    public function setLinkCanonical($link);

    /**
     * @return string
     */
    public function getLinkCanonical();

    /**
     * @param string $separator
     *
     * @return SeoPageInterface
     */
    public function setSeparator($separator);

    /**
     * @param array<string, string> $langAlternates
     *
     * @return SeoPageInterface
     */
    public function setLangAlternates(array $langAlternates);

    /**
     * @param string $href
     * @param string $hrefLang
     *
     * @return SeoPageInterface
     */
    public function addLangAlternate($href, $hrefLang);

    /**
     * @return array<string, string>
     */
    public function getLangAlternates();

    /**
     * @param string $title
     * @param string $link
     *
     * @return SeoPageInterface
     */
    public function addOEmbedLink($title, $link);

    /**
     * @return array<string, string>
     */
    public function getOEmbedLinks();

    /**
     * @param string $type
     * @param string $name
     *
     * @return $this
     */
    public function removeMeta($type, $name);

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeHtmlAttributes($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasHtmlAttribute($name);

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeHeadAttribute($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasHeadAttribute($name);

    /**
     * @param string $href
     *
     * @return $this
     */
    public function removeLangAlternate($href);

    /**
     * @param string $href
     *
     * @return bool
     */
    public function hasLangAlternate($href);
}
