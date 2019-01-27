Usage
=====

By default, the object is initialized with values defined in the configuration:

.. code-block:: yaml

    # config/packages/sonata_seo.yaml

    sonata_seo:
        encoding: 'UTF-8'
        page:
            default:   'sonata.seo.page.default'
            separator: ' - '
            title:     'Project name'

Alter values in runtime
-----------------------

You can alter the SEO information at runtime by injecting the ``SeoPageInterface``
into your classes. The bundle wil automatically use the configured service
defined in ``sonata_seo.page.default``.

.. code-block:: php

    // src/Controller/PostController.php
    namespace App\Controller;

    use Sonata\SeoBundle\Seo\SeoPageInterface;

    final class PostController
    {
        private $seoPage;

        public function __construct(SeoPageInterface $seoPage)
        {
            $this->seoPage = $seoPage;
        }

        public function index(): Response
        {
            // retrieve a post from the database
            $post = ...;
            $this->seoPage
                ->setTitle($post->getTitle())
                ->addMeta('name', 'description', $post->getAbstract())
                ->addMeta('property', 'og:title', $post->getTitle())
                ->addMeta('property', 'og:type', 'blog')
                ->addMeta('property', 'og:url',  $this->generateUrl('sonata_news_view', [
                    'permalink' => $this->getBlog()->getPermalinkGenerator()->generate($post, true)
                ], true))
                ->addMeta('property', 'og:description', $post->getAbstract())
            ;
        }
    }

.. warning::

    The bundle also provides the same public service accessible by the name
    ``sonata.seo.page``.
    However, we recommend using dependency injection instead.


Prefix or suffix the page title
-------------------------------

If you want to change the suffix of your page titles, you can either do
this by altering the ``title`` directly or use the ``title.suffix``.

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

You can also add a prefix to your page titles, you must configure ``title.prefix``.
A combination of both prefix and suffix is also possible!

.. code-block:: yaml

    # config/packages/sonata_seo.yaml

    sonata_seo:
        page:
            title:
                prefix: 'My Prefix'
                suffix: 'My Suffix'

You can also edit the prefix or suffix at runtime, however this is uncommon::

    // ...
    public function index()
    {
        // ...
        $this->seoPage
            ->setTitlePrefix('My Prefix')
            ->setTitleSuffix('My Suffix')
        ;
        // ...
    }
    // ...

.. note::

    Only want to use the prefix?
    Disable the suffix by setting it to ``null`` (use ``suffix: ~`` in yaml)

Set or prepend the page title
-----------------------------

You can set the page title::

    // ...
    public function index()
    {
        // ...
        $this->seoPage
            ->setTitle($post->getTitle())
        ;
        // ...
    }
    // ...

You can also prepend the page title::

    // ...
    public function index()
    {
        // ...
        $this->seoPage
            ->addTitle($post->getTitle())
        ;
        // ...
    }
    // ...

If you prepend the page title to an already existing page title, the configured
separator is used to split them.

.. note::
    ``setTitle`` and ``addTitle`` does not conflict with the prefix or suffix.


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
