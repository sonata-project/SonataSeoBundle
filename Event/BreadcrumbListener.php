<?php

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

/**
 * BreadcrumbListener for Block Event.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class BreadcrumbListener
{
    /**
     * @var array
     */
    protected $blockServices = array();

    /**
     * Add a renderer to the status services list.
     *
     * @param string                $type
     * @param BlockServiceInterface $blockService
     */
    public function addBlockService($type, BlockServiceInterface $blockService)
    {
        $this->blockServices[$type] = $blockService;
    }

    /**
     * Add context related BlockService, if found.
     *
     * @param BlockEvent $event
     */
    public function onBlock(BlockEvent $event)
    {
        $context = $event->getSetting('context', null);

        if ($context == null) {
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
