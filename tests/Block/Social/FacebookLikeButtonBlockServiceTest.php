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

use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Form\Mapper\FormMapper;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Test\BlockServiceTestCase;
use Sonata\SeoBundle\Block\Social\FacebookLikeButtonBlockService;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class FacebookLikeButtonBlockServiceTest extends BlockServiceTestCase
{
    public function testService(): void
    {
        $service = new FacebookLikeButtonBlockService(
            $this->twig
        );

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
        $service->configureSettings($optionResolver);

        $blockContext = new BlockContext($block, $optionResolver->resolve($block->getSettings()));

        $formMapper = $this->createMock(FormMapper::class, [], [], '', false);
        $formMapper->expects($this->exactly(2))->method('add');

        $service->configureCreateForm($formMapper, $block);
        $service->configureEditForm($formMapper, $block);

        $this->twig->expects($this->once())->method('render')
            ->with('@SonataSeo/Block/block_facebook_like_button.html.twig', [
               'block' => $block,
               'settings' => [
                   'url' => 'url_setting',
                   'width' => 'width_setting',
                   'show_faces' => 'show_faces_setting',
                   'share' => 'share_setting',
                   'layout' => 'layout_setting',
                   'colorscheme' => 'colorscheme_setting',
                   'action' => 'action_setting',
                   'template' => '@SonataSeo/Block/block_facebook_like_button.html.twig',
               ],
            ]);

        $service->execute($blockContext);
    }
}
