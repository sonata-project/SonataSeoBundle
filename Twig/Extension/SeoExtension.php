<?php

/*
 * This file is part of sonata-project.
 *
 * (c) 2010 Thomas Rabaix
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Twig\Extension;

use Sonata\SeoBundle\Seo\SeoPageInterface;

class SeoExtension extends \Twig_Extension
{
    protected $page;

    protected $encoding;

    /**
     * @param \Sonata\SeoBundle\Seo\SeoPageInterface $page
     * @param $encoding
     */
    public function __construct(SeoPageInterface $page, $encoding)
    {
        $this->page = $page;
        $this->encoding = $encoding;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('sonata_seo_title', array($this, 'getTitle'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('sonata_seo_metadatas', array($this, 'getMetadatas'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('sonata_seo_html_attributes', array($this, 'getHtmlAttributes'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('sonata_seo_head_attributes', array($this, 'getHeadAttributes'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('sonata_seo_link_canonical', array($this, 'getLinkCanonical'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('sonata_seo_lang_alternates', array($this, 'getLangAlternates'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('sonata_seo_oembed_links', array($this, 'getOembedLinks'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'sonata_seo';
    }

    /**
     * @deprecated Deprecated as of 1.2, echo the return value of getTitle() instead.
     *
     * @return void
     */
    public function renderTitle()
    {
        echo $this->getTitle();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return sprintf("<title>%s</title>", strip_tags($this->page->getTitle()));
    }

    /**
     * @deprecated Deprecated as of 1.2, echo the return value of getMetadatas() instead.
     *
     * @return void
     */
    public function renderMetadatas()
    {
        echo $this->getMetadatas();
    }

    /**
     * @return string
     */
    public function getMetadatas()
    {
        $html = '';
        foreach ($this->page->getMetas() as $type => $metas) {
            foreach ((array) $metas as $name => $meta) {
                list($content, $extras) = $meta;

                if (!empty($content)) {
                    $html .= sprintf("<meta %s=\"%s\" content=\"%s\" />\n",
                        $type,
                        $this->normalize($name),
                        $this->normalize($content)
                    );
                } else {
                    $html .= sprintf("<meta %s=\"%s\" />\n",
                        $type,
                        $this->normalize($name)
                    );
                }
            }
        }

        return $html;
    }

    /**
     * @deprecated Deprecated as of 1.2, echo the return value of getHtmlAttributes() instead.
     *
     * @return void
     */
    public function renderHtmlAttributes()
    {
        echo $this->getHtmlAttributes();
    }

    /**
     * @return string
     */
    public function getHtmlAttributes()
    {
        $attributes = '';
        foreach ($this->page->getHtmlAttributes() as $name => $value) {
            $attributes .= sprintf('%s="%s" ', $name, $value);
        }

        return rtrim($attributes);
    }

    /**
     * @deprecated Deprecated as of 1.2, echo the return value of getHeadAttributes() instead.
     *
     * @return void
     */
    public function renderHeadAttributes()
    {
        echo $this->getHeadAttributes();
    }

    /**
     * @return string
     */
    public function getHeadAttributes()
    {
        $attributes = '';
        foreach ($this->page->getHeadAttributes() as $name => $value) {
            $attributes .= sprintf('%s="%s" ', $name, $value);
        }

        return rtrim($attributes);
    }

    /**
     * @deprecated Deprecated as of 1.2, echo the return value of getLinkCanonical() instead.
     *
     * @return void
     */
    public function renderLinkCanonical()
    {
        echo $this->getLinkCanonical();
    }

    /**
     * @return string
     */
    public function getLinkCanonical()
    {
        if ($this->page->getLinkCanonical()) {
            return sprintf("<link rel=\"canonical\" href=\"%s\"/>\n", $this->page->getLinkCanonical());
        }
    }

    /**
     * @deprecated Deprecated as of 1.2, echo the return value of getLangAlternates() instead.
     *
     * @return void
     */
    public function renderLangAlternates()
    {
        echo $this->getLangAlternates();
    }

    /**
     * @return string
     */
    public function getLangAlternates()
    {
        $html = '';
        foreach ($this->page->getLangAlternates() as $href => $hrefLang) {
            $html .= sprintf("<link rel=\"alternate\" href=\"%s\" hreflang=\"%s\"/>\n", $href, $hrefLang);
        }

        return $html;
    }

    /**
     * @return string
     */
    public function getOembedLinks()
    {
        $html = '';
        foreach ($this->page->getOEmbedLinks() as $title => $link) {
            $html .= sprintf("<link rel=\"alternate\" type=\"application/json+oembed\" href=\"%s\" title=\"%s\" />\n", $link, $title);
        }

        return $html;
    }

    /**
     * @param string $string
     * @return mixed
     */
    private function normalize($string)
    {
        return htmlentities(strip_tags($string), ENT_COMPAT, $this->encoding);
    }
}
