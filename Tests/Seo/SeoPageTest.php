<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\Seo;

use Sonata\SeoBundle\Seo\SeoPage;

class SeoPageTest extends \PHPUnit_Framework_TestCase
{
    public function testMetas()
    {
        $page = new SeoPage;
        $page->addMeta('property', 'foo', 'bar');

        $expected = array(
            'http-equiv' => array(),
            'name'       => array(),
            'schema'     => array(),
            'charset'    => array(),
            'property'   => array('foo' => array('bar', array())),
        );

        $this->assertEquals($expected, $page->getMetas());
    }
}