Breadcrumb
==========

The ``SonataSeoBundle`` let's you create your own breadcrumbs based on your different website modules (news, products catalog...). The bundle uses KnpMenuBundle to generate the breadcrumb. Please refer to related documentation.

Create your own breadcrumb
--------------------------

First, you need to create a BlockService to handle your breadcrumbs.
You can extend ``Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService``::

    namespace App\Block;

    use Sonata\BlockBundle\Block\BlockContextInterface;
    use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;

    class MyCustomBreadcrumbBlockService extends BaseBreadcrumbMenuBlockService
    {
        public function getName()
        {
            return 'app.block.breadcrumb';
        }

        protected function getMenu(BlockContextInterface $blockContext)
        {
            $menu = $this->getRootMenu($blockContext);

            $menu->addChild('my_awesome_action');

            return $menu;
        }
    }

.. code-block:: xml

    <!-- config/services.xml -->

    <service id="app.bundle.block.breadcrumb" class="App\Block\MyCustomBreadcrumbBlockService">
        <argument>my_custom_context</argument>
        <argument>acme.bundle.block.breadcrumb</argument>
        <argument type="service" id="templating"/>
        <argument type="service" id="knp_menu.menu_provider"/>
        <argument type="service" id="knp_menu.factory"/>
        <tag name="sonata.block"/>
        <tag name="sonata.breadcrumb"/>
    </service>

You can also override the breadcrumb order by defining a ``priority``:

.. code-block:: xml

    <!-- config/services.xml -->

    <service id="app.bundle.block.breadcrumb" class="App\Block\MyCustomBreadcrumbBlockService">
        <argument>my_custom_context</argument>
        <argument>acme.bundle.block.breadcrumb</argument>
        <argument type="service" id="templating"/>
        <argument type="service" id="knp_menu.menu_provider"/>
        <argument type="service" id="knp_menu.factory"/>
        <tag name="sonata.block"/>
        <tag name="sonata.breadcrumb" priority="-127"/>
    </service>

And to render the breadcrumb, just use this Twig helper :

.. code-block:: twig

    {{ sonata_block_render_event('breadcrumb', {
        'context': 'my_custom_context',
        'current_uri': app.request.requestUri
    }) }}


You can also use the shortcut to render the current breadcrumb :

.. code-block:: twig

    {{ sonata_seo_breadcrumb() }}
