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

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract class for Facebook Social Plugins blocks services.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseFacebookSocialPluginsBlockService extends AbstractBlockService
{
    /**
     * @var string[]
     */
    protected $colorschemeList = [
        'light' => 'form.label_colorscheme_light',
        'dark' => 'form.label_colorscheme_dark',
    ];

    public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        $settings = $blockContext->getSettings();

        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
        ], $response);
    }
}
