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
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\EditableBlockService;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Meta\MetadataInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Type\ImmutableArrayType;
use Sonata\Form\Validator\ErrorElement;
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
class TwitterEmbedTweetBlockService extends BaseTwitterButtonBlockService implements EditableBlockService
{
    public const TWITTER_OEMBED_URI = 'https://api.twitter.com/1/statuses/oembed.json';
    private const TWEET_URL_PATTERN = '%^(https://)(www.)?(twitter.com/)(.*)(/status)(es)?(/)([0-9]*)$%i';
    private const TWEET_ID_PATTERN = '%^([0-9]*)$%';

    /**
     * @var ClientInterface|null
     */
    private $httpClient;

    /**
     * @var RequestFactoryInterface|null
     */
    private $messageFactory;

    public function __construct(
        Environment $twig,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $messageFactory = null
    ) {
        parent::__construct($twig);

        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
    }

    public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'tweet' => $this->loadTweet($blockContext),
        ], $response);
    }

    public function configureSettings(OptionsResolver $resolver): void
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

    public function configureCreateForm(FormMapper $formMapper, BlockInterface $block): void
    {
        $this->configureEditForm($formMapper, $block);
    }

    public function configureEditForm(FormMapper $formMapper, BlockInterface $block): void
    {
        $formMapper->add('settings', ImmutableArrayType::class, [
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

    public function validate(ErrorElement $errorElement, BlockInterface $block): void
    {
    }

    public function getMetadata(): MetadataInterface
    {
        return new Metadata('sonata.seo.block.twitter.embed', null, null, 'SonataSeoBundle', [
            'class' => 'fa fa-twitter',
        ]);
    }

    /**
     * Returns supported API parameters from settings.
     *
     * @return array
     */
    protected function getSupportedApiParams()
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

    /**
     * Builds the API query URI based on $settings.
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
     */
    private function loadTweet(BlockContextInterface $blockContext): ?string
    {
        $uriMatched = preg_match(self::TWEET_URL_PATTERN, $blockContext->getSetting('tweet'));

        if (!$uriMatched || !preg_match(self::TWEET_ID_PATTERN, $blockContext->getSetting('tweet'))) {
            return null;
        }

        if (null !== $this->httpClient && null !== $this->messageFactory) {
            try {
                $response = $this->httpClient->sendRequest(
                    $this->messageFactory->createRequest(
                        'GET',
                        $this->buildUri($uriMatched, $blockContext->getSettings())
                    )
                );
            } catch (ClientExceptionInterface $e) {
                // log error
                return null;
            }

            $apiTweet = json_decode($response->getBody(), true);

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
        $client = new \GuzzleHttp\Client();
        $client->setConfig(['curl.options' => [\CURLOPT_CONNECTTIMEOUT_MS => 1000]]);

        try {
            $request = $client->get($this->buildUri($uriMatched, $blockContext->getSettings()));
            $apiTweet = json_decode($request->send()->getBody(true), true);

            return $apiTweet['html'];
        } catch (GuzzleException $e) {
            // log error
            return null;
        }
        // END NEXT_MAJOR
    }
}
