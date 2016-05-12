<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\Block\Social;

use Sonata\SeoBundle\Block\Social\TwitterEmbedTweetBlockService;

class TwitterEmbedTweetBSTest extends TwitterEmbedTweetBlockService
{
    public function publicBuildUri($uriMatched, array $settings)
    {
        return $this->buildUri($uriMatched, $settings);
    }
}

/**
 * Class TwitterEmbedTweetBlockServiceTest.
 *
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class TwitterEmbedTweetBlockServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildUri()
    {
        $settings = array(
            'tweet' => 'tweeeeeeeet',
            'foo' => 'bar',
            'align' => 'bar',
        );

        $expected = sprintf('%s?%s', TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, 'align=bar&url=tweeeeeeeet');

        $blockService = new TwitterEmbedTweetBSTest('', $this->getMock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface'));
        $this->assertEquals($expected, $blockService->publicBuildUri(true, $settings));

        $expected = sprintf('%s?%s', TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, 'align=bar&id=tweeeeeeeet');
        $this->assertEquals($expected, $blockService->publicBuildUri(false, $settings));
    }
}
