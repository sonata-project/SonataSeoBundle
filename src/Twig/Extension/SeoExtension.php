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

namespace Sonata\SeoBundle\Twig\Extension;

use Sonata\SeoBundle\Seo\SeoPageInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SeoExtension extends AbstractExtension
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
     * @param string $encoding
     */
    public function __construct(SeoPageInterface $page, $encoding)
    {
        $this->page = $page;
        $this->encoding = $encoding;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('sonata_seo_title', [$this, 'getTitle'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_metadatas', [$this, 'getMetadatas'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_html_attributes', [$this, 'getHtmlAttributes'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_head_attributes', [$this, 'getHeadAttributes'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_link_canonical', [$this, 'getLinkCanonical'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_lang_alternates', [$this, 'getLangAlternates'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_oembed_links', [$this, 'getOembedLinks'], ['is_safe' => ['html']]),
        ];
    }

    public function getName()
    {
        return 'sonata_seo';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return sprintf('<title>%s</title>', strip_tags($this->page->getTitle()));
    }

    /**
     * @return string
     */
    public function getMetadatas()
    {
        $html = '';
        foreach ($this->page->getMetas() as $type => $metas) {
            foreach ((array) $metas as $name => $meta) {
                [$content, $extras] = $meta;

                if (!empty($content)) {
                    $html .= sprintf(
                        "<meta %s=\"%s\" content=\"%s\" />\n",
                        $type,
                        $this->normalize($name),
                        $this->normalize($content)
                    );
                } else {
                    $html .= sprintf(
                        "<meta %s=\"%s\" />\n",
                        $type,
                        $this->normalize($name)
                    );
                }
            }
        }

        return $html;
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
     * @return string
     */
    public function getLinkCanonical()
    {
        if ($this->page->getLinkCanonical()) {
            return sprintf("<link rel=\"canonical\" href=\"%s\"/>\n", $this->page->getLinkCanonical());
        }
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
        return htmlentities(strip_tags((string) $string), \ENT_COMPAT, $this->encoding);
    }
}
