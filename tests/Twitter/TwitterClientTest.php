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

namespace Sonata\SeoBundle\Tests\Twitter;

use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\Twitter\TwitterClient;
use Symfony\Component\HttpClient\Psr18Client;

final class TwitterClientTest extends TestCase
{
    public function testGetUriForSettingsById(): void
    {
        $settings = [
            'foo' => 'bar',
            'align' => 'bar',
            'id' => '438337742565826560',
        ];

        $expected = sprintf('%s?%s', TwitterClient::TWITTER_OEMBED_URI, 'align=bar&id=438337742565826560');

        $tweetGetter = new TwitterClient(new Psr18Client(), new Psr17Factory());

        $this->assertSame($expected, $tweetGetter->getUriForSettings($settings));
    }

    public function testGetUriForSettingsByLink(): void
    {
        $settings = [
            'foo' => 'bar',
            'align' => 'bar',
            'url' => 'https://twitter.com/dunglas/statuses/438337742565826560',
        ];

        $expected = sprintf('%s?%s', TwitterClient::TWITTER_OEMBED_URI, 'align=bar&url=https://twitter.com/dunglas/statuses/438337742565826560');

        $tweetGetter = new TwitterClient(new Psr18Client(), new Psr17Factory());

        $this->assertSame($expected, $tweetGetter->getUriForSettings($settings));
    }

    public function testGetUriForSettingsByIdAndLink(): void
    {
        $settings = [
            'foo' => 'bar',
            'align' => 'bar',
            'url' => 'https://twitter.com/dunglas/statuses/438337742565826560',
            'id' => '438337742565826560',
        ];

        $expected = sprintf('%s?%s', TwitterClient::TWITTER_OEMBED_URI, 'align=bar&id=438337742565826560');

        $tweetGetter = new TwitterClient(new Psr18Client(), new Psr17Factory());

        $this->assertSame($expected, $tweetGetter->getUriForSettings($settings));
    }

    public function testLoadTweetByUrl(): void
    {
        $settings = [
            'url' => 'https://twitter.com/dunglas/statuses/438337742565826560',
            'foo' => 'bar',
            'align' => 'bar',
        ];

        $tweetGetter = new TwitterClient(new Psr18Client(), new Psr17Factory());

        $tweet = $tweetGetter->loadTweet($settings);
        $this->assertIsString($tweet);
        $this->assertSame(856, \strlen($tweet));
    }

    public function testLoadTweetById(): void
    {
        $settings = [
            'id' => '438337742565826560',
            'foo' => 'bar',
            'align' => 'bar',
        ];

        $tweetGetter = new TwitterClient(new Psr18Client(), new Psr17Factory());

        $tweet = $tweetGetter->loadTweet($settings);
        $this->assertIsString($tweet);
        $this->assertSame(856, \strlen($tweet));
    }

    public function testLoadTweetWithError(): void
    {
        $settings = [
            'foo' => 'bar',
            'align' => 'bar',
        ];

        $tweetGetter = new TwitterClient(new Psr18Client(), new Psr17Factory());

        $tweet = $tweetGetter->loadTweet($settings);

        $this->assertTrue(null === $tweet);
    }
}
