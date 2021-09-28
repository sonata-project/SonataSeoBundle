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

interface SeoPageInterface
{
    public function setTitle(string $title): self;

    public function getTitle(): string;

    public function addTitlePrefix(string $prefix): self;

    public function addTitleSuffix(string $suffix): self;

    public function getOriginalTitle(): string;

    /**
     * @param array<string, mixed> $extras
     */
    public function addMeta(string $type, string $name, string $value, array $extras = []): self;

    public function hasMeta(string $type, string $name): bool;

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getMetas(): array;

    /**
     * @param array<string, array<string, mixed>> $metas
     */
    public function setMetas(array $metas): self;

    /**
     * @param array<string, string> $attributes
     */
    public function setHtmlAttributes(array $attributes): self;

    public function addHtmlAttributes(string $name, string $value): self;

    /**
     * @return array<string, string>
     */
    public function getHtmlAttributes(): array;

    /**
     * @param array<string, string> $attributes
     */
    public function setHeadAttributes(array $attributes): self;

    public function addHeadAttribute(string $name, string $value): self;

    /**
     * @return array<string, string>
     */
    public function getHeadAttributes(): array;

    public function setLinkCanonical(string $link): self;

    public function getLinkCanonical(): string;

    public function setSeparator(string $separator): self;

    /**
     * @param array<string, string> $langAlternates
     */
    public function setLangAlternates(array $langAlternates): self;

    public function addLangAlternate(string $href, string $hrefLang): self;

    /**
     * @return array<string, string>
     */
    public function getLangAlternates(): array;

    public function addOEmbedLink(string $title, string $link): self;

    /**
     * @return array<string, string>
     */
    public function getOEmbedLinks(): array;

    public function removeMeta(string $type, string $name): self;

    public function removeHtmlAttributes(string $name): self;

    public function hasHtmlAttribute(string $name): bool;

    public function removeHeadAttribute(string $name): self;

    public function hasHeadAttribute(string $name): bool;

    public function removeLangAlternate(string $href): self;

    public function hasLangAlternate(string $href): bool;

    /**
     * @param array<string, mixed> $options
     */
    public function setBreadcrumb(string $context, array $options): self;

    /**
     * @return array<string, mixed>
     */
    public function getBreadcrumbOptions(): array;
}
