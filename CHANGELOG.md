# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [2.13.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.12.0...2.13.0) - 2021-02-22
### Added
- [[#507](https://github.com/sonata-project/SonataSeoBundle/pull/507)] Add support for PHP 8.x ([@Yozhef](https://github.com/Yozhef))
- [[#511](https://github.com/sonata-project/SonataSeoBundle/pull/511)] Added generic information to `SeoPageInterface` ([@core23](https://github.com/core23))

### Changed
- [[#459](https://github.com/sonata-project/SonataSeoBundle/pull/459)] Updated Dutch translations ([@zghosts](https://github.com/zghosts))
- [[#511](https://github.com/sonata-project/SonataSeoBundle/pull/511)] Soft move methods to `SeoPageInterface` using @method ([@core23](https://github.com/core23))

## [2.12.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.11.0...2.12.0) - 2020-09-07
### Added
- [[#398](https://github.com/sonata-project/SonataSeoBundle/pull/398)] Added
  new `BreadcrumbInterface` ([@core23](https://github.com/core23))

### Fixed
- [[#426](https://github.com/sonata-project/SonataSeoBundle/pull/426)] Fix
  parameter type when calling knp menu
([@DamienDeSousa](https://github.com/DamienDeSousa))

### Removed
- [[#416](https://github.com/sonata-project/SonataSeoBundle/pull/416)] Support
  for `sonata-project/exporter` < 2.0
([@jordisala1991](https://github.com/jordisala1991))
- [[#405](https://github.com/sonata-project/SonataSeoBundle/pull/405)] Support
  for PHP < 7.2 ([@wbloszyk](https://github.com/wbloszyk))

## [2.11.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.10.0...2.11.0) - 2020-06-26
### Changed
- [[#370](https://github.com/sonata-project/SonataSeoBundle/pull/370)] Bump SF
  to 4.4 ([@bmaziere](https://github.com/bmaziere))

### Removed
- [[#394](https://github.com/sonata-project/SonataSeoBundle/pull/394)] Remove
  SonataCoreBundle dependencies ([@wbloszyk](https://github.com/wbloszyk))

## [2.10.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.9.0...2.10.0) - 2020-01-12
### Added
- Added support for `psr/http-client` in `TwitterEmbedTweetBlockService`

### Fixed
- Compatibility of the sitemap generator command with Symfony 5

## [2.9.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.8.0...2.9.0) - 2019-11-29
### Added
- Support for Twig 3 and Symfony 5

## [2.8.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.7.0...2.8.0) - 2019-10-28
### Fixed
- cast metadata to string during render
- deprecation notice about using namespaced classes from `\Twig\`
- Fixed deprecation notice:
  "Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand" class is deprecated
- Fixed use of deprecated `spaceless` Twig tag

### Deprecated
- passing a non-string value when adding meta content
- If you extend `SitemapGeneratorCommand`, avoid usage of the container in the
  child command declarations.

## [2.7.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.6.2...2.7.0) - 2019-01-23
### Added
- Added `SeoPageInterface` as alias service of `sonata.seo.page` for Dependency Injection usages.
- Added support for latest exporter

### Fixed
- Fix deprecation for symfony/config 4.2+

### Removed
- support for php 5 and php 7.0

## [2.6.2](https://github.com/sonata-project/SonataSeoBundle/compare/2.6.1...2.6.2) - 2018-11-04

### Fixed
- Allow overriding default seo service

## [2.6.1](https://github.com/sonata-project/SonataSeoBundle/compare/2.6.0...2.6.1) - 2018-10-09
### Fixed
- Initialized `SeoPage::$htmlAttributes` with empty array

## [2.6.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.5.1...2.6.0) - 2018-08-27
### Added
- Added `SeoAwareTrait`

### Fixed
- Make `sonata.seo.page` alias public

## [2.5.1](https://github.com/sonata-project/SonataSeoBundle/compare/2.5.0...2.5.1) - 2018-02-23
### Changed
- Switch all templates references to Twig namespaced syntax
- Switch from templating service to sonata.templating

### Fixed
- Register `Sonata\SeoBundle\Command\SitemapGeneratorCommand` via `console.command` tag

## [2.5.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.4.0...2.5.0) - 2018-01-07
### Fixed
- It is now allowed to install Symfony 4

### Changed
- make services explicit public
- Changed default title to `Project name`

## [2.4.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.3.0...2.4.0) - 2017-11-30
### Added
- Russian translations

### Changed
- do not use deprecated array for block menu service

### Removed
- Removed BC layer for old symfony versions
- Support for `^3.0` and `^3.1` versions of `framework-bundle` and `options-resolver`.

## [2.3.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.2.1...2.3.0) - 2017-10-22
### Changed
- moved `sonata-project/block-bundle` back to require-dev

### Removed
- Support for old versions of PHP and Symfony.

## [2.2.1](https://github.com/sonata-project/SonataSeoBundle/compare/2.2.0...2.2.1) - 2017-10-22
### Fixed
- Pass the right option for showing form help in twitter embedded block

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
