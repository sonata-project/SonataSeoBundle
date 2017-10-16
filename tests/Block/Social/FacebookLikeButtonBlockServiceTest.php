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
use Sonata\SeoBundle\Block\Social\FacebookLikeButtonBlockService;

class FacebookLikeButtonBlockServiceTest extends AbstractBlockServiceTestCase
{
    public function testService()
    {
        $service = new FacebookLikeButtonBlockService('sonata.block.service.facebook.like_button', $this->templating);

        $block = new Block();
        $block->setType('core.text');
        $block->setSettings([
            'url' => 'url_setting',
            'width' => 'width_setting',
            'show_faces' => 'show_faces_setting',
            'share' => 'share_setting',
            'layout' => 'layout_setting',
            'colorscheme' => 'colorscheme_setting',
            'action' => 'action_setting',
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
        $this->assertEquals('show_faces_setting', $this->templating->parameters['settings']['show_faces']);
        $this->assertEquals('share_setting', $this->templating->parameters['settings']['share']);
        $this->assertEquals('layout_setting', $this->templating->parameters['settings']['layout']);
        $this->assertEquals('colorscheme_setting', $this->templating->parameters['settings']['colorscheme']);
        $this->assertEquals('action_setting', $this->templating->parameters['settings']['action']);
    }
}
