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
    protected $linkCanonical;

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

    /**
     * @param string $title
     */
    public function __construct($title = '')
    {
        $this->title = $title;
        $this->metas = [
            'http-equiv' => [],
            'name' => [],
            'schema' => [],
            'charset' => [],
            'property' => [],
        ];

        $this->htmlAttributes = [];
        $this->headAttributes = [];
        $this->linkCanonical = '';
        $this->separator = ' ';
        $this->langAlternates = [];
        $this->oembedLinks = [];
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function addTitle($title)
    {
        $this->title = $title.$this->separator.$this->title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMetas()
    {
        return $this->metas;
    }

    public function addMeta($type, $name, $content, array $extras = [])
    {
        if (!isset($this->metas[$type])) {
            $this->metas[$type] = [];
        }

        $this->metas[$type][$name] = [$content, $extras];

        return $this;
    }

    public function hasMeta($type, $name)
    {
        return isset($this->metas[$type][$name]);
    }

    public function removeMeta($type, $name)
    {
        unset($this->metas[$type][$name]);

        return $this;
    }

    public function setMetas(array $metadatas)
    {
        $this->metas = [];

        foreach ($metadatas as $type => $metas) {
            if (!\is_array($metas)) {
                throw new \RuntimeException('$metas must be an array');
            }

            foreach ($metas as $name => $meta) {
                list($content, $extras) = $this->normalize($meta);

                $this->addMeta($type, $name, $content, $extras);
            }
        }

        return $this;
    }

    public function setHtmlAttributes(array $attributes)
    {
        $this->htmlAttributes = $attributes;

        return $this;
    }

    public function addHtmlAttributes($name, $value)
    {
        $this->htmlAttributes[$name] = $value;

        return $this;
    }

    public function removeHtmlAttributes($name)
    {
        unset($this->htmlAttributes[$name]);

        return $this;
    }

    public function getHtmlAttributes()
    {
        return $this->htmlAttributes;
    }

    public function hasHtmlAttribute($name)
    {
        return isset($this->htmlAttributes[$name]);
    }

    public function setHeadAttributes(array $attributes)
    {
        $this->headAttributes = $attributes;

        return $this;
    }

    public function addHeadAttribute($name, $value)
    {
        $this->headAttributes[$name] = $value;

        return $this;
    }

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

    public function hasHeadAttribute($name)
    {
        return isset($this->headAttributes[$name]);
    }

    public function setLinkCanonical($link)
    {
        $this->linkCanonical = $link;

        return $this;
    }

    public function getLinkCanonical()
    {
        return $this->linkCanonical;
    }

    public function removeLinkCanonical(): void
    {
        $this->linkCanonical = '';
    }

    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    public function setLangAlternates(array $langAlternates)
    {
        $this->langAlternates = $langAlternates;

        return $this;
    }

    public function addLangAlternate($href, $hrefLang)
    {
        $this->langAlternates[$href] = $hrefLang;

        return $this;
    }

    public function removeLangAlternate($href)
    {
        unset($this->langAlternates[$href]);

        return $this;
    }

    public function hasLangAlternate($href)
    {
        return isset($this->langAlternates[$href]);
    }

    public function getLangAlternates()
    {
        return  $this->langAlternates;
    }

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
     * @param mixed $meta
     *
     * @return array
     */
    private function normalize($meta)
    {
        if (\is_string($meta)) {
            return [$meta, []];
        }

        return $meta;
    }
}
