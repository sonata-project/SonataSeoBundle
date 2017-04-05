UPGRADE 2.x
===========

UPGRADE FROM 2.0 to 2.1
=======================

### Deprecated methods in `Sonata\SeoBundle\Twig\Extension`

| deprecated method | recommended method |
|-------------------------|-----------------------------|
| `renderTitle()` | `getTitle()` |
| `renderMetadatas()` | `getMetadatas()` |
| `renderHtmlAttributes()` | `getHtmlAttributes()` |
| `renderHeadAttributes()` | `getHeadAttributes()` |
| `renderLinkCanonical()` | `getLinkCanonical()` |
| `renderLangAlternates()` | `getLangAlternates()` |

### Tests

All files under the ``Tests`` directory are now correctly handled as internal test classes. 
You can't extend them anymore, because they are only loaded when running internal tests. 
More information can be found in the [composer docs](https://getcomposer.org/doc/04-schema.md#autoload-dev).
