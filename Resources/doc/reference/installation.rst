Installation
============

To begin, require the bundle via Composer::

    php composer.phar require sonata-project/seo-bundle

Now, add the new `SeoBundle` Bundle to the kernel

.. code-block:: php

    <?php
    public function registerbundles()
    {
        return array(
            new Sonata\SeoBundle\SonataSeoBundle(),
        );
    }

Configuration
-------------

To use the ``SeoBundle``, add the following lines to your application configuration
file.

.. code-block:: yaml

    # app/config/config.yml
    sonata_seo:
        default:          sonata.seo.page.default
        encoding:         UTF-8
        page:
            title:            Sonata Project
            metas:
                name:
                    keywords:             foo bar
                    description:          The description
                    robots:               index, follow

                property:
                    # Facebook application settings
                    #'fb:app_id':          XXXXXX
                    #'fb:admins':          admin1, admin2

                    # Open Graph information
                    # see http://developers.facebook.com/docs/opengraphprotocol/#types or http://ogp.me/
                    'og:site_name':       Sonata Project Sandbox
                    'og:description':     A demo of the some rich bundles for your Symfony2 projects

                http-equiv:
                    'Content-Type':         text/html; charset=utf-8
                    #'X-Ua-Compatible':      IE=EmulateIE7

                charset:
                    UTF-8:    ''

            head:
                'xmlns':              http://www.w3.org/1999/xhtml
                'xmlns:og':           http://opengraphprotocol.org/schema/
                #'xmlns:fb':           "http://www.facebook.com/2008/fbml"

