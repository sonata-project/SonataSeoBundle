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
