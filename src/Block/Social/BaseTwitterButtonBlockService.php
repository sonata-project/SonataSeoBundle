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

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract class for Twitter Buttons blocks services.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseTwitterButtonBlockService extends AbstractAdminBlockService
{
    /**
     * @var string[]
     */
    protected $languageList = [
        'fr' => 'fr',
        'en' => 'en',
        'ar' => 'ar',
        'ja' => 'ja',
        'es' => 'es',
        'de' => 'de',
        'it' => 'it',
        'id' => 'id',
        'pt' => 'pt',
        'ko' => 'ko',
        'tr' => 'tr',
        'ru' => 'ru',
        'nl' => 'nl',
        'fil' => 'fil',
        'msa' => 'msa',
        'zh-tw' => 'zh-tw',
        'zh-cn' => 'zh-cn',
        'hi' => 'hi',
        'no' => 'no',
        'sv' => 'sv',
        'fi' => 'fi',
        'da' => 'da',
        'pl' => 'pl',
        'hu' => 'hu',
        'fa' => 'fa',
        'he' => 'he',
        'ur' => 'ur',
        'th' => 'th',
        'uk' => 'uk',
        'ca' => 'ca',
        'el' => 'el',
        'eu' => 'eu',
        'cs' => 'cs',
        'af' => 'af',
        'xx-lc' => 'xx-lc',
        'gl' => 'gl',
        'ro' => 'ro',
        'hr' => 'hr',
        'ckb' => 'ckb',
        'en-gb' => 'en-gb',
    ];

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
        ], $response);
    }
}
