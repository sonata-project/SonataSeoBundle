# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [2.2.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.1.0...2.2.0) - 2017-06-14
### Changed
- Allow Twig ^2.0

### Fixed
- Deprecated usage of `Sonata\BlockBundle\Block\BaseBlockService`
- use `same as` instead of deprecated `sameas` `breadcrumb.html.twig`

## [2.1.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.0.2...2.1.0) - 2017-02-02
### Added
- Added support for `safe_label` in breadcrumb
- Added support for `false` translation in breadcrumb

### Changed
- Moved public methods from `SeoPage` to `SeoPageInterface`

### Deprecated
- `Sonata\SeoBundle\Twig\Extension::renderTitle()` in favor of `Sonata\SeoBundle\Twig\Extension::getTitle()`
- `Sonata\SeoBundle\Twig\Extension::renderMetadatas()` in favor of `Sonata\SeoBundle\Twig\Extension::getMetadatas()`
- `Sonata\SeoBundle\Twig\Extension::renderHtmlAttributes()` in favor of `Sonata\SeoBundle\Twig\Extension::getHtmlAttributes()`
- `Sonata\SeoBundle\Twig\Extension::renderHeadAttributes()` in favor of `Sonata\SeoBundle\Twig\Extension::getHeadAttributes()`
- `Sonata\SeoBundle\Twig\Extension::renderLinkCanonical()` in favor of `Sonata\SeoBundle\Twig\Extension::getLinkCanonical()`
- `Sonata\SeoBundle\Twig\Extension::renderLangAlternates()` in favor of `Sonata\SeoBundle\Twig\Extension::getLangAlternates()`

### Removed
- internal test classes are now excluded from the autoloader
