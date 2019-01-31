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
class SeoPage implements SeoPageInterface, SeoPageAttributesInterface
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
     * @deprecated wil be removed in 3.0
     *
     * @var array
     */
    protected $htmlAttributes;

    /**
     * @deprecated wil be removed in 3.0
     *
     * @var array
     */
    protected $headAttributes;

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
    protected $langAlternates;

    /**
     * @var array
     */
    protected $oembedLinks;

    /**
     * @var AttributeBag
     */
    private $htmlAttributesBag;

    /**
     * @var AttributeBag
     */
    private $bodyAttributesBag;

    /**
     * @var AttributeBag
     */
    private $headAttributesBag;

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
        $this->htmlAttributesBag = new AttributeBag();
        $this->headAttributesBag = new AttributeBag();
        $this->bodyAttributesBag = new AttributeBag();
        $this->linkCanonical = '';
        $this->separator = ' ';
        $this->langAlternates = [];
        $this->oembedLinks = [];
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
    public function addMeta($type, $name, $content, array $extras = [])
    {
        if (!isset($this->metas[$type])) {
            $this->metas[$type] = [];
        }

        $this->metas[$type][$name] = [$content, $extras];

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

    /**
     * {@inheritdoc}
     */
    public function setHtmlAttributes(array $attributes)
    {
        $this->htmlAttributes = $attributes;

        $this->htmlAttributes()->set($attributes);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addHtmlAttributes($name, $value)
    {
        $this->htmlAttributes[$name] = $value;

        $this->htmlAttributes()->add($name, $value);

        return $this;
    }

    /**
     * @deprecated use htmlAttributes()->remove() instead
     *
     * @param string $name
     *
     * @return $this
     */
    public function removeHtmlAttributes($name)
    {
        unset($this->htmlAttributes[$name]);

        $this->htmlAttributes()->remove($name);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlAttributes()
    {
        return $this->htmlAttributes()->all();
    }

    /**
     * @deprecated use htmlAttributes()->has() instead
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasHtmlAttribute($name)
    {
        return $this->htmlAttributes()->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function setHeadAttributes(array $attributes)
    {
        $this->headAttributes = $attributes;

        $this->headAttributes()->set($attributes);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addHeadAttribute($name, $value)
    {
        $this->headAttributes[$name] = $value;

        $this->headAttributes()->add($name, $value);

        return $this;
    }

    /**
     * @deprecated use headAttributes()->remove() instead
     *
     * @param string $name
     *
     * @return $this
     */
    public function removeHeadAttribute($name)
    {
        unset($this->headAttributes[$name]);

        $this->headAttributes()->remove($name);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadAttributes()
    {
        return $this->headAttributes()->all();
    }

    /**
     * @deprecated use headAttributes()->has() instead
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasHeadAttribute($name)
    {
        return $this->headAttributes()->has($name);
    }

    final public function htmlAttributes(): AttributeBag
    {
        return $this->htmlAttributesBag;
    }

    final public function headAttributes(): AttributeBag
    {
        return $this->headAttributesBag;
    }

    final public function bodyAttributes(): AttributeBag
    {
        return $this->bodyAttributesBag;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkCanonical($link)
    {
        $this->linkCanonical = $link;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkCanonical()
    {
        return $this->linkCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function removeLinkCanonical()
    {
        $this->linkCanonical = '';
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
