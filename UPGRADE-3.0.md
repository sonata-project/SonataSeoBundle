UPGRADE FROM 2.X to 3.0
=======================

## SeoPage

If you have implemented a custom seo page, you must adapt the signature of the following new methods to match the one in `SeoPageInterface` again:
 * `removeMeta`
 * `removeHtmlAttributes`
 * `hasHtmlAttribute`
 * `removeHeadAttribute`
 * `hasHeadAttribute`
 * `removeLangAlternate`
 * `hasLangAlternate`

## Closed API

Many classes have been made final, meaning you can no longer extend them.
Consider using decoration instead.

 * `Sonata\BlockBundle\SonataSeoBundle`
 * `Sonata\BlockBundle\Block\Breadcrumb\HomepageBreadcrumbBlockService`
 * `Sonata\BlockBundle\Block\Social\EmailShareButtonBlockService`
 * `Sonata\BlockBundle\Block\Social\FacebookLikeBoxBlockService`
 * `Sonata\BlockBundle\Block\Social\FacebookLikeButtonBlockService`
 * `Sonata\BlockBundle\Block\Social\FacebookSendButtonBlockService`
 * `Sonata\BlockBundle\Block\Social\FacebookShareButtonBlockService`
 * `Sonata\BlockBundle\Block\Social\PinterestPinButtonBlockService`
 * `Sonata\BlockBundle\Block\Social\TwitterFollowButtonBlockService`
 * `Sonata\BlockBundle\Block\Social\TwitterHashtagButtonBlockService`
 * `Sonata\BlockBundle\Block\Social\TwitterMentionButtonBlockService`
 * `Sonata\BlockBundle\Block\Social\TwitterShareButtonBlockService`
 * `Sonata\BlockBundle\Command\SitemapGeneratorCommand`
 * `Sonata\BlockBundle\DependencyInjection\Compiler\BreadcrumbBlockServicesCompilerPass`
 * `Sonata\BlockBundle\DependencyInjection\Compiler\ServiceCompilerPass`
 * `Sonata\BlockBundle\DependencyInjection\Configuration`
 * `Sonata\BlockBundle\DependencyInjection\SonataSeoExtension`
 * `Sonata\BlockBundle\Event\BreadcrumbListener`
 * `Sonata\BlockBundle\Seo\SeoPage`
 * `Sonata\BlockBundle\Sitemap\SourceManager`
 * `Sonata\BlockBundle\Twig\Extension\SeoExtension`
