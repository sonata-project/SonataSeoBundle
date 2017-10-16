<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\Block\Social;

use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Test\AbstractBlockServiceTestCase;
use Sonata\BlockBundle\Util\OptionsResolver;
use Sonata\SeoBundle\Block\Social\FacebookShareButtonBlockService;

class FacebookShareButtonBlockServiceTest extends AbstractBlockServiceTestCase
{
    public function testService()
    {
        $service = new FacebookShareButtonBlockService('sonata.block.service.facebook.share_button', $this->templating);

        $block = new Block();
        $block->setType('core.text');
        $block->setSettings([
            'url' => 'url_setting',
            'width' => 'width_setting',
            'layout' => 'layout_setting',
        ]);

        $optionResolver = new OptionsResolver();
        $service->setDefaultSettings($optionResolver);

        $blockContext = new BlockContext($block, $optionResolver->resolve($block->getSettings()));

        $formMapper = $this->createMock('Sonata\\AdminBundle\\Form\\FormMapper', [], [], '', false);
        $formMapper->expects($this->exactly(2))->method('add');

        $service->buildCreateForm($formMapper, $block);
        $service->buildEditForm($formMapper, $block);

        $service->execute($blockContext);

        $this->assertEquals('url_setting', $this->templating->parameters['settings']['url']);
        $this->assertEquals('width_setting', $this->templating->parameters['settings']['width']);
        $this->assertEquals('layout_setting', $this->templating->parameters['settings']['layout']);
    }
}
