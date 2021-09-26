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

namespace Sonata\SeoBundle\Event;

use Sonata\BlockBundle\Block\BlockServiceInterface;
use Sonata\BlockBundle\Event\BlockEvent;
use Sonata\BlockBundle\Model\Block;
use Sonata\SeoBundle\BreadcrumbInterface;

/**
 * @final since sonata-project/seo-bundle 2.14
 *
 * BreadcrumbListener for Block Event.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class BreadcrumbListener
{
    /**
     * @var array
     */
    protected $blockServices = [];

    /**
     * Add a renderer to the status services list.
     *
     * @param string              $type
     * @param BreadcrumbInterface $breadcrumb
     *
     * NEXT_MAJOR: Require BreadcrumbInterface instead of BlockServiceInterface
     */
    public function addBlockService($type, BlockServiceInterface $breadcrumb)
    {
        if (!$breadcrumb instanceof BreadcrumbInterface) {
            @trigger_error(
                sprintf('Passing a %s class is deprecated since sonata-project/seo-bundle 2.12, pass a %s instead.', BlockServiceInterface::class, BreadcrumbInterface::class),
                \E_USER_DEPRECATED
            );
        }

        $this->blockServices[$type] = $breadcrumb;
    }

    /**
     * Add context related BlockService, if found.
     */
    public function onBlock(BlockEvent $event)
    {
        $context = $event->getSetting('context', null);

        if (null === $context) {
            return;
        }

        foreach ($this->blockServices as $type => $blockService) {
            if ($blockService->handleContext($context)) {
                $block = new Block();
                $block->setId(uniqid());
                $block->setSettings($event->getSettings());
                $block->setType($type);

                $event->addBlock($block);

                return;
            }
        }
    }
}
