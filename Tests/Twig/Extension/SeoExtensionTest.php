<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\Request;

use Sonata\SeoBundle\Twig\Extension\SeoExtension;

class BlockTest extends \PHPUnit_Framework_TestCase
{
    public function testHtmlAttributes()
    {
        $page = $this->getMock('Sonata\SeoBundle\Seo\SeoPageInterface');
        $page->expects($this->once())->method('getHtmlAttributes')->will($this->returnValue(array(
            'xmlns' => 'http://www.w3.org/1999/xhtml',
            'xmlns:og' => 'http://opengraphprotocol.org/schema/',
        )));

        $extension = new SeoExtension($page, 'UTF-8');

        ob_start();
        $extension->renderHtmlAttributes();
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" ', $content);
    }

    public function testTitle()
    {
        $page = $this->getMock('Sonata\SeoBundle\Seo\SeoPageInterface');
        $page->expects($this->once())->method('getTitle')->will($this->returnValue('<b>foo bar</b>'));

        $extension = new SeoExtension($page, 'UTF-8');

        ob_start();
        $extension->renderTitle();
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('<title>foo bar</title>', $content);
    }

    public function testEncoding()
    {
        $page = $this->getMock('Sonata\SeoBundle\Seo\SeoPageInterface');
        $page->expects($this->once())->method('getTitle')->will($this->returnValue('pięć głów zatkniętych na pal'));
        $page->expects($this->once())->method('getMetas')->will($this->returnValue(array(
            'http-equiv' => array(),
            'name'       => array('foo' => array('pięć głów zatkniętych na pal', array())),
            'schema'     => array(),
            'charset'    => array(),
            'property'   => array(),
        )));

        $extension = new SeoExtension($page, 'UTF-8');

        ob_start();
        $extension->renderTitle();
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('<title>pięć głów zatkniętych na pal</title>', $content);

        ob_start();
        $extension->renderMetadatas();
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertEquals("<meta name=\"foo\" content=\"pięć gł&oacute;w zatkniętych na pal\" />\n", $content);
    }

    public function testMetadatas()
    {
        $page = $this->getMock('Sonata\SeoBundle\Seo\SeoPageInterface');
        $page->expects($this->once())->method('getMetas')->will($this->returnValue(array(
            'http-equiv' => array(),
            'name'       => array('foo' => array('bar "\'"', array())),
            'schema'     => array(),
            'charset'    => array(),
            'property'   => array(),
        )));

        $extension = new SeoExtension($page, 'UTF-8');

        ob_start();
        $extension->renderMetadatas();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals("<meta name=\"foo\" content=\"bar &quot;'&quot;\" />\n", $content);
    }
}