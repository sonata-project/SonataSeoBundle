Twig Helpers
============

Here are the Twig helpers you can use in your layout:

Render the page title
^^^^^^^^^^^^^^^^^^^^^

.. code-block:: jinja

    {{ sonata_seo_title() }}

This will render page title as follow: <title>My custom title</title>

Render page metadatas
^^^^^^^^^^^^^^^^^^^^^

.. code-block:: jinja

    {{ sonata_seo_metadatas() }}

This will render page metadatas as follow: <meta name="my-meta-name" content="my-value" />

Render HTML attributes
^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: jinja

    {{ sonata_seo_html_attributes() }}

This will render page HTML attributes as follow: my-attribute="my-value"

Render head attributes
^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: jinja

    {{ sonata_seo_head_attributes() }}

This will render page head attributes as follow: my-attribute="my-value"

Render canonical link
^^^^^^^^^^^^^^^^^^^^^

.. code-block:: jinja

    {{ sonata_seo_link_canonical() }}

This will render page canonical link as follow: <link rel="canonical" href="http://www.example.com/"/>

Render alternates languages
^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: jinja

    {{ sonata_seo_lang_alternates() }}

This will render page alternates languages as follow: <link rel="alternate" href="http://www.example.com/en" hreflang="en"/>
