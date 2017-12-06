<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Block\Social;

use Guzzle\Http\Exception\CurlException;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Sonata\CoreBundle\Model\Metadata;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This block service allows to embed a tweet by requesting the Twitter API.
 *
 * @see https://dev.twitter.com/docs/api/1/get/statuses/oembed
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class TwitterEmbedTweetBlockService extends BaseTwitterButtonBlockService
{
    const TWITTER_OEMBED_URI = 'https://api.twitter.com/1/statuses/oembed.json';
    const TWEET_URL_PATTERN = '%^(https://)(www.)?(twitter.com/)(.*)(/status)(es)?(/)([0-9]*)$%i';
    const TWEET_ID_PATTERN = '%^([0-9]*)$%';

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $tweet = $blockContext->getSetting('tweet');

        if (($uriMatched = preg_match(self::TWEET_URL_PATTERN, $tweet))
            || preg_match(self::TWEET_ID_PATTERN, $tweet)) {
            // We matched an URL or an ID, we'll need to ask the API
            if (false === class_exists('Guzzle\Http\Client')) {
                throw new \RuntimeException('The guzzle http client library is required to call the Twitter API. Make sure to add guzzle/guzzle to your composer.json.');
            }

            // TODO cache API result
            $client = new \Guzzle\Http\Client();
            $client->setConfig(['curl.options' => [CURLOPT_CONNECTTIMEOUT_MS => 1000]]);

            try {
                $request = $client->get($this->buildUri($uriMatched, $blockContext->getSettings()));
                $apiTweet = json_decode($request->send()->getBody(true), true);

                $tweet = $apiTweet['html'];
            } catch (CurlException $e) {
                // log error
            }
        }

        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'tweet' => $tweet,
        ], $response);
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => 'SonataSeoBundle:Block:block_twitter_embed.html.twig',
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function getBlockMetadata($code = null)
    {
        return new Metadata($this->getName(), (null !== $code ? $code : $this->getName()), false, 'SonataSeoBundle', [
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
     * @param bool  $uriMatched
     * @param array $settings
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
            if ($value && in_array($key, $supportedParams)) {
                $parameters[] = $key.'='.$value;
            }
        }

        return sprintf('%s?%s', self::TWITTER_OEMBED_URI, implode('&', $parameters));
    }
}
