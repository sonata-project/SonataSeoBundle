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

use Sonata\BlockBundle\Event\BlockEvent;
use Sonata\BlockBundle\Model\Block;
use Sonata\SeoBundle\Block\Breadcrumb\BreadcrumbBlockService;

/**
 * BreadcrumbListener for Block Event.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
final class BreadcrumbListener
{
    /**
     * @var array<string, BreadcrumbBlockService>
     */
    private array $blockServices = [];

    /**
     * Add a renderer to the status services list.
     */
    public function addBlockService(string $type, BreadcrumbBlockService $breadcrumb): void
    {
        $this->blockServices[$type] = $breadcrumb;
    }

    /**
     * Add context related BlockService, if found.
     */
    public function onBlock(BlockEvent $event): void
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
