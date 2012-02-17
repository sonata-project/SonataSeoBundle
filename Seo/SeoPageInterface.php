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
    function setMetaDatas(array $data);

    /**
     * @return array
     */
    function getMetaDatas();

    /**
     * @param array $data
     * @return SeoPageInterface
     */
    function setMetas(array $data);

    /**
     * @return array
     */
    function getMetas();

    /**
     * @param $name
     * @param $value
     * @return SeoPageInterface
     */
    function addMetaData($name, $value);

    /**
     * @param $meta
     * @return SeoPageInterface
     */
    function addMeta($meta);

    /**
     * @param array $attributes
     * @return SeoPageInterface
     */
    function setHeadAttributes(array $attributes);

    /**
     * @param $name
     * @param $value
     * @return SeoPageInterface
     */
    function addHeadAttributes($name, $value);

    /**
     * @return array
     */
    function getHeadAttributes();
}
