<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\RobotsTxt;

use Sonata\SeoBundle\RobotsTxt\RobotsTxtGenerator;
use Symfony\Component\Yaml\Yaml;

class RobotsTxtGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildRobotsTxt()
    {
        $values = Yaml::parse(file_get_contents(__DIR__.'/../DependencyInjection/data/config_robotstxt.yml'), true);

        $generator = new RobotsTxtGenerator();

        $robotsTxt = $generator->buildRobotsTxt($values['robotstxt']);
        $result = $robotsTxt->generate();
        $expected = $this->getRobotsTxt();

        $this->assertEquals($expected, $result);
    }

    private function getRobotsTxt()
    {
        return implode(PHP_EOL, $this->getRobotsTxtArray());
    }

    private function getRobotsTxtArray()
    {
        return array(
            '# www.robotstxt.org/',
            '# www.google.com/support/webmasters/bin/answer.py?hl=en&answer=156449',
            '',
            'User-agent: *',
            'Crawl-delay: 10',
            'Disallow: /admin',
            'Disallow: /sonatadmin',
            'Allow: /api/doc',
            'Disallow: /api',
            'Sitemap: https://www.example.com/sitemap_index.xml',
            'Host: www.example.com',
            '',
            'User-agent: BadRobot',
            'User-agent: GoogleBot',
            'Disallow: /private',
            ''
        );
    }

}
