Usage
=====

The bundle provides a shared service accessible by the name ``sonata.seo.page``. The service
is an instance of ``SeoPage`` which contains methods to alter SEO information for the current request.

By default, the object is initialized with values defined in the configuration:

.. code-block:: yaml

    sonata_seo:
        page:
            title:            Sonata Project
            metas:
                name:
                    keywords:             foo bar
                    description:          The description
                    robots:               index, follow

                property:
                    'og:site_name':       Sonata Project Sandbox
                    'og:description':     A demo of the some rich bundles for your Symfony2 projects

                http-equiv:
                    'Content-Type':         text/html; charset=utf-8
                    #'X-Ua-Compatible':      IE=EmulateIE7

            head:
                'xmlns':              http://www.w3.org/1999/xhtml
                'xmlns:og':           http://opengraphprotocol.org/schema/


However, it is possible to alter these values at runtime:

.. code-block:: php

    <?php

    $post = $this->getPostManager()->findOneByPermalink($permalink, $this->container->get('sonata.news.blog'));

    $seoPage = $this->container->get('sonata.seo.page');

    $seoPage
        ->setTitle($post->getTitle())
        ->addMeta('name', 'description', $post->getAbstract())
        ->addMeta('property', 'og:title', $post->getTitle())
        ->addMeta('property', 'og:type', 'blog')
        ->addMeta('property', 'og:url',  $this->generateUrl('sonata_news_view', array(
            'permalink'  => $this->getBlog()->getPermalinkGenerator()->generate($post, true)
        ), true))
        ->addMeta('property', 'og:description', $post->getAbstract())
    ;


These values can be used inside a twig template.

.. code-block:: html+jinja

    <!DOCTYPE html>
    <html {{ sonata_seo_html_attributes() }}>
        <head {{ sonata_seo_head_attributes() }}>
            {{ sonata_seo_title() }}
            {{ sonata_seo_metadatas() }}
            {{ sonata_seo_link_canonical() }}
            {{ sonata_seo_lang_alternates() }}
