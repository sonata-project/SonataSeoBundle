Social blocks
=============

You can use social blocks by adding them in your config and you must install Sonata BlockBundle as it is required to
render block services.

.. code-block:: jinja

    # app/config/config.yml
    sonata_block:
        sonata.seo.block.email.share_button:
        sonata.seo.block.facebook.like_box:
        sonata.seo.block.facebook.like_button:
        sonata.seo.block.facebook.send_button:
        sonata.seo.block.facebook.share_button:
        sonata.seo.block.twitter.share_button:
        sonata.seo.block.twitter.follow_button:
        sonata.seo.block.twitter.hashtag_button:
        sonata.seo.block.twitter.mention_button:
        sonata.seo.block.pinterest.pin_button:

These blocks render the correct HTML code to display social widgets but you need to include the related SDK in your main
layout. You can include them by including these templates :

.. code-block:: jinja

    {% include 'SonataSeoBundle:Block:_facebook_sdk.html.twig' %}

    {% include 'SonataSeoBundle:Block:_twitter_sdk.html.twig' %}

    {% include 'SonataSeoBundle:Block:_pinterest_sdk.html.twig' %}

Check the related documentation to get more details :

- Facebook : https://developers.facebook.com/docs/web/
- Twitter : https://dev.twitter.com/docs
- Pinterest : http://business.pinterest.com/widget-builder/
