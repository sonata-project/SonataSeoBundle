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

namespace Sonata\SeoBundle\Tests\Block\Social;

use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Sonata\SeoBundle\Block\Social\TwitterEmbedTweetBlockService;
use Sonata\SeoBundle\Tests\Fixtures\Block\TwitterEmbedTweetBSTest;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
class TwitterEmbedTweetBlockServiceTest extends BlockServiceTestCase
{
    public function testBuildUri()
    {
        $settings = [
            'tweet' => 'tweeeeeeeet',
            'foo' => 'bar',
            'align' => 'bar',
        ];

        $expected = sprintf('%s?%s', TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, 'align=bar&url=tweeeeeeeet');

        $blockService = new TwitterEmbedTweetBSTest('', $this->createMock(EngineInterface::class));
        static::assertSame($expected, $blockService->publicBuildUri(true, $settings));

        $expected = sprintf('%s?%s', TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, 'align=bar&id=tweeeeeeeet');
        static::assertSame($expected, $blockService->publicBuildUri(false, $settings));
    }
}
