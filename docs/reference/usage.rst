Usage
=====

The bundle provides a shared service accessible by the name ``sonata.seo.page``. The service
is an instance of ``SeoPage`` which contains methods to alter SEO information for the current request.

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
        ->setBreadcrumb('news_post', [
            'post' => $post,
        ])
    ;

You could also prepend the page title, so that the global title is used as a suffix::

    $seoPage = $this->container->get('sonata.seo.page');

    $seoPage
        ->addTitlePrefix($post->getTitle());

.. note::

    If you need a shortcut to inject the seo page into any class, you could use the
    ``Sonata\SeoBundle\Seo\SeoAwareTrait``.

These values can be used inside a twig template.

.. code-block:: html+twig

    <!DOCTYPE html>
    <html {{ sonata_seo_html_attributes() }}>
        <head {{ sonata_seo_head_attributes() }}>
            {{ sonata_seo_title() }}
            {{ sonata_seo_metadatas() }}
            {{ sonata_seo_link_canonical() }}
            {{ sonata_seo_lang_alternates() }}
