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
 * `addTitlePrefix`
 * `addTitleSuffix`
 * `getOriginalTitle`
 * `setBreadcrumb`
 * `getBreadcrumbOptions`

## Closed API

Many classes have been made final, meaning you can no longer extend them.
Consider using decoration instead.

 * `Sonata\BlockBundle\SonataSeoBundle`
 * `Sonata\BlockBundle\Block\Breadcrumb\HomepageBreadcrumbBlockService`
 * `Sonata\BlockBundle\Command\SitemapGeneratorCommand`
 * `Sonata\BlockBundle\DependencyInjection\Compiler\BreadcrumbBlockServicesCompilerPass`
 * `Sonata\BlockBundle\DependencyInjection\Compiler\ServiceCompilerPass`
 * `Sonata\BlockBundle\DependencyInjection\Configuration`
 * `Sonata\BlockBundle\DependencyInjection\SonataSeoExtension`
 * `Sonata\BlockBundle\Event\BreadcrumbListener`
 * `Sonata\BlockBundle\Seo\SeoPage`
 * `Sonata\BlockBundle\Sitemap\SourceManager`
 * `Sonata\BlockBundle\Twig\Extension\SeoExtension`

## Removed social blocks

All social media related blocks have been removed.
