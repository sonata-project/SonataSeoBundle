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

class SeoPage implements SeoPageInterface
{
    protected $title;

    protected $metaDatas;

    protected $metas;

    protected $headAttributes;


    /**
     * {@inheritdoc}
     */
    public function __construct($title = '')
    {
        $this->title = $title;
        $this->metaDatas = array();
        $this->metas     = array();
        $this->headAttributes = array();
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaDatas(array $data)
    {
        $this->metaDatas = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaDatas()
    {
        return $this->metaDatas;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetas(array $data)
    {
        $this->metas = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * {@inheritdoc}
     */
    public function addMetaData($name, $value)
    {
        $this->metaDatas[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function addMeta($meta)
    {
        $this->metas[] = $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeadAttributes(array $attributes)
    {
        $this->headAttributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function addHeadAttributes($name, $value)
    {
        $this->headAttributes[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadAttributes()
    {
        return $this->headAttributes;
    }
}
