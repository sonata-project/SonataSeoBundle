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
    protected $blockServices = [];

    /**
     * @var array
     */
    protected $contextServices = [];

    /**
     * Add a renderer to the status services list.
     *
     * @param string                $type
     * @param BlockServiceInterface $blockService
     *
     * @deprecated since 2.x, use BreadcrumbListener::addBlockContext instead
     */
    public function addBlockService($type, BlockServiceInterface $blockService)
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.x, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::addBlockContext() instead.',
            E_USER_DEPRECATED
        );

        $this->blockServices[$type] = $blockService;
    }

    /**
     * Binds a block service to a context.
     *
     * @param string $context
     * @param string $serviceId
     */
    public function addBlockContext($context, $serviceId)
    {
        $this->contextServices[$context] = $serviceId;
    }

    /**
     * Add context related BlockService, if found.
     *
     * @param BlockEvent $event
     */
    public function onBlock(BlockEvent $event)
    {
        $context = $event->getSetting('context', null);

        if (null == $context) {
            return;
        }

        if (isset($this->contextServices[$context])) {
            $block = new Block();
            $block->setId(uniqid());
            $block->setSettings($event->getSettings());
            $block->setType($this->contextServices[$context]);

            $event->addBlock($block);

            return;
        }

        // NEXT_MAJOR: remove this block
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
