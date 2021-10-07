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
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SeoExtension extends AbstractExtension
{
    private SeoPageInterface $page;

    private string $encoding;

    public function __construct(SeoPageInterface $page, string $encoding)
    {
        $this->page = $page;
        $this->encoding = $encoding;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sonata_seo_title', [$this, 'getTitle'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_title_text', [$this, 'getTitleText'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_metadatas', [$this, 'getMetadatas'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_html_attributes', [$this, 'getHtmlAttributes'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_head_attributes', [$this, 'getHeadAttributes'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_link_canonical', [$this, 'getLinkCanonical'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_lang_alternates', [$this, 'getLangAlternates'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_oembed_links', [$this, 'getOembedLinks'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_seo_breadcrumb', [$this, 'renderBreadcrumb'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function getName(): string
    {
        return 'sonata_seo';
    }

    public function getTitle(): string
    {
        return sprintf('<title>%s</title>', strip_tags($this->page->getTitle()));
    }

    public function getTitleText(): string
    {
        return $this->page->getOriginalTitle();
    }

    public function getMetadatas(): string
    {
        $html = '';
        foreach ($this->page->getMetas() as $type => $metas) {
            foreach ($metas as $name => $meta) {
                [$content, $extras] = $meta;

                if ('' !== $content) {
                    $html .= sprintf(
                        "<meta %s=\"%s\" content=\"%s\" />\n",
                        $type,
                        $this->normalize($name),
                        $this->normalize((string) $content)
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

    public function getHtmlAttributes(): string
    {
        $attributes = '';
        foreach ($this->page->getHtmlAttributes() as $name => $value) {
            $attributes .= sprintf('%s="%s" ', $name, $value);
        }

        return rtrim($attributes);
    }

    public function getHeadAttributes(): string
    {
        $attributes = '';
        foreach ($this->page->getHeadAttributes() as $name => $value) {
            $attributes .= sprintf('%s="%s" ', $name, $value);
        }

        return rtrim($attributes);
    }

    public function getLinkCanonical(): string
    {
        if ('' !== $this->page->getLinkCanonical()) {
            return sprintf("<link rel=\"canonical\" href=\"%s\"/>\n", $this->page->getLinkCanonical());
        }

        return '';
    }

    public function getLangAlternates(): string
    {
        $html = '';
        foreach ($this->page->getLangAlternates() as $href => $hrefLang) {
            $html .= sprintf("<link rel=\"alternate\" href=\"%s\" hreflang=\"%s\"/>\n", $href, $hrefLang);
        }

        return $html;
    }

    public function getOembedLinks(): string
    {
        $html = '';
        foreach ($this->page->getOEmbedLinks() as $title => $link) {
            $html .= sprintf("<link rel=\"alternate\" type=\"application/json+oembed\" href=\"%s\" title=\"%s\" />\n", $link, $title);
        }

        return $html;
    }

    public function renderBreadcrumb(Environment $environment, ?string $currentUri = null): string
    {
        return $environment->render('@SonataSeo/breadcrumb.html.twig', [
            'currentUri' => $currentUri,
            'options' => $this->page->getBreadcrumbOptions(),
        ]);
    }

    private function normalize(string $string): string
    {
        return htmlentities(strip_tags($string), \ENT_COMPAT, $this->encoding);
    }
}
