Installation
============

To begin, add the dependent bundles to the vendor/bundles directory. Add the following lines to the file deps::

    [SonataSeoBundle]
        git=http://github.com/sonata-project/SonataSeoBundle.git
        target=/bundles/Sonata/SeoBundle


Now, add the new `SeoBundle` Bundle to the kernel

.. code-block:: php

    <?php
    public function registerbundles()
    {
        return array(
            new Sonata\SeoBundle\SonataSeoBundle(),
        );
    }

Update the ``autoload.php`` to add new namespaces:

.. code-block:: php

    <?php
    $loader->registerNamespaces(array(
        'Sonata'                             => __DIR__,

        // ... other declarations
    ));


Configuration
-------------

To use the ``SeoBundle``, add the following lines to your application configuration
file.

.. code-block:: yaml

    # app/config/config.yml
    sonata_seo:
        default:          sonata.seo.page.default
        title:            Sonata Project
        metadatas:
            keywords:     keywords ...
            description:  description
            robots:       index, follow