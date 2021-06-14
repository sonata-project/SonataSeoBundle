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

use GuzzleHttp\Exception\GuzzleException;
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
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $messageFactory = null
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
        if (false === class_exists('GuzzleHttp\Client')) {
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
        $client = new \GuzzleHttp\Client(['curl.options' => [\CURLOPT_CONNECTTIMEOUT_MS => 1000]]);

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

    public function getUriForSettings(array $settings): ?string
    {
        $apiParams = $settings;

        if (isset($settings['tweet'])) {
            $uriMatched = preg_match(self::TWEET_URL_PATTERN, $settings['tweet']);
            $idMatched = preg_match(self::TWEET_ID_PATTERN, $settings['tweet']);

            if (!$uriMatched && !$idMatched) {
                return null;
            }

            if ($uriMatched) {
                // We matched the uri
                $apiParams['url'] = $settings['tweet'];
            } else {
                $apiParams['id'] = $settings['tweet'];
            }
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
