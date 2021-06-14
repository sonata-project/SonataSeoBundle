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

namespace Sonata\SeoBundle\Block\Social;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Type\ImmutableArrayType;
use Sonata\SeoBundle\Twitter\TwitterClient;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

/**
 * This block service allows to embed a tweet by requesting the Twitter API.
 *
 * @see https://dev.twitter.com/docs/api/1/get/statuses/oembed
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class TwitterEmbedTweetBlockService extends BaseTwitterButtonBlockService
{
    /**
     * @deprecated since 2.x, to be removed in 3.0. Use "Sonata\SeoBundle\Twitter\TwitterClient::TWITTER_OEMBED_URI" instead.
     */
    public const TWITTER_OEMBED_URI = 'https://api.twitter.com/1/statuses/oembed.json';
    public const TWEET_URL_PATTERN = '%^(https://)(www.)?(twitter.com/)(.*)(/status)(es)?(/)([0-9]*)$%i';
    public const TWEET_ID_PATTERN = '%^([0-9]*)$%';

    /**
     * @var ClientInterface|null
     *
     * @deprecated since 2.x, to be removed in 3.0.
     */
    private $httpClient;

    /**
     * @var RequestFactoryInterface|null
     *
     * @deprecated since 2.x, to be removed in 3.0.
     */
    private $messageFactory;

    /**
     * @var TwitterClient|null
     */
    private $twitterClient;

    /**
     * @param Environment|EngineInterface|string|null $twigOrDeprecatedName
     * @param TwitterClient|EngineInterface           $twitterClientOrDeprecatedTemplating
     */
    public function __construct(
        $twigOrDeprecatedName,
        $twitterClientOrDeprecatedTemplating,
        ?ClientInterface $deprecatedHttpClient = null,
        ?RequestFactoryInterface $deprecatedMessageFactory = null,
        ?TwitterClient $deprecatedTwitterClient = null
    ) {
        if ($twitterClientOrDeprecatedTemplating instanceof TwitterClient) {
            if (!$twigOrDeprecatedName instanceof Environment) {
                throw new \TypeError(sprintf(
                    'Argument 1 passed to %s() must be an instance of %s, %s given.',
                    __METHOD__,
                    Environment::class,
                    \is_object($twigOrDeprecatedName) ? 'instance of '.\get_class($twigOrDeprecatedName) : \gettype($twigOrDeprecatedName)
                ));
            }

            parent::__construct($twigOrDeprecatedName);

            $this->twitterClient = $twitterClientOrDeprecatedTemplating;
        } elseif (null === $twitterClientOrDeprecatedTemplating || $twitterClientOrDeprecatedTemplating instanceof EngineInterface) {
            if (is_subclass_of($this,TwitterEmbedTweetBlockService::class)) {
                @trigger_error(sprintf(
                    'Passing %s as argument 2 to %s() is deprecated since sonata-project/seo-bundle 2.x'
                    .' and will throw a \TypeError in version 3.0. You must pass an instance of %s instead.',
                    null === $twitterClientOrDeprecatedTemplating ? 'null' : EngineInterface::class,
                    __METHOD__,
                    TwitterClient::class
                ), \E_USER_DEPRECATED);
            }

            parent::__construct($twigOrDeprecatedName, $twitterClientOrDeprecatedTemplating);

            $this->httpClient = $deprecatedHttpClient;
            $this->messageFactory = $deprecatedMessageFactory;
            $this->twitterClient = $deprecatedTwitterClient;
        } else {
            throw new \TypeError(sprintf(
                'Argument 2 passed to %s() must be an instance of %s, %s given.',
                __METHOD__,
                TwitterClient::class,
                null === $twitterClientOrDeprecatedTemplating ? 'null' : 'instance of '.\get_class($twitterClientOrDeprecatedTemplating)
            ));
        }
    }

    public function execute(BlockContextInterface $blockContext, ?Response $response = null)
    {
        if (null !== $this->twitterClient) {
            $apiParams = $blockContext->getSettings();

            $uriMatched = preg_match(self::TWEET_URL_PATTERN, $blockContext->getSetting('tweet'));
            $idMatched = preg_match(self::TWEET_ID_PATTERN, $blockContext->getSetting('tweet'));

            if ($uriMatched) {
                $apiParams['url'] = $blockContext->getSetting('tweet');
            } elseif ($idMatched) {
                $apiParams['id'] = $blockContext->getSetting('tweet');
            } else {
                return $this->renderResponse($blockContext->getTemplate(), [
                    'block' => $blockContext->getBlock(),
                    'tweet' => $blockContext->getSetting('tweet'),
                ], $response);
            }

            return $this->renderResponse($blockContext->getTemplate(), [
                'block' => $blockContext->getBlock(),
                'tweet' => $this->twitterClient->loadTweet($apiParams),
            ], $response);
        }

        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'tweet' => $this->loadTweet($blockContext),
        ], $response);
    }

    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => '@SonataSeo/Block/block_twitter_embed.html.twig',
            'tweet' => '',
            'maxwidth' => null,
            'hide_media' => false,
            'hide_thread' => false,
            'omit_script' => false,
            'align' => 'none',
            'related' => null,
            'lang' => null,
        ]);
    }

    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
        $form->add('settings', ImmutableArrayType::class, [
            'keys' => [
                ['tweet', TextareaType::class, [
                    'required' => true,
                    'label' => 'form.label_tweet',
                    'sonata_help' => 'form.help_tweet',
                ]],
                ['maxwidth', IntegerType::class, [
                    'required' => false,
                    'label' => 'form.label_maxwidth',
                    'sonata_help' => 'form.help_maxwidth',
                ]],
                ['hide_media', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_hide_media',
                    'sonata_help' => 'form.help_hide_media',
                ]],
                ['hide_thread', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_hide_thread',
                    'sonata_help' => 'form.help_hide_thread',
                ]],
                ['omit_script', CheckboxType::class, [
                    'required' => false,
                    'label' => 'form.label_omit_script',
                    'sonata_help' => 'form.help_omit_script',
                ]],
                ['align', ChoiceType::class, [
                    'required' => false,
                    'choices' => [
                        'left' => 'form.label_align_left',
                        'right' => 'form.label_align_right',
                        'center' => 'form.label_align_center',
                        'none' => 'form.label_align_none',
                    ],
                    'label' => 'form.label_align',
                ]],
                ['related', TextType::class, [
                    'required' => false,
                    'label' => 'form.label_related',
                    'sonata_help' => 'form.help_related',
                ]],
                ['lang', ChoiceType::class, [
                    'required' => true,
                    'choices' => $this->languageList,
                    'label' => 'form.label_lang',
                ]],
            ],
            'translation_domain' => 'SonataSeoBundle',
        ]);
    }

    public function getBlockMetadata($code = null)
    {
        return new Metadata($this->getName(), (null !== $code ? $code : $this->getName()), false, 'SonataSeoBundle', [
            'class' => 'fa fa-twitter',
        ]);
    }

    /**
     * Returns supported API parameters from settings.
     *
     * @deprecated since 2.x, to be removed in 3.0.
     *
     * @return array
     */
    protected function getSupportedApiParams()
    {
        return TwitterClient::TWITTER_SUPPORTED_PARAMS;
    }

    /**
     * Builds the API query URI based on $settings.
     *
     * @deprecated since 2.x, to be removed in 3.0.
     *
     * @param bool $uriMatched
     *
     * @return string
     */
    protected function buildUri($uriMatched, array $settings)
    {
        $apiParams = $settings;
        $supportedParams = $this->getSupportedApiParams();

        if ($uriMatched) {
            // We matched the uri
            $apiParams['url'] = $settings['tweet'];
        } else {
            $apiParams['id'] = $settings['tweet'];
        }

        unset($apiParams['tweet']);

        $parameters = [];
        foreach ($apiParams as $key => $value) {
            if ($value && \in_array($key, $supportedParams, true)) {
                $parameters[] = $key.'='.$value;
            }
        }

        return sprintf('%s?%s', self::TWITTER_OEMBED_URI, implode('&', $parameters));
    }

    /**
     * Loads twitter tweet.
     *
     * @deprecated since 2.x, to be removed in 3.0.
     */
    private function loadTweet(BlockContextInterface $blockContext): ?string
    {
        $uriMatched = preg_match(self::TWEET_URL_PATTERN, $blockContext->getSetting('tweet'));

        if (!$uriMatched || !preg_match(self::TWEET_ID_PATTERN, $blockContext->getSetting('tweet'))) {
            return $blockContext->getSetting('tweet');
        }

        $uri = $this->buildUri($uriMatched, $blockContext->getSettings());

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
            $request = $client->get($this->buildUri($uriMatched, $blockContext->getSettings()));
            $apiTweet = json_decode($request->getBody()->getContents(), true);

            return $apiTweet['html'];
        } catch (GuzzleException $e) {
            // log error
            return null;
        }
        // END NEXT_MAJOR
    }
}
