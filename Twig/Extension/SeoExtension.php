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
            'sonata_seo_title'      => new \Twig_Function_Method($this, 'renderTitle'),
            'sonata_seo_metadatas'  => new \Twig_Function_Method($this, 'renderMetadatas'),
            'sonata_seo_html_attributes'  => new \Twig_Function_Method($this, 'renderHtmlAttributes'),
            'sonata_seo_head_attributes'  => new \Twig_Function_Method($this, 'renderHeadAttributes'),
            'sonata_seo_link_canonical'  => new \Twig_Function_Method($this, 'renderLinkCanonical'),
            'sonata_seo_lang_alternates'  => new \Twig_Function_Method($this, 'renderLangAlternates'),
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
     * @return void
     */
    public function renderTitle()
    {
        echo sprintf("<title>%s</title>", strip_tags($this->page->getTitle()));
    }

    /**
     * @return void
     */
    public function renderMetadatas()
    {
        foreach ($this->page->getMetas() as $type => $metas) {
            foreach ((array) $metas as $name => $meta) {
                list($content, $extras) = $meta;

                echo sprintf("<meta %s=\"%s\" content=\"%s\" />\n",
                    $type,
                    $this->normalize($name),
                    $this->normalize($content)
                );

            }
        }
    }

    /**
     * @return void
     */
    public function renderHtmlAttributes()
    {
        foreach ($this->page->getHtmlAttributes() as $name => $value) {
            echo sprintf('%s="%s" ', $name, $value);
        }
    }

    /**
     * @return void
     */
    public function renderHeadAttributes()
    {
        foreach ($this->page->getHeadAttributes() as $name => $value) {
            echo sprintf('%s="%s" ', $name, $value);
        }
    }

    /**
     * @return void
     */
    public function renderLinkCanonical()
    {
        if ($this->page->getLinkCanonical()) {
            echo sprintf("<link rel=\"canonical\" href=\"%s\"/>\n", $this->page->getLinkCanonical());
        }
    }

    /**
     * @return void
     */
    public function renderLangAlternates()
    {
        foreach ($this->page->getLangAlternates() as $href => $hrefLang) {
            echo sprintf("<link rel=\"alternate\" href=\"%s\" hreflang=\"%s\"/>\n", $href, $hrefLang);
        }
    }

    /**
     * @param $string
     * @return mixed
     */
    private function normalize($string)
    {
        return htmlentities(strip_tags($string), ENT_COMPAT, $this->encoding);
    }
}
