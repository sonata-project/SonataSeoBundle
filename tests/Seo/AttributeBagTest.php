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
use Sonata\SeoBundle\Seo\AttributeBag;

class AttributeBagTest extends TestCase
{
    public function testConstructor()
    {
        $this->testAll();
    }

    public function testAll()
    {
        $bag = new AttributeBag(['foo' => 'bar']);
        $this->assertSame(['foo' => 'bar'], $bag->all());
    }

    public function testHas()
    {
        $bag = new AttributeBag(['foo' => 'bar']);
        $this->assertTrue($bag->has('foo'));
        $this->assertFalse($bag->has('unknown'));
    }

    public function testSet()
    {
        $bag = new AttributeBag([]);

        $bag->set(['foo' => 'bar', 'lorem' => 'ipsum']);
        $this->assertSame('bar', $bag->get('foo'));

        $bag->set(['foo' => 'baz']);
        $this->assertSame('baz', $bag->get('foo'));
        $this->assertSame(['foo' => 'baz'], $bag->all());
    }

    public function testAdd()
    {
        $bag = new AttributeBag(['foo' => 'bar']);
        $bag->add('bar', 'bas');
        $this->assertSame(['foo' => 'bar', 'bar' => 'bas'], $bag->all());
    }

    public function testGet()
    {
        $bag = new AttributeBag(['foo' => 'bar', 'null' => null]);
        $this->assertSame('bar', $bag->get('foo'));
        $this->assertSame('default', $bag->get('unknown', 'default'));
        $this->assertNull($bag->get('null'));
    }

    public function testRemove()
    {
        $bag = new AttributeBag(['foo' => 'bar']);
        $bag->add('bar', 'bas');
        $this->assertSame(['foo' => 'bar', 'bar' => 'bas'], $bag->all());
        $bag->remove('bar');
        $this->assertSame(['foo' => 'bar'], $bag->all());
    }

    public function testGetIterator()
    {
        $attributes = ['foo' => 'bar', 'bar' => 'bas'];
        $bag = new AttributeBag($attributes);

        $i = 0;
        foreach ($bag as $key => $val) {
            ++$i;
            $this->assertSame($attributes[$key], $val);
        }
        $this->assertSame(\count($attributes), $i);
    }
}
