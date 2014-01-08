Breadcrumb
==========

The ``SonataSeoBundle`` let you create your own breadcrumbs based on your different website modules (news, products catalog...).

Create your own breadcrumb
--------------------------

First, you need to create the breadcrumb, create a KnpMenu builder which extends ``Sonata\SeoBundle\Menu\BaseBreadcrumbMenuBuilder`` and implements ``Sonata\SeoBundle\Menu\BreadcrumbMenuBuilderInterface`` :

.. code-block:: php

    <?php

    namespace Acme\Bundle\Menu;

    use Sonata\SeoBundle\Menu\BaseBreadcrumbMenuBuilder;
    use Sonata\SeoBundle\Menu\BreadcrumbMenuBuilderInterface;

    class MyCustomBreadcrumbMenuBuilder extends BaseBreadcrumbMenuBuilder implements BreadcrumbMenuBuilderInterface
    {
        public function getBreadcrumbMenu($parameters = array())
        {
            $menu = $this->getRootMenu();

            // generate your breadcrumb based on your needs
            // $menu->addChild( /* ... */ );

            return $menu;
        }
    }

.. code-block:: xml

    <service id="acme.bundle.menu.catalog_breadcrumb_menu_builder" class="Acme\Bundle\Menu\MyCustomBreadcrumbMenuBuilder">
        <argument type="service" id="knp_menu.factory" />
        <argument type="service" id="translator" />
    </service>

Then create the related BlockService to handle your breadcrumb. You need to extends ``Sonata\SeoBundle\Block\BaseBreadcrumbMenuBlockService`` :

.. code-block:: php

    <?php

    namespace Acme\Bundle\Block;

    use Sonata\SeoBundle\Block\BaseBreadcrumbMenuBlockService;

    class MyCustomBreadcrumbBlockService extends BaseBreadcrumbMenuBlockService
    {
        /**
         * {@inheritdoc}
         */
        public function getName()
        {
            return 'acme.bundle.block.breadcrumb';
        }

        /**
         * {@inheritdoc}
         */
        protected function getMenu()
        {
            $parameters = array(
                // you can set parameters to the menu here
            );

            return $this->menuBuilder->getBreadcrumbMenu($parameters);
        }
    }

.. code-block:: xml

    <service id="acme.bundle.block.breadcrumb" class="Acme\Bundle\Block\MyCustomBreadcrumbBlockService">
        <tag name="sonata.block"/>
        <tag name="sonata.breadcrumb"/>

        <argument>my_custom_breadcrumb</argument>
        <argument>acme.bundle.block.breadcrumb</argument>
        <argument type="service" id="templating" />
        <argument type="service" id="knp_menu.menu_provider" />
        <argument type="service" id="acme.bundle.menu.catalog_breadcrumb_menu_builder" />
    </service>

And to render the breadcrumb, just use this Twig helper :

.. code-block:: jinja

    {{ sonata_block_render_event('breadcrumb', { 'context': 'my_custom_breadcrumb', 'current_uri': app.request.requestUri }) }}
