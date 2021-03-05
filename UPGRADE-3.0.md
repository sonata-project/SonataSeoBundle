UPGRADE FROM 2.X to 3.0
=======================

## guzzlehttp/guzzle

If you are using `sonata.seo.block.twitter.embed` service with Guzzle, you MUST create a custom service based on the Guzzle client and add it to configuration:

    sontata_seo:
        http:
            client: `your_custom.guzzle_client` # Psr\Http\Client\ClientInterface
            message_factory: `your_custom.message_facory` # Psr\Http\Message\RequestFactoryInterface

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
 * `Sonata\BlockBundle\Block\Social\TwitterEmbedTweetBlockService`
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
