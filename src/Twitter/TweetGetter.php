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

namespace Sonata\SeoBundle\Twitter;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class TweetGetter
{
    public const TWITTER_OEMBED_URI = 'https://api.twitter.com/1/statuses/oembed.json';
    public const TWEET_URL_PATTERN = '%^(https://)(www.)?(twitter.com/)(.*)(/status)(es)?(/)([0-9]*)$%i';
    public const TWEET_ID_PATTERN = '%^([0-9]*)$%';

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var RequestFactoryInterface
     */
    private $messageFactory;

    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $messageFactory
    ) {
        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param array<string, mixed> $settings
     */
    public function loadTweet(array $settings): ?string
    {
        $uri = $this->getUriForSettings($settings);

        if (null === $uri) {
            return $settings['tweet'] ?? null;
        }

        try {
            $response = $this->httpClient->sendRequest(
                $this->messageFactory->createRequest('GET', $uri)
            );
        } catch (ClientExceptionInterface $e) {
            // log error
            return null;
        }

        $apiTweet = json_decode($response->getBody()->getContents(), true);

        return $apiTweet['html'];
    }

    public function getUriForSettings(array $settings): ?string
    {
        $apiParams = $settings;

        if (isset($settings['tweet'])) {
            $uriMatched = preg_match(self::TWEET_URL_PATTERN, $settings['tweet']);

            if (!$uriMatched && !preg_match(self::TWEET_ID_PATTERN, $settings['tweet'])) {
                return null;
            }

            if ($uriMatched) {
                // We matched the uri
                $apiParams['url'] = $settings['tweet'];
            } else {
                $apiParams['id'] = $settings['tweet'];
            }

            unset($apiParams['tweet']);
        }

        $parameters = [];
        foreach ($apiParams as $key => $value) {
            if ($value && \in_array($key, $this->getSupportedApiParams(), true)) {
                $parameters[] = $key.'='.$value;
            }
        }

        if (isset($apiParams['id']) || isset($apiParams['url'])) {
            return sprintf('%s?%s', self::TWITTER_OEMBED_URI, implode('&', $parameters));
        }

        return null;
    }

    /**
     * @return array<string>
     */
    protected function getSupportedApiParams(): array
    {
        return [
            'maxwidth',
            'hide_media',
            'hide_thread',
            'omit_script',
            'align',
            'related',
            'lang',
            'url',
            'id',
        ];
    }
}
