UPGRADE 3.x
===========

UPGRADE FROM 3.x to 3.x
=======================

## BaseBreacrumbMenuBlockService changed its constructor

The base class for breadcrumb was broken since the release of 3.0.
It was missing the `EditableBlockService` interface so it can be edited through
`SonataPageBundle` and the best way to implement it was to change the constructor
in order to inject the `MenuBlockService` from the `SonataBlockBundle`.

If you extend `BaseBreacrumbMenuBlockService` you need to change your service definition file.

Before:

```php
    ->set('my_custom_breadcrumb_block_service', MyCustomBreadcrumbBlockService::class)
        ->public()
        ->tag('sonata.block')
        ->tag('sonata.breadcrumb')
        ->args([
            new ReferenceConfigurator('twig'),
            new ReferenceConfigurator('knp_menu.factory'),
        ]);
```

After:

```php
    ->set('my_custom_breadcrumb_block_service', MyCustomBreadcrumbBlockService::class)
        ->public()
        ->tag('sonata.block')
        ->tag('sonata.breadcrumb')
        ->args([
            new ReferenceConfigurator('twig'),
            new ReferenceConfigurator('sonata.block.service.menu'),
            new ReferenceConfigurator('knp_menu.factory'),
        ]);
```
