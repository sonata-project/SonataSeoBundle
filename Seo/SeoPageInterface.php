<?php
/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Seo;

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
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array  $extras
     *
     * @return mixed
     */
    public function addMeta($type, $name, $value, array $extras = array());

    /**
     * @param string $type
     * @param string $name
     *
     * @return bool
     */
    public function hasMeta($type, $name);

    /**
     * @return array
     */
    public function getMetas();

    /**
     * @param array $metas
     *
     * @return SeoPageInterface
     */
    public function setMetas(array $metas);

    /**
     * @param array $attributes
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
     * @return array
     */
    public function getHtmlAttributes();

    /**
     * @param array $attributes
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
     * @return array
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
     * @param array $langAlternates
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
     * @return array
     */
    public function getLangAlternates();

    /**
     * @param $title
     * @param $link
     * @return SeoPageInterface
     */
    public function addOEmbedLink($title, $link);

    /**
     * @return array
     */
    public function getOEmbedLinks();
}
