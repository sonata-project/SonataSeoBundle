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
use Sonata\SeoBundle\Seo\AttributeBag;
use Sonata\SeoBundle\Seo\SeoPageAttributesInterface;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Sonata\SeoBundle\Twig\Extension\SeoExtension;
use Twig\Loader\FilesystemLoader;

class SeoExtensionTest extends TestCase
{
    public function testBackwardCompatibleHtmlAttributes()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects($this->once())->method('getHtmlAttributes')->will($this->returnValue([
            'xmlns' => 'http://www.w3.org/1999/xhtml',
            'xmlns:og' => 'http://opengraphprotocol.org/schema/',
        ]));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame(
            'xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/"',
            $extension->getHtmlAttributes($this->getEnvironment())
        );
    }

    public function testHtmlAttributes()
    {
        $page = $this->createMock([SeoPageInterface::class, SeoPageAttributesInterface::class]);
        $page->expects($this->once())->method('htmlAttributes')->willReturn(new AttributeBag([
            'xmlns' => 'http://www.w3.org/1999/xhtml',
            'xmlns:og' => 'http://opengraphprotocol.org/schema/',
        ]));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame(
            'xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/"',
            $extension->getHtmlAttributes($this->getEnvironment())
        );
    }

    public function testBackwardsCompatibleHeadAttributes()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects($this->once())->method('getHeadAttributes')->will($this->returnValue([]));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame('', $extension->getHeadAttributes($this->getEnvironment()));
    }

    public function testHeadAttributes()
    {
        $page = $this->createMock([SeoPageInterface::class, SeoPageAttributesInterface::class]);
        $page->expects($this->once())->method('headAttributes')->willReturn(new AttributeBag());

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame('', $extension->getHeadAttributes($this->getEnvironment()));
    }

    public function testBodyAttributes()
    {
        $page = $this->createMock([SeoPageInterface::class, SeoPageAttributesInterface::class]);

        $page->expects($this->once())->method('bodyAttributes')->willReturn(new AttributeBag());

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame('', $extension->getBodyAttributes($this->getEnvironment()));
    }

    public function testTitle()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects($this->once())->method('getTitle')->will($this->returnValue('<b>foo bar</b>'));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame('<title>foo bar</title>', $extension->getTitle());
    }

    public function testEncoding()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects($this->once())->method('getTitle')->will($this->returnValue('pięć głów zatkniętych na pal'));
        $page->expects($this->once())->method('getMetas')->will($this->returnValue([
            'http-equiv' => [],
            'name' => ['foo' => ['pięć głów zatkniętych na pal', []]],
            'schema' => [],
            'charset' => [],
            'property' => [],
        ]));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame('<title>pięć głów zatkniętych na pal</title>', $extension->getTitle());

        $this->assertSame(
            "<meta name=\"foo\" content=\"pięć gł&oacute;w zatkniętych na pal\" />\n",
            $extension->getMetadatas()
        );
    }

    public function testMetadatas()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects($this->once())->method('getMetas')->will($this->returnValue([
            'http-equiv' => [],
            'name' => ['foo' => ['bar "\'"', []]],
            'schema' => [],
            'charset' => ['UTF-8' => ['', []]],
            'property' => [],
        ]));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame(
            "<meta name=\"foo\" content=\"bar &quot;'&quot;\" />\n<meta charset=\"UTF-8\" />\n",
            $extension->getMetadatas()
        );
    }

    public function testName()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame('sonata_seo', $extension->getName());
    }

    public function testLinkCanonical()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects($this->any())->method('getLinkCanonical')->will($this->returnValue('http://example.com'));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame(
            "<link rel=\"canonical\" href=\"http://example.com\"/>\n",
            $extension->getLinkCanonical()
        );
    }

    public function testLangAlternates()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects($this->once())->method('getLangAlternates')->will($this->returnValue([
                    'http://example.com/' => 'x-default',
                ]));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame(
            "<link rel=\"alternate\" href=\"http://example.com/\" hreflang=\"x-default\"/>\n",
            $extension->getLangAlternates()
        );
    }

    public function testOEmbedLinks()
    {
        $page = $this->createMock(SeoPageInterface::class);
        $page->expects($this->once())->method('getOembedLinks')->will($this->returnValue([
            'Foo' => 'http://example.com/',
        ]));

        $extension = new SeoExtension($page, 'UTF-8');

        $this->assertSame(
            "<link rel=\"alternate\" type=\"application/json+oembed\" href=\"http://example.com/\" title=\"Foo\" />\n",
            $extension->getOembedLinks()
        );
    }

    protected function getEnvironment()
    {
        $loader = new FilesystemLoader();
        $loader->addPath(__DIR__.'/../../../src/Resources/views', 'SonataSeo');

        return new \Twig_Environment($loader);
    }
}
