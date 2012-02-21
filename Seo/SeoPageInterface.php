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

use Symfony\Component\HttpKernel\Bundle\Bundle;

interface SeoPageInterface
{
    /**
     * @param $title
     * @return SeoPageInterface
     */
    function setTitle($title);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @param array $data
     * @return SeoPageInterface
     */
    function addMeta($type, $name, $value, array $extras = array());

    /**
     * @return array
     */
    function getMetas();

    /**
     * @param array $metas
     * @return SeoPageInterface
     */
    function setMetas(array $metas);

    /**
     * @param array $attributes
     * @return SeoPageInterface
     */
    function setHtmlAttributes(array $attributes);

    /**
     * @param $name
     * @param $value
     * @return SeoPageInterface
     */
    function addHtmlAttributes($name, $value);

    /**
     * @return array
     */
    function getHtmlAttributes();
}
