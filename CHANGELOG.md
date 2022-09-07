# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [3.3.0](https://github.com/sonata-project/SonataSeoBundle/compare/3.2.0...3.3.0) - 2022-09-06
### Fixed
- [[#687](https://github.com/sonata-project/SonataSeoBundle/pull/687)] [BC break] Breadcrumbs now work in the context of SonataPageBundle blocks, broken since 3.0. ([@jordisala1991](https://github.com/jordisala1991))

## [3.2.0](https://github.com/sonata-project/SonataSeoBundle/compare/3.1.0...3.2.0) - 2022-07-28
### Added
- [[#680](https://github.com/sonata-project/SonataSeoBundle/pull/680)] Support for `sonata-project/exporter` ^3 ([@VincentLanglet](https://github.com/VincentLanglet))

## [3.1.0](https://github.com/sonata-project/SonataSeoBundle/compare/3.0.0...3.1.0) - 2022-07-13
### Changed
- [[#673](https://github.com/sonata-project/SonataSeoBundle/pull/673)] Make sitemap generator command lazy. ([@jordisala1991](https://github.com/jordisala1991))

### Removed
- [[#672](https://github.com/sonata-project/SonataSeoBundle/pull/672)] Support of Symfony 5.3 ([@franmomu](https://github.com/franmomu))

## [3.0.0](https://github.com/sonata-project/SonataSeoBundle/compare/3.0.0-RC1...3.0.0) - 2021-11-20
### Fixed
- [[#635](https://github.com/sonata-project/SonataSeoBundle/pull/635)] Fix block service registration ([@core23](https://github.com/core23))
- [[#635](https://github.com/sonata-project/SonataSeoBundle/pull/635)] Fix always loading homepage block ([@core23](https://github.com/core23))

## [3.0.0-RC1](https://github.com/sonata-project/SonataSeoBundle/compare/3.0.0-alpha.1...3.0.0-RC1) - 2021-11-03
### Added
- [[#614](https://github.com/sonata-project/SonataSeoBundle/pull/614)] Symfony 6 support ([@Kocal](https://github.com/Kocal))

### Changed
- [[#624](https://github.com/sonata-project/SonataSeoBundle/pull/624)] `BaseBreadcrumbMenuBlockService::getMenu()` method contains the root menu ([@core23](https://github.com/core23))
- [[#620](https://github.com/sonata-project/SonataSeoBundle/pull/620)] Mark `BaseBreadcrumbMenuBlockService::getRootMenu()` as final ([@core23](https://github.com/core23))

### Fixed
- [[#620](https://github.com/sonata-project/SonataSeoBundle/pull/620)] Fixed breadcrumb rendering ([@core23](https://github.com/core23))

### Removed
- [[#622](https://github.com/sonata-project/SonataSeoBundle/pull/622)] `BaseBreadcrumbMenuBlockService::getContext` method in favor of `BreadcrumbBlockService::handleContext` ([@core23](https://github.com/core23))
- [[#624](https://github.com/sonata-project/SonataSeoBundle/pull/624)] `BaseBreadcrumbMenuBlockService::getRootMenu()` method ([@core23](https://github.com/core23))

## [3.0.0-alpha.1](https://github.com/sonata-project/SonataSeoBundle/compare/2.14.0...3.0.0-alpha.1) - 2021-10-11
### Changed
- [[#585](https://github.com/sonata-project/SonataSeoBundle/pull/585)] Added type hints to every property and method. ([@core23](https://github.com/core23))
- [[#609](https://github.com/sonata-project/SonataSeoBundle/pull/609)] Made `sonata.seo.sitemap.manager` service private ([@core23](https://github.com/core23))
- [[#606](https://github.com/sonata-project/SonataSeoBundle/pull/606)] Changed `SourceManager` implementation ([@core23](https://github.com/core23))

### Removed
- [[#585](https://github.com/sonata-project/SonataSeoBundle/pull/585)] Dropped support for PHP 7.3 ([@core23](https://github.com/core23))
- [[#609](https://github.com/sonata-project/SonataSeoBundle/pull/609)] Removed all `sonata.seo.*.class` parameters from container ([@core23](https://github.com/core23))
- [[#580](https://github.com/sonata-project/SonataSeoBundle/pull/580)] Removed `http` service configuration ([@core23](https://github.com/core23))

## [2.15.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.14.0...2.15.0) - 2021-11-06
### Added
- [[#603](https://github.com/sonata-project/SonataSeoBundle/pull/603)] Add `Sonata\SeoBundle\Block\Breadcrumb\BreadcrumbBlockService` ([@core23](https://github.com/core23))

### Changed
- [[#623](https://github.com/sonata-project/SonataSeoBundle/pull/623)] Add upgrade information to `BaseBreadcrumbMenuBlockService` ([@core23](https://github.com/core23))

### Deprecated
- [[#603](https://github.com/sonata-project/SonataSeoBundle/pull/603)] Deprecate `Sonata\SeoBundle\BreadcrumbInterface` ([@core23](https://github.com/core23))

## [2.14.0](https://github.com/sonata-project/SonataSeoBundle/compare/2.13.1...2.14.0) - 2021-09-26
### Added
- [[#596](https://github.com/sonata-project/SonataSeoBundle/pull/596)] Added `priority` to `sonata.breadcrumb` tag ([@core23](https://github.com/core23))
- [[#588](https://github.com/sonata-project/SonataSeoBundle/pull/588)] Added `SeoPageInterface::setBreadcrumb` ([@core23](https://github.com/core23))
- [[#588](https://github.com/sonata-project/SonataSeoBundle/pull/588)] Added `SeoPageInterface::getBreadcrumbOptions` ([@core23](https://github.com/core23))
- [[#588](https://github.com/sonata-project/SonataSeoBundle/pull/588)] Added `sonata_seo_breadcrumb` twig extension to render current breadcrumb ([@core23](https://github.com/core23))
- [[#597](https://github.com/sonata-project/SonataSeoBundle/pull/597)] Allow setting global page prefix and suffix ([@core23](https://github.com/core23))
- [[#586](https://github.com/sonata-project/SonataSeoBundle/pull/586)] Added `SeoPageInterface::addTitlePrefix` ([@core23](https://github.com/core23))
- [[#586](https://github.com/sonata-project/SonataSeoBundle/pull/586)] Added `SeoPageInterface::addTitleSuffix` ([@core23](https://github.com/core23))
- [[#586](https://github.com/sonata-project/SonataSeoBundle/pull/586)] Added `SeoPageInterface::getOriginalTitle` ([@core23](https://github.com/core23))
- [[#586](https://github.com/sonata-project/SonataSeoBundle/pull/586)] Added `sonata_seo_title_text` twig function ([@core23](https://github.com/core23))

### Changed
- [[#572](https://github.com/sonata-project/SonataSeoBundle/pull/572)] Mark all* components as final by default ([@core23](https://github.com/core23))

### Deprecated
- [[#586](https://github.com/sonata-project/SonataSeoBundle/pull/586)] Deprecated `SeoPageInterface::addTitle` ([@core23](https://github.com/core23))
- [[#572](https://github.com/sonata-project/SonataSeoBundle/pull/572)] Deprecated all social blocks ([@core23](https://github.com/core23))

## [2.13.1](https://github.com/sonata-project/SonataSeoBundle/compare/2.13.0...2.13.1) - 2021-06-13
### Fixed
- [[#542](https://github.com/sonata-project/SonataSeoBundle/pull/542)] Added missing sonata-project/block-bundle dependency ([@patrickmaynard](https://github.com/patrickmaynard))

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
