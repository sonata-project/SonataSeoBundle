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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

final class TwitterClient
{
    public const TWITTER_OEMBED_URI = 'https://api.twitter.com/1/statuses/oembed.json';
    public const TWITTER_SUPPORTED_PARAMS = [
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

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var RequestFactoryInterface
     */
    private $messageFactory;

    public function __construct(
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $messageFactory = null
    ) {
        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param array<string, integer|string> $settings
     */
    public function loadTweet(array $settings): ?string
    {
        $uri = $this->getUriForSettings($settings);

        if (null === $uri) {
            return null;
        }

        if (null !== $this->httpClient && null !== $this->messageFactory) {
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

        // NEXT_MAJOR: Remove the old guzzle implementation

        // We matched an URL or an ID, we'll need to ask the API
        if (false === class_exists(Client::class)) {
            throw new \RuntimeException(
                'The guzzle http client library is required to call the Twitter API.'.
                'Make sure to add psr/http-client or guzzlehttp/guzzle to your composer.json.'
            );
        }

        @trigger_error(
            'The direct Guzzle implementation is deprecated since 2.10 and will be removed with the next major release.',
            \E_USER_DEPRECATED
        );

        // TODO cache API result
        $client = new Client(['curl.options' => [\CURLOPT_CONNECTTIMEOUT_MS => 1000]]);

        try {
            $request = $client->get($uri);
            $apiTweet = json_decode($request->getBody()->getContents(), true);

            return $apiTweet['html'];
        } catch (GuzzleException $e) {
            // log error
            return null;
        }
        // END NEXT_MAJOR
    }

    /**
     * @param array<string, integer|string> $settings
     */
    public function getUriForSettings(array $settings): ?string
    {
        $parameters = [];
        $apiParams = $settings;

        if (isset($apiParams['id'])) {
            unset($apiParams['url']);
        }

        foreach ($apiParams as $key => $value) {
            if ($value && \in_array($key, self::TWITTER_SUPPORTED_PARAMS, true)) {
                $parameters[] = $key.'='.$value;
            }
        }

        if (isset($apiParams['id']) || isset($apiParams['url'])) {
            return sprintf('%s?%s', self::TWITTER_OEMBED_URI, implode('&', $parameters));
        }

        return null;
    }
}
