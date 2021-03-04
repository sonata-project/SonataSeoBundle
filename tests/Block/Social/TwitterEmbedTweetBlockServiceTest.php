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

namespace Sonata\SeoBundle\Tests\Block\Social;

use Nyholm\Psr7\Factory\Psr17Factory;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Sonata\BlockBundle\Util\OptionsResolver;
use Sonata\SeoBundle\Block\Social\TwitterEmbedTweetBlockService;
use Sonata\SeoBundle\Twitter\TweetGetter;
use Symfony\Component\HttpClient\Psr18Client;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
final class TwitterEmbedTweetBlockServiceTest extends BlockServiceTestCase
{
    public function testService()
    {
        $service = new TwitterEmbedTweetBlockService(
            '',
            $this->templating,
            null,
            null,
            new TweetGetter(new Psr18Client(), new Psr17Factory())
        );

        $block = new Block();
        $block->setType('core.text');
        $block->setSettings([
            'tweet' => 'https://twitter.com/dunglas/statuses/438337742565826560',
            'align' => 'bar',
        ]);

        $optionResolver = new OptionsResolver();
        $service->setDefaultSettings($optionResolver);

        $blockContext = new BlockContext($block, $optionResolver->resolve($block->getSettings()));

        $formMapper = $this->createMock(FormMapper::class, [], [], '', false);
        $formMapper->expects($this->exactly(2))->method('add');

        $service->buildCreateForm($formMapper, $block);
        $service->buildEditForm($formMapper, $block);

        $service->execute($blockContext);

        $this->assertIsString($blockContext->getSetting('tweet'));
        $this->assertSame(856, \strlen($blockContext->getSetting('tweet')));
    }
}
