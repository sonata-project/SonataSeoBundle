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
 *
 * http://en.wikipedia.org/wiki/Meta_element
 *
 */
class SeoPage implements SeoPageInterface
{
    protected $title;

    protected $metas;

    protected $htmlAttributes;

    protected $linkCanonical;

    protected $separator;

    protected $headAttributes;

    protected $langAlternates;

    /**
     * Meta links
     *
     * @var array
     */
    protected $links = array();

    /**
     * {@inheritdoc}
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
        $this->linkCanonical = '';
        $this->separator = ' ';
        $this->langAlternates = array();
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
        $this->title = $title . $this->separator . $this->title;

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
     * {@inheritdoc}
     */
    public function getHtmlAttributes()
    {
        return $this->htmlAttributes;
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
     * @return array
     */
    public function getHeadAttributes()
    {
        return $this->headAttributes;
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
        if (null !== $link = $this->getLink('canonical')) {
            return $link[0]['href'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    /**
     * {@inheritdoc}
     */
    public function setLangAlternates(array $langAlternates)
    {
        $this->links["alternate"] = array();
        list($href, $hrefLang) = each($langAlternates);
        $this->addLangAlternate($href, $hrefLang);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addLangAlternate($href, $hrefLang)
    {
        $this->addLink('alternate', array('href' => $href, 'hreflang' => $hrefLang));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLangAlternates()
    {
        if (null !== $links = $this->getLink('alternate')) {
            $return = array();
            foreach ($links as $element) {
                $return[$element['href']] = $element['hreflang'];
            }
            return $return;
        }

        return null;
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
        if (isset($this->links[$type])) {
            return $this->links[$type];
        }

        return null;
    }
}
