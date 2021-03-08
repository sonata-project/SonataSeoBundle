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

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Sonata\SeoBundle\Block\Social\TwitterEmbedTweetBlockService;
use Sonata\SeoBundle\Tests\Fixtures\Block\TwitterEmbedTweetBSTest;
use Twig\Environment;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
final class TwitterEmbedTweetBlockServiceTest extends BlockServiceTestCase
{
    public function testBuildUri(): void
    {
        $settings = [
            'tweet' => 'tweeeeeeeet',
            'foo' => 'bar',
            'align' => 'bar',
        ];

        $expected = sprintf('%s?%s', TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, 'align=bar&url=tweeeeeeeet');

        $twig = $this->createMock(Environment::class);
        $client = $this->createMock(ClientInterface::class);
        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $blockService = new TwitterEmbedTweetBSTest($twig, $client, $requestFactory);

        $this->assertSame($expected, $blockService->publicBuildUri(true, $settings));

        $expected = sprintf('%s?%s', TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, 'align=bar&id=tweeeeeeeet');
        $this->assertSame($expected, $blockService->publicBuildUri(false, $settings));
    }
}
