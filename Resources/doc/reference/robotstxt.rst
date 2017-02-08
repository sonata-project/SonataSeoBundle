Robots.txt
=======

The ``SonataSeoBundle`` provides a support for static robots.txt generation.

Configuration example
---------------------

.. code-block:: yaml

    sonata_seo:
        robotstxt:
            -
                user-agent:
                    - "*"
                crawl-delay: 10
                access-control:
                    - disallow: /admin
                    - disallow: /sonatadmin
                    - allow: /api/doc
                    - disallow: /api
                sitemap:
                    - https://www.example.com/sitemap_index.xml
                host: www.example.com
            -
                user-agent: [BadRobot, GoogleBot]
                access-control:
                    - disallow: /private

For more information on robots.txt:

* [Robots exclusion standard](https://en.wikipedia.org/wiki/Robots_exclusion_standard)
* [norobots-rfc](http://www.robotstxt.org/norobots-rfc.txt)

Usage
-----

- Generate the sitemap::

    php app/console sonata:seo:robotstxt web
