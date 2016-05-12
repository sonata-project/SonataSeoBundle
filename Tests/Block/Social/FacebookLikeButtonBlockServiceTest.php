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
use Sonata\BlockBundle\Tests\Block\Service\FakeTemplating;
use Sonata\BlockBundle\Util\OptionsResolver;
use Sonata\SeoBundle\Block\Social\FacebookLikeButtonBlockService;
use Sonata\SeoBundle\Tests\Block\BaseBlockTest;

class FacebookLikeButtonBlockServiceTest extends BaseBlockTest
{
    public function testService()
    {
        if (!$this->checkBlockBundle()) {
            $this->markTestSkipped('Sonata BlockBundle is not installed.');

            return;
        }

        $templating = new FakeTemplating();
        $service = new FacebookLikeButtonBlockService('sonata.block.service.facebook.like_button', $templating);

        $block = new Block();
        $block->setType('core.text');
        $block->setSettings(array(
            'url' => 'url_setting',
            'width' => 'width_setting',
            'show_faces' => 'show_faces_setting',
            'share' => 'share_setting',
            'layout' => 'layout_setting',
            'colorscheme' => 'colorscheme_setting',
            'action' => 'action_setting',
        ));

        $optionResolver = new OptionsResolver();
        $service->setDefaultSettings($optionResolver);

        $blockContext = new BlockContext($block, $optionResolver->resolve($block->getSettings()));

        $formMapper = $this->getMock('Sonata\\AdminBundle\\Form\\FormMapper', array(), array(), '', false);
        $formMapper->expects($this->exactly(2))->method('add');

        $service->buildCreateForm($formMapper, $block);
        $service->buildEditForm($formMapper, $block);

        $service->execute($blockContext);

        $this->assertEquals('url_setting', $templating->parameters['settings']['url']);
        $this->assertEquals('width_setting', $templating->parameters['settings']['width']);
        $this->assertEquals('show_faces_setting', $templating->parameters['settings']['show_faces']);
        $this->assertEquals('share_setting', $templating->parameters['settings']['share']);
        $this->assertEquals('layout_setting', $templating->parameters['settings']['layout']);
        $this->assertEquals('colorscheme_setting', $templating->parameters['settings']['colorscheme']);
        $this->assertEquals('action_setting', $templating->parameters['settings']['action']);
    }
}
