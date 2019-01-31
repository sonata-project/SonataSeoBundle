<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Twig\Extension;

use Sonata\SeoBundle\Seo\AttributeBag;
use Sonata\SeoBundle\Seo\SeoPageAttributesInterface;
use Sonata\SeoBundle\Seo\SeoPageInterface;

class SeoExtension extends \Twig_Extension
{
    /**
     * @var SeoPageInterface
     */
    protected $page;

    /**
     * @var string
     */
    protected $encoding;

    /**
     * @param SeoPageInterface|SeoPageAttributesInterface $page
     * @param string                                      $encoding
     */
    public function __construct(SeoPageInterface $page, $encoding)
    {
        $this->page = $page;
        $this->encoding = $encoding;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('sonata_seo_title', [$this, 'getTitle'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('sonata_seo_metadatas', [$this, 'getMetadatas'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('sonata_seo_link_canonical', [$this, 'getLinkCanonical'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('sonata_seo_lang_alternates', [$this, 'getLangAlternates'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('sonata_seo_oembed_links', [$this, 'getOembedLinks'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('sonata_seo_html_attributes', [$this, 'getHtmlAttributes'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new \Twig_SimpleFunction('sonata_seo_head_attributes', [$this, 'getHeadAttributes'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new \Twig_SimpleFunction('sonata_seo_body_attributes', [$this, 'getBodyAttributes'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_seo';
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderTitle()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getTitle() instead.',
            E_USER_DEPRECATED
        );

        echo $this->getTitle();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return sprintf('<title>%s</title>', strip_tags($this->page->getTitle()));
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderMetadatas()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getMetadatas() instead.',
            E_USER_DEPRECATED
        );

        echo $this->getMetadatas();
    }

    /**
     * @return string
     */
    public function getMetadatas()
    {
        $html = '';
        foreach ($this->page->getMetas() as $type => $metas) {
            foreach ((array) $metas as $name => $meta) {
                list($content, $extras) = $meta;

                if (!empty($content)) {
                    $html .= sprintf("<meta %s=\"%s\" content=\"%s\" />\n",
                        $type,
                        $this->normalize($name),
                        $this->normalize($content)
                    );
                } else {
                    $html .= sprintf("<meta %s=\"%s\" />\n",
                        $type,
                        $this->normalize($name)
                    );
                }
            }
        }

        return $html;
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderHtmlAttributes()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getHtmlAttributes() instead.',
            E_USER_DEPRECATED
        );

        echo $this->getHtmlAttributes();
    }

    public function getHtmlAttributes(\Twig_Environment $environment = null): string
    {
        if ($this->page instanceof SeoPageAttributesInterface) {
            $attributes = $this->page->htmlAttributes();
        } else {
            $attributes = new AttributeBag($this->page->getHtmlAttributes());
        }

        return $this->renderAttributes($attributes, $environment);
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderHeadAttributes()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getHeadAttributes() instead.',
            E_USER_DEPRECATED
        );

        echo $this->getHeadAttributes();
    }

    public function getHeadAttributes(\Twig_Environment $environment = null): string
    {
        if ($this->page instanceof SeoPageAttributesInterface) {
            $attributes = $this->page->headAttributes();
        } else {
            $attributes = new AttributeBag($this->page->getHeadAttributes());
        }

        return $this->renderAttributes($attributes, $environment);
    }

    public function getBodyAttributes(\Twig_Environment $environment): string
    {
        return $this->renderAttributes($this->page->bodyAttributes(), $environment);
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderLinkCanonical()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getLinkCanonical() instead.',
            E_USER_DEPRECATED
        );

        echo $this->getLinkCanonical();
    }

    /**
     * @return string
     */
    public function getLinkCanonical()
    {
        if ($this->page->getLinkCanonical()) {
            return sprintf("<link rel=\"canonical\" href=\"%s\"/>\n", $this->page->getLinkCanonical());
        }
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since 2.0, to be removed in 3.0
     */
    public function renderLangAlternates()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.0, to be removed in 3.0. '.
            'Use '.__NAMESPACE__.'::getLangAlternates() instead.',
            E_USER_DEPRECATED
        );

        echo $this->getLangAlternates();
    }

    /**
     * @return string
     */
    public function getLangAlternates()
    {
        $html = '';
        foreach ($this->page->getLangAlternates() as $href => $hrefLang) {
            $html .= sprintf("<link rel=\"alternate\" href=\"%s\" hreflang=\"%s\"/>\n", $href, $hrefLang);
        }

        return $html;
    }

    /**
     * @return string
     */
    public function getOembedLinks()
    {
        $html = '';
        foreach ($this->page->getOEmbedLinks() as $title => $link) {
            $html .= sprintf("<link rel=\"alternate\" type=\"application/json+oembed\" href=\"%s\" title=\"%s\" />\n", $link, $title);
        }

        return $html;
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    private function normalize($string)
    {
        return htmlentities(strip_tags($string), ENT_COMPAT, $this->encoding);
    }

    private function renderAttributes(AttributeBag $attributes, \Twig_Environment $environment = null): string
    {
        if (null === $environment) {
            return '';
        }

        try {
            return trim($environment->render('@SonataSeo/attributes.html.twig', ['attr' => $attributes]));
        } catch (\Twig_Error $exception) {
            return '';
        }
    }
}
