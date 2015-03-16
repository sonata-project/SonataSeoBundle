<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\SeoBundle\Block\Social;

use Guzzle\Http\Exception\CurlException;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TwitterEmbedTweetBlockService
 *
 * This block service allows to embed a tweet by requesting the Twitter API.
 *
 * @see https://dev.twitter.com/docs/api/1/get/statuses/oembed
 *
 * @package Sonata\SeoBundle\Block\Social
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class TwitterEmbedTweetBlockService extends BaseTwitterButtonBlockService
{
    const TWITTER_OEMBED_URI = "https://api.twitter.com/1/statuses/oembed.json";
    const TWEET_URL_PATTERN  = "%^(https://)(www.)?(twitter.com/)(.*)(/status)(es)?(/)([0-9]*)$%i";
    const TWEET_ID_PATTERN   = "%^([0-9]*)$%";

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $tweet = $blockContext->getSetting('tweet');

        if (($uriMatched = preg_match(TwitterEmbedTweetBlockService::TWEET_URL_PATTERN, $tweet))
            || preg_match(TwitterEmbedTweetBlockService::TWEET_ID_PATTERN, $tweet)) {
            // We matched an URL or an ID, we'll need to ask the API
            if (class_exists('Guzzle\Http\Client') === false) {
                throw new \RuntimeException("The guzzle http client library is required to call the Twitter API. Make sure to add guzzle/guzzle to your composer.json.");
            }

            // TODO cache API result
            $client = new \Guzzle\Http\Client();
            $client->setConfig(array('curl.options' => array(CURLOPT_CONNECTTIMEOUT_MS => 1000)));

            try {
                $request = $client->get($this->buildUri($uriMatched, $blockContext->getSettings()));
                $apiTweet = json_decode($request->send()->getBody(true), true);

                $tweet = $apiTweet['html'];
            } catch (CurlException $e) {
                // log error
            }
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'block' => $blockContext->getBlock(),
            'tweet' => $tweet,
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template'    => 'SonataSeoBundle:Block:block_twitter_embed.html.twig',
            'tweet'       => "",
            'maxwidth'    => null,      // Should be between 250 and 550px
            'hide_media'  => false,
            'hide_thread' => false,
            'omit_script' => false,     // Should be asked for only once in a page
            'align'       => 'none',    // Left, right, center or none
            'related'     => null,      // Accounts related to content
            'lang'        => $this->languageList
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
        $form->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('tweet', 'textarea', array('required' => true, 'help_block' => 'Tweet id, URL or content. If you put the HTML content directly, other options won\'t be handled.')),
                array('maxwidth', 'integer', array('required' => false, 'help_block' => 'Must be contained between 250 and 550')),
                array('hide_media', 'checkbox', array('required' => false, 'help_block' => 'Hide media contained in tweet?')),
                array('hide_thread', 'checkbox', array('required' => false, 'help_block' => 'Show discussion?')),
                array('omit_script', 'checkbox', array('required' => false, 'help_block' => 'Should be checked once and only once per page. If you embed several tweets in the page, uncheck this on the other ones.')),
                array('align', 'choice', array('required' => false, 'choices' => array('left', 'right', 'center', 'none'))),
                array('related', 'text', array('required' => false, 'help_block' => "See 'related' argument in https://dev.twitter.com/docs/intents")),
                array('lang', 'choice', array('required' => true, 'choices' => $this->languageList)),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Twitter embed tweet';
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * Returns supported API parameters from settings
     *
     * @return array
     */
    protected function getSupportedApiParams()
    {
        return array(
            'maxwidth',
            'hide_media',
            'hide_thread',
            'omit_script',
            'align',
            'related',
            'lang',
            'url',
            'id'
        );
    }

    /**
     * Builds the API query URI based on $settings
     *
     * @param bool  $uriMatched
     * @param array $settings
     *
     * @return string
     */
    protected function buildUri($uriMatched, array $settings)
    {
        $apiParams       = $settings;
        $supportedParams = $this->getSupportedApiParams();

        if ($uriMatched) {
            // We matched the uri
            $apiParams['url'] = $settings['tweet'];
        } else {
            $apiParams['id'] = $settings['tweet'];
        }

        unset($apiParams['tweet']);

        $parameters = array();
        foreach ($apiParams as $key => $value) {
            if ($value && in_array($key, $supportedParams)) {
                $parameters[] = $key."=".$value;
            }
        }

        return sprintf("%s?%s", TwitterEmbedTweetBlockService::TWITTER_OEMBED_URI, implode("&", $parameters));
    }
}
