Breadcrumb
==========

The ``SonataSeoBundle`` let's you create your own breadcrumbs based on your different website modules (news, products catalog...). The bundle uses KnpMenuBundle to generate the breadcrumb. Please refer to related documentation.

Create your own breadcrumb
--------------------------

First, you need to create a BlockService to handle your breadcrumbs. You can extend ``Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService`` :

.. code-block:: php

    <?php

    namespace App\Block;

    use Sonata\BlockBundle\Block\BlockContextInterface;
    use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;

    class MyCustomBreadcrumbBlockService extends BaseBreadcrumbMenuBlockService
    {
        /**
         * {@inheritdoc}
         */
        public function getName()
        {
            return 'app.block.breadcrumb';
        }

        /**
         * {@inheritdoc}
         */
        protected function getMenu(BlockContextInterface $blockContext)
        {
            $menu = $this->getRootMenu($blockContext);

            $menu->addChild('my_awesome_action');

            return $menu;
        }
    }

.. code-block:: xml

    <service id="acme.bundle.block.breadcrumb" class="Acme\Bundle\Block\MyCustomBreadcrumbBlockService">
        <tag name="sonata.block"/>
        <tag name="sonata.breadcrumb" context="my_custom_context" />
        <argument>acme.bundle.block.breadcrumb</argument>
        <argument type="service" id="templating" />
        <argument type="service" id="knp_menu.menu_provider" />
        <argument type="service" id="knp_menu.factory" />
    </service>

And to render the breadcrumb, just use this Twig helper :

.. code-block:: jinja

    {{ sonata_block_render_event('breadcrumb', { 'context': 'my_custom_context', 'current_uri': app.request.requestUri }) }}
