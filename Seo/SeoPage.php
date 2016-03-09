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

/**
 * http://en.wikipedia.org/wiki/Meta_element.
 */
class SeoPage implements SeoPageInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $metas;

    /**
     * @var array
     */
    protected $htmlAttributes;

    /**
     * @var string
     */
    protected $separator;

    /**
     * @var array
     */
    protected $headAttributes;

    /**
     * @var array
     */
    protected $langAlternates;

    /**
     * @var array
     */
    protected $oembedLinks;

    /** @var array $links */
    protected $links;

    /**
     * @param string $title
     */
    public function __construct($title = '')
    {
        $this->title     = $title;
        $this->metas     = array(
            'http-equiv' => array(),
            'name'       => array(),
            'schema'     => array(),
            'charset'    => array(),
            'property'   => array(),
        );

        $this->headAttributes = array();
        $this->separator = ' ';
        $this->langAlternates = array();
        $this->oembedLinks = array();
        $this->links = array();
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTitle($title)
    {
        $this->title = $title.$this->separator.$this->title;

        return $this;
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
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * {@inheritdoc}
     */
    public function addMeta($type, $name, $content, array $extras = array())
    {
        if (!isset($this->metas[$type])) {
            $this->metas[$type] = array();
        }

        $this->metas[$type][$name] = array($content, $extras);

        return $this;
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return bool
     */
    public function hasMeta($type, $name)
    {
        return isset($this->metas[$type][$name]);
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return $this
     */
    public function removeMeta($type, $name)
    {
        unset($this->metas[$type][$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetas(array $metadatas)
    {
        $this->metas = array();

        foreach ($metadatas as $type => $metas) {
            if (!is_array($metas)) {
                throw new \RuntimeException('$metas must be an array');
            }

            foreach ($metas as $name => $meta) {
                list($content, $extras) = $this->normalize($meta);

                $this->addMeta($type, $name, $content, $extras);
            }
        }

        return $this;
    }

    /**
     * @param mixed $meta
     *
     * @return array
     */
    private function normalize($meta)
    {
        if (is_string($meta)) {
            return array($meta, array());
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function setHtmlAttributes(array $attributes)
    {
        $this->htmlAttributes = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addHtmlAttributes($name, $value)
    {
        $this->htmlAttributes[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeHtmlAttributes($name)
    {
        unset($this->htmlAttributes[$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlAttributes()
    {
        return $this->htmlAttributes;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasHtmlAttribute($name)
    {
        return isset($this->htmlAttributes[$name]);
    }

    /**
     * @param array $attributes
     *
     * @return SeoPageInterface
     */
    public function setHeadAttributes(array $attributes)
    {
        $this->headAttributes = $attributes;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return SeoPageInterface
     */
    public function addHeadAttribute($name, $value)
    {
        $this->headAttributes[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeHeadAttribute($name)
    {
        unset($this->headAttributes[$name]);

        return $this;
    }

    /**
     * @return array
     */
    public function getHeadAttributes()
    {
        return $this->headAttributes;
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function hasHeadAttribute($name)
    {
        return isset($this->headAttributes[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkCanonical($link)
    {
        $this->setLink('canonical', array('href' => $link));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkCanonical()
    {
        $canonical = $this->getLink('canonical');
        $canonical = current($canonical) ? current($canonical) : array();

        if (array_key_exists('href', $canonical)) {
            return $canonical['href'];
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function removeLinkCanonical()
    {
        $this->removeLink('canonical');
    }

    /**
     * {@inheritdoc}
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLangAlternates(array $langAlternates)
    {
        $this->langAlternates = $langAlternates;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addLangAlternate($href, $hrefLang)
    {
        $this->langAlternates[$href] = $hrefLang;

        return $this;
    }

    /**
     * @param string $href
     *
     * @return $this
     */
    public function removeLangAlternate($href)
    {
        unset($this->langAlternates[$href]);

        return $this;
    }

    /**
     * @param string $href
     *
     * @return $this
     */
    public function hasLangAlternate($href)
    {
        return isset($this->langAlternates[$href]);
    }

    /**
     * {@inheritdoc}
     */
    public function getLangAlternates()
    {
        return  $this->langAlternates;
    }

    /**
     * @param $title
     * @param $link
     *
     * @return SeoPageInterface
     */
    public function addOEmbedLink($title, $link)
    {
        $this->oembedLinks[$title] = $link;

        return $this;
    }

    /**
     * @return array
     */
    public function getOEmbedLinks()
    {
        return $this->oembedLinks;
    }

    /**
     * {@inheritdoc}
     */
    public function addLink($type, array $attributes)
    {
        $this->links[$type][] = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLink($type, array $attributes)
    {
        $this->links[$type] = array();

        return $this->addLink($type, $attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function getLink($type)
    {
        if (array_key_exists($type, $this->links)) {
            return $this->links[$type];
        }

        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * {@inheritdoc}
     */
    public function removeLink($type)
    {
        if (array_key_exists($type, $this->links)) {
            unset($this->links[$type]);

            return true;
        }

        return false;
    }
}
