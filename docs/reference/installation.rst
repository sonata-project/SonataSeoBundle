Installation
============

To begin, require the bundle via Composer::

    composer require sonata-project/seo-bundle

Now, add the new `SeoBundle` Bundle to ``bundles.php`` file:

.. code-block:: php

    <?php

    // config/bundles.php

    return [
        //...
        Sonata\SeoBundle\SonataSeoBundle::class => ['all' => true],
    ];

.. note::
    If you are not using Symfony Flex, you should enable bundles in your
    ``AppKernel.php``.


.. code-block:: php

    <?php

    // app/AppKernel.php

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

    # config/packages/sonata.yaml
    sonata_seo:
        encoding:         UTF-8
        page:
            title:            Sonata Project
            default:          sonata.seo.page.default
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

.. note::
    If you are not using Symfony Flex, this configuration should be added
    to ``app/config/config.yml``.
