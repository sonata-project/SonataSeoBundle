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
final class SeoPage implements SeoPageInterface
{
    private string $title;

    /**
     * @var array<string, array<string, mixed>>
     */
    private array $metas = [
        'http-equiv' => [],
        'name' => [],
        'schema' => [],
        'charset' => [],
        'property' => [],
    ];

    /**
     * @var array<string, string>
     */
    private array $htmlAttributes = [];

    private string $linkCanonical = '';

    private string $separator = ' ';

    /**
     * @var array<string, string>
     */
    private array $headAttributes = [];

    /**
     * @var array<string, string>
     */
    private array $langAlternates = [];

    /**
     * @var array<string, string>
     */
    private array $oembedLinks = [];

    private string $originalTitle;

    /**
     * @var array<string, mixed>
     */
    private array $breadcrumb = [];

    public function __construct(string $title = '')
    {
        $this->setTitle($title);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->originalTitle = $title;

        return $this;
    }

    public function addTitlePrefix(string $prefix): self
    {
        $this->title = $prefix.$this->separator.$this->title;

        return $this;
    }

    public function addTitleSuffix(string $suffix): self
    {
        $this->title .= $this->separator.$suffix;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    public function getMetas(): array
    {
        return $this->metas;
    }

    public function addMeta(string $type, string $name, string $value, array $extras = []): self
    {
        if (!isset($this->metas[$type])) {
            $this->metas[$type] = [];
        }

        $this->metas[$type][$name] = [$value, $extras];

        return $this;
    }

    public function hasMeta(string $type, string $name): bool
    {
        return isset($this->metas[$type][$name]);
    }

    public function removeMeta(string $type, string $name): self
    {
        unset($this->metas[$type][$name]);

        return $this;
    }

    public function setMetas(array $metas): self
    {
        $this->metas = [];

        foreach ($metas as $type => $metaItem) {
            if (!\is_array($metaItem)) {
                throw new \RuntimeException('$metas must be an array');
            }

            foreach ($metaItem as $name => $meta) {
                [$content, $extras] = $this->normalize($meta);

                $this->addMeta($type, $name, $content, $extras);
            }
        }

        return $this;
    }

    public function setHtmlAttributes(array $attributes): self
    {
        $this->htmlAttributes = $attributes;

        return $this;
    }

    public function addHtmlAttributes(string $name, string $value): self
    {
        $this->htmlAttributes[$name] = $value;

        return $this;
    }

    public function removeHtmlAttributes(string $name): self
    {
        unset($this->htmlAttributes[$name]);

        return $this;
    }

    public function getHtmlAttributes(): array
    {
        return $this->htmlAttributes;
    }

    public function hasHtmlAttribute(string $name): bool
    {
        return isset($this->htmlAttributes[$name]);
    }

    public function setHeadAttributes(array $attributes): self
    {
        $this->headAttributes = $attributes;

        return $this;
    }

    public function addHeadAttribute(string $name, string $value): self
    {
        $this->headAttributes[$name] = $value;

        return $this;
    }

    public function removeHeadAttribute(string $name): self
    {
        unset($this->headAttributes[$name]);

        return $this;
    }

    public function getHeadAttributes(): array
    {
        return $this->headAttributes;
    }

    public function hasHeadAttribute(string $name): bool
    {
        return isset($this->headAttributes[$name]);
    }

    public function setLinkCanonical(string $link): self
    {
        $this->linkCanonical = $link;

        return $this;
    }

    public function getLinkCanonical(): string
    {
        return $this->linkCanonical;
    }

    public function removeLinkCanonical(): void
    {
        $this->linkCanonical = '';
    }

    public function setSeparator(string $separator): self
    {
        $this->separator = $separator;

        return $this;
    }

    public function setLangAlternates(array $langAlternates): self
    {
        $this->langAlternates = $langAlternates;

        return $this;
    }

    public function addLangAlternate(string $href, string $hrefLang): self
    {
        $this->langAlternates[$href] = $hrefLang;

        return $this;
    }

    public function removeLangAlternate(string $href): self
    {
        unset($this->langAlternates[$href]);

        return $this;
    }

    public function hasLangAlternate(string $href): bool
    {
        return isset($this->langAlternates[$href]);
    }

    public function getLangAlternates(): array
    {
        return $this->langAlternates;
    }

    public function addOEmbedLink(string $title, string $link): self
    {
        $this->oembedLinks[$title] = $link;

        return $this;
    }

    public function getOEmbedLinks(): array
    {
        return $this->oembedLinks;
    }

    public function setBreadcrumb(string $context, array $options = []): self
    {
        $this->breadcrumb = array_merge_recursive([
            'menu_template' => '@SonataSeo/Block/breadcrumb.html.twig',
            'context' => $context,
        ], $options);

        return $this;
    }

    public function getBreadcrumbOptions(): array
    {
        return $this->breadcrumb;
    }

    /**
     * @param mixed[]|string $meta
     *
     * @return mixed[]
     */
    private function normalize($meta): array
    {
        if (\is_string($meta)) {
            return [$meta, []];
        }

        return $meta;
    }
}
