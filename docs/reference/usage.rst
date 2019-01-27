Usage
=====

The bundle provides a shared service accessible by the name ``sonata.seo.page``. The service
is an instance of ``SeoPageInterface`` which contains methods to alter SEO information for the current request.

By default, the object is initialized with values defined in the configuration:

.. code-block:: yaml

    # config/packages/sonata_seo.yaml

    sonata_seo:
        encoding: 'UTF-8'
        page:
            default:   'sonata.seo.page.default'
            separator: ' - '
            title:     'Project name'

However, it is possible to alter these values at runtime::

    $post = $this->getPostManager()->findOneByPermalink($permalink, $this->container->get('sonata.news.blog'));

    $seoPage = $this->container->get('sonata.seo.page');

    $seoPage
        ->setTitle($post->getTitle())
        ->addMeta('name', 'description', $post->getAbstract())
        ->addMeta('property', 'og:title', $post->getTitle())
        ->addMeta('property', 'og:type', 'blog')
        ->addMeta('property', 'og:url',  $this->generateUrl('sonata_news_view', [
            'permalink' => $this->getBlog()->getPermalinkGenerator()->generate($post, true)
        ], true))
        ->addMeta('property', 'og:description', $post->getAbstract())
    ;

.. note::

    If you need a shortcut to inject the seo page into any class, you could use the
    ``Sonata\SeoBundle\Seo\SeoAwareTrait``.

Prefix or suffix the page title
-------------------------------

If you want to change the suffix of your page titles, you can either do this by altering the ``title`` directly or use the ``title.suffix``.

.. code-block:: yaml

    # config/packages/sonata_seo.yaml

    sonata_seo:
        page:
            title: 'My Suffix'

    // or

    sonata_seo:
        page:
            title:
                suffix: 'My Suffix'

You can also add a prefix to your page titles, then you must configure ``title.prefix``. A combination of both prefix and suffix is also possible!

.. code-block:: yaml

    # config/packages/sonata_seo.yaml

    sonata_seo:
        page:
            title:
                prefix: 'My Prefix'
                suffix: 'My Suffix'

You can also edit the pre- or suffix at runtime, however this is uncommon::

    $seoPage = $this->container->get('sonata.seo.page');

    $seoPage
        ->setTitlePrefix('My Prefix')
        ->setTitleSuffix('My Suffix')
    ;

.. note::

    Only want to use the prefix? Disable the suffix by setting it to ``null`` (use ``suffix: ~`` in yaml)

Set or prepend the page title
-----------------------------

You can set the page title::

    $seoPage = $this->container->get('sonata.seo.page');

    $seoPage
        ->setTitle($post->getTitle());

You can also prepend the page title::

    $seoPage = $this->container->get('sonata.seo.page');

    $seoPage
        ->addTitle($post->getTitle());

If you prepend the page title to an already existing page title, the configured separator is used to split them.

.. note::
    ``setTitle`` and ``addTitle`` does not conflict with the pre- or suffix, the title stays between the prefix and suffix.


Twig template example
---------------------

These values can be used inside a twig template.

.. code-block:: html+jinja

    <!DOCTYPE html>
    <html {{ sonata_seo_html_attributes() }}>
        <head {{ sonata_seo_head_attributes() }}>
            {{ sonata_seo_title() }}
            {{ sonata_seo_metadatas() }}
            {{ sonata_seo_link_canonical() }}
            {{ sonata_seo_lang_alternates() }}
            ...
        </head>
        <body>
            ...
        </body>
    </html>
