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

namespace Sonata\SeoBundle\Tests\Request;

use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Sonata\SeoBundle\Twig\Extension\SeoExtension;

final class SeoExtensionTest extends TestCase
{
    public function testHtmlAttributes(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::once())->method('getHtmlAttributes')->willReturn([
            'xmlns' => 'http://www.w3.org/1999/xhtml',
            'xmlns:og' => 'http://opengraphprotocol.org/schema/',
        ]);

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame(
            'xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/"',
            $extension->getHtmlAttributes()
        );
    }

    public function testHeadAttributes(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::once())->method('getHeadAttributes')->willReturn([]);

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame('', $extension->getHeadAttributes());
    }

    public function testTitle(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::once())->method('getTitle')->willReturn('<b>foo bar</b>');

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame('<title>foo bar</title>', $extension->getTitle());
    }

    public function getTitleText(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::once())->method('getTitle')->willReturn('<b>foo bar</b>');

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame('foo bar', $extension->getTitleText());
    }

    public function testEncoding(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::once())->method('getTitle')->willReturn('pięć głów zatkniętych na pal');
        $page->expects(static::once())->method('getMetas')->willReturn([
            'http-equiv' => [],
            'name' => ['foo' => ['pięć głów zatkniętych na pal', []]],
            'schema' => [],
            'charset' => [],
            'property' => [],
        ]);

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame('<title>pięć głów zatkniętych na pal</title>', $extension->getTitle());

        static::assertSame(
            "<meta name=\"foo\" content=\"pięć gł&oacute;w zatkniętych na pal\" />\n",
            $extension->getMetadatas()
        );
    }

    public function testMetadatas(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::once())->method('getMetas')->willReturn([
            'http-equiv' => [],
            'name' => ['foo' => ['bar "\'"', []]],
            'schema' => [],
            'charset' => ['UTF-8' => ['', []]],
            'property' => [
                'og:image:width' => [848, []],
                'og:type' => [new MetaTest(), []],
            ],
        ]);

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame(
            "<meta name=\"foo\" content=\"bar &quot;'&quot;\" />\n<meta charset=\"UTF-8\" />\n<meta property=\"og:image:width\" content=\"848\" />\n<meta property=\"og:type\" content=\"article\" />\n",
            $extension->getMetadatas()
        );
    }

    public function testName(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame('sonata_seo', $extension->getName());
    }

    public function testLinkCanonical(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::any())->method('getLinkCanonical')->willReturn('http://example.com');

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame(
            "<link rel=\"canonical\" href=\"http://example.com\"/>\n",
            $extension->getLinkCanonical()
        );
    }

    public function testLangAlternates(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::once())->method('getLangAlternates')->willReturn([
                    'http://example.com/' => 'x-default',
                ]);

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame(
            "<link rel=\"alternate\" href=\"http://example.com/\" hreflang=\"x-default\"/>\n",
            $extension->getLangAlternates()
        );
    }

    public function testOEmbedLinks(): void
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects(static::once())->method('getOembedLinks')->willReturn([
            'Foo' => 'http://example.com/',
        ]);

        $extension = new SeoExtension($page, 'UTF-8');

        static::assertSame(
            "<link rel=\"alternate\" type=\"application/json+oembed\" href=\"http://example.com/\" title=\"Foo\" />\n",
            $extension->getOembedLinks()
        );
    }
}

final class MetaTest
{
    public function __toString(): string
    {
        return 'article';
    }
}
