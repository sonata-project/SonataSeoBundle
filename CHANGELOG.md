# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

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
