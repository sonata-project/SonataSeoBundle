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
use Twig\Environment;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
final class TwitterEmbedTweetBlockServiceTest extends BlockServiceTestCase
{
    public function testBuildUri(): void
    {
        $twig = $this->createMock(Environment::class);
        $httpClient = $this->createStub(ClientInterface::class);
        $messageFactory = $this->createStub(RequestFactoryInterface::class);

        $blockService = new TwitterEmbedTweetBlockService($twig, $httpClient, $messageFactory);

        $settings = [
            'tweet' => 'tweeeeeeeet',
            'foo' => 'bar',
            'align' => 'bar',
        ];

        $expectedTrue = sprintf('%s?%s', TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, 'align=bar&url=tweeeeeeeet');
        $expectedFalse = sprintf('%s?%s', TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, 'align=bar&id=tweeeeeeeet');

        $this->assertSame($expectedTrue, $blockService->buildUri(true, $settings));
        $this->assertSame($expectedFalse, $blockService->buildUri(false, $settings));
    }
}
