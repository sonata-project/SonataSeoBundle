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

namespace Sonata\SeoBundle\Tests\Seo;

use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\Seo\SeoPage;

class SeoPageTest extends TestCase
{
    public function testAddMeta()
    {
        $page = new SeoPage();
        $page->addMeta('property', 'foo', 'bar');

        $expected = [
            'http-equiv' => [],
            'name' => [],
            'schema' => [],
            'charset' => [],
            'property' => ['foo' => ['bar', []]],
        ];

        $this->assertSame($expected, $page->getMetas());
    }

    public function testOverrideMetas()
    {
        $page = new SeoPage();
        $page->setMetas(['property' => ['foo' => 'bar', 'foo2' => ['bar2', []]]]);

        $expected = [
            'property' => ['foo' => ['bar', []], 'foo2' => ['bar2', []]],
        ];

        $this->assertSame($expected, $page->getMetas());
    }

    public function testRemoveMeta()
    {
        $page = new SeoPage();
        $page->setMetas(['property' => ['foo' => 'bar', 'foo2' => ['bar2', []]]]);
        $page->removeMeta('property', 'foo');

        $this->assertFalse($page->hasMeta('property', 'foo'));
    }

    public function testInvalidMetas()
    {
        $this->expectException(\RuntimeException::class);

        $page = new SeoPage();
        $page->setMetas([
            'type' => 'not an array',
        ]);
    }

    public function testHtmlAttributes()
    {
        $page = new SeoPage();
        $page->setHtmlAttributes(['key1' => 'value1']);
        $page->addHtmlAttributes('key2', 'value2');

        $expected = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $this->assertSame($expected, $page->getHtmlAttributes());

        $this->assertTrue($page->hasHtmlAttribute('key2'));
        $page->removeHtmlAttributes('key2');
        $this->assertFalse($page->hasHtmlAttribute('key2'));
    }

    public function testHeadAttributes()
    {
        $page = new SeoPage();
        $page->setHeadAttributes(['head1' => 'value1']);
        $page->addHeadAttribute('head2', 'value2');

        $expected = [
            'head1' => 'value1',
            'head2' => 'value2',
        ];

        $this->assertSame($expected, $page->getHeadAttributes());

        $this->assertTrue($page->hasHeadAttribute('head1'));
        $page->removeHeadAttribute('head1');
        $this->assertFalse($page->hasHeadAttribute('head1'));
    }

    public function testBodyAttributes()
    {
        $page = new SeoPage();
        $page->bodyAttributes()->set(['body1' => 'value1']);
        $page->bodyAttributes()->add('body2', 'value2');

        $expected = [
            'body1' => 'value1',
            'body2' => 'value2',
        ];

        $this->assertSame($expected, $page->bodyAttributes()->all());

        $this->assertTrue($page->bodyAttributes()->has('body1'));
        $page->bodyAttributes()->remove('body1');
        $this->assertFalse($page->bodyAttributes()->has('body1'));
    }

    public function testSetTitle()
    {
        $page = new SeoPage();
        $page->setTitle('My title');

        $this->assertSame('My title', $page->getTitle());
    }

    public function testAddTitle()
    {
        $page = new SeoPage();
        $page->setTitle('My title');
        $page->setSeparator(' - ');
        $page->addTitle('Additional title');

        $this->assertSame('Additional title - My title', $page->getTitle());
    }

    public function testLinkCanonical()
    {
        $page = new SeoPage();
        $page->setLinkCanonical('http://example.com');

        $this->assertSame('http://example.com', $page->getLinkCanonical());

        $page->removeLinkCanonical();
        $this->assertSame('', $page->getLinkCanonical());
    }

    public function testLangAlternates()
    {
        $page = new SeoPage();
        $page->setLangAlternates(['http://example.com/' => 'x-default']);
        $page->addLangAlternate('http://example.com/en-us', 'en-us');

        $expected = [
            'http://example.com/' => 'x-default',
            'http://example.com/en-us' => 'en-us',
        ];

        $this->assertSame($expected, $page->getLangAlternates());

        $this->assertTrue($page->hasLangAlternate('http://example.com/'));
        $page->removeLangAlternate('http://example.com/');
        $this->assertFalse($page->hasLangAlternate('http://example.com/'));
    }

    /**
     * The hasMeta() should return true for a defined meta, false otherwise.
     */
    public function testHasMeta()
    {
        $page = new SeoPage();
        $page->addMeta('property', 'test', []);

        $this->assertTrue($page->hasMeta('property', 'test'));
        $this->assertFalse($page->hasMeta('property', 'fake'));
    }

    public function testSetSeparator()
    {
        $page = new SeoPage();

        $this->assertInstanceOf(SeoPage::class, $page->setSeparator('-'));
    }
}
