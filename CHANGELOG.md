CHANGELOG
=========

A [BC BREAK] means the update will break the project for many reasons:

* new mandatory configuration
* new dependencies
* class refactoring

### 2014-11-06

* sitemap command now gets a new argument ``sitemap_path`` which overrides ``base_url`` when it comes to appending to generate sitemap URLs in the index file.

### 2012-12-13

* [BC BREAK] informations used for the SeoPage are now under a new section 'page', please review the
  installation.rst file.
