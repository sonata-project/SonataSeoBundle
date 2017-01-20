<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Twig\Extension;

use Sonata\SeoBundle\Seo\SeoPageInterface;

class SeoExtension extends \Twig_Extension
{
    /**
     * @var SeoPageInterface
     */
    protected $page;

    /**
     * @var string
     */
    protected $encoding;

    /**
     * @param SeoPageInterface $page
     * @param string           $encoding
     */
    public function __construct(SeoPageInterface $page, $encoding)
    {
        $this->page = $page;
        $this->encoding = $encoding;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_seo';
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderTitle()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getTitle() instead.',
            E_USER_DEPRECATED
        );

        echo $this->getTitle();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return sprintf('<title>%s</title>', strip_tags($this->page->getTitle()));
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderMetadatas()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getMetadatas() instead.',
            E_USER_DEPRECATED
        );

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
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderHtmlAttributes()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getHtmlAttributes() instead.',
            E_USER_DEPRECATED
        );

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
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderHeadAttributes()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getHeadAttributes() instead.',
            E_USER_DEPRECATED
        );

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
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderLinkCanonical()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getLinkCanonical() instead.',
            E_USER_DEPRECATED
        );

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
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderLangAlternates()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getLangAlternates() instead.',
            E_USER_DEPRECATED
        );

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
     *
     * @return mixed
     */
    private function normalize($string)
    {
        return htmlentities(strip_tags($string), ENT_COMPAT, $this->encoding);
    }
}
