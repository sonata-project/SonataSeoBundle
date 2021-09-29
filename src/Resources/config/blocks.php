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

use Sonata\SeoBundle\Block\Breadcrumb\HomepageBreadcrumbBlockService;
use Sonata\SeoBundle\Block\Social\EmailShareButtonBlockService;
use Sonata\SeoBundle\Block\Social\FacebookLikeBoxBlockService;
use Sonata\SeoBundle\Block\Social\FacebookLikeButtonBlockService;
use Sonata\SeoBundle\Block\Social\FacebookSendButtonBlockService;
use Sonata\SeoBundle\Block\Social\FacebookShareButtonBlockService;
use Sonata\SeoBundle\Block\Social\PinterestPinButtonBlockService;
use Sonata\SeoBundle\Block\Social\TwitterEmbedTweetBlockService;
use Sonata\SeoBundle\Block\Social\TwitterFollowButtonBlockService;
use Sonata\SeoBundle\Block\Social\TwitterHashtagButtonBlockService;
use Sonata\SeoBundle\Block\Social\TwitterMentionButtonBlockService;
use Sonata\SeoBundle\Block\Social\TwitterShareButtonBlockService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // Use "service" function for creating references to services when dropping support for Symfony 4.4
    // Use "param" function for creating references to parameters when dropping support for Symfony 5.1
    $containerConfigurator->parameters()
        ->set('sonata.seo.block.social.container.class', 'Sonata\SeoBundle\Block\Social\SocialBlockContainer')
        ->set('sonata.seo.block.email.share_button.class', EmailShareButtonBlockService::class)
        ->set('sonata.seo.block.facebook.like_box.class', FacebookLikeBoxBlockService::class)
        ->set('sonata.seo.block.facebook.like_button.class', FacebookLikeButtonBlockService::class)
        ->set('sonata.seo.block.facebook.send_button.class', FacebookSendButtonBlockService::class)
        ->set('sonata.seo.block.facebook.share_button.class', FacebookShareButtonBlockService::class)
        ->set('sonata.seo.block.twitter.share_button.class', TwitterShareButtonBlockService::class)
        ->set('sonata.seo.block.twitter.follow_button.class', TwitterFollowButtonBlockService::class)
        ->set('sonata.seo.block.twitter.hashtag_button.class', TwitterHashtagButtonBlockService::class)
        ->set('sonata.seo.block.twitter.mention_button.class', TwitterMentionButtonBlockService::class)
        ->set('sonata.seo.block.twitter.embed.class', TwitterEmbedTweetBlockService::class)
        ->set('sonata.seo.block.pinterest.pin_button.class', PinterestPinButtonBlockService::class)
        ->set('sonata.seo.block.breadcrumb.homepage.class', HomepageBreadcrumbBlockService::class);

    $containerConfigurator->services()

        // Email buttons
        ->set('sonata.seo.block.email.share_button', '%sonata.seo.block.email.share_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.email.share_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        // Facebook Social Plugins
        ->set('sonata.seo.block.facebook.like_box', '%sonata.seo.block.facebook.like_box.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.facebook.like_box',
                new ReferenceConfigurator('sonata.templating'),
            ])

        ->set('sonata.seo.block.facebook.like_button', '%sonata.seo.block.facebook.like_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.facebook.like_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        ->set('sonata.seo.block.facebook.send_button', '%sonata.seo.block.facebook.send_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.facebook.send_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        ->set('sonata.seo.block.facebook.share_button', '%sonata.seo.block.facebook.share_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.facebook.share_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        // Twitter buttons
        ->set('sonata.seo.block.twitter.share_button', '%sonata.seo.block.twitter.share_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.twitter.share_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        ->set('sonata.seo.block.twitter.follow_button', '%sonata.seo.block.twitter.follow_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.twitter.follow_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        ->set('sonata.seo.block.twitter.hashtag_button', '%sonata.seo.block.twitter.hashtag_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.twitter.hashtag_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        ->set('sonata.seo.block.twitter.mention_button', '%sonata.seo.block.twitter.mention_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.twitter.mention_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        // Twitter embed
        ->set('sonata.seo.block.twitter.embed', '%sonata.seo.block.twitter.embed.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.twitter.embed',
                new ReferenceConfigurator('sonata.templating'),
                (new ReferenceConfigurator('sonata.seo.http.client'))->nullOnInvalid(),
                (new ReferenceConfigurator('sonata.seo.http.message_factory'))->nullOnInvalid(),
            ])

        // Pinterest buttons
        ->set('sonata.seo.block.pinterest.pin_button', '%sonata.seo.block.pinterest.pin_button.class%')
            ->public()
            ->tag('sonata.block')
            ->args([
                'sonata.seo.block.pinterest.pin_button',
                new ReferenceConfigurator('sonata.templating'),
            ])

        // Breadcrumb
        ->set('sonata.seo.block.breadcrumb.homepage', '%sonata.seo.block.breadcrumb.homepage.class%')
            ->public()
            ->tag('sonata.block')
            ->tag('sonata.breadcrumb')
            ->args([
                'homepage',
                'sonata.seo.block.breadcrumb.homepage',
                new ReferenceConfigurator('sonata.templating'),
                new ReferenceConfigurator('knp_menu.menu_provider'),
                new ReferenceConfigurator('knp_menu.factory'),
            ]);
};
