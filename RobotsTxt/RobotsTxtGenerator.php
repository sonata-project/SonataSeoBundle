<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\RobotsTxt;

use Sonata\SeoBundle\RobotsTxt\RobotsTxt;

class RobotsTxtGenerator {


    /**
     * Build a RobotsTxt Object from an array
     * @param  array  $robotsTxtArray
     * @return RobotsTxt
     */
    public function buildRobotsTxt(array $robotsTxtArray){

        $robotsTxt = new RobotsTxt();

        // add first line comment
        $robotsTxt->addComment('www.robotstxt.org/');
        $robotsTxt->addComment('www.google.com/support/webmasters/bin/answer.py?hl=en&answer=156449');
        $robotsTxt->addSpacer();

        foreach ($robotsTxtArray as $key => $section) {
            // add user-agent
            foreach ($section['user-agent'] as $userAgent) {
                $robotsTxt->addUserAgent($userAgent);
            }
            // add crawl-delay
            if(array_key_exists('crawl-delay', $section)){
                $robotsTxt->addCrawlDelay($section['crawl-delay']);
            }
            // add access-control
            foreach ($section['access-control'] as $control) {
                $rule = key($control);
                $directory = $control[$rule];
                switch ($rule) {
                    case 'allow':
                        $robotsTxt->addAllow($directory);
                        break;
                    case 'disallow':
                        $robotsTxt->addDisallow($directory);
                        break;
                    default:
                        throw new \RuntimeException('Only allow or disallow is accepted for access-control');
                        break;
                }
            }
            // add Sitemap
            if(array_key_exists('sitemap', $section)){
                foreach ($section['sitemap'] as $sitemap) {
                    $robotsTxt->addSitemap($sitemap);
                }
            }
            // add Host
            if(array_key_exists('host', $section)){
                $robotsTxt->addHost($section['host']);
            }
            $robotsTxt->addSpacer();
        }

        return $robotsTxt;
    }

}
