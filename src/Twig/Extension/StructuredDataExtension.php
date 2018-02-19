<?php

namespace Sonata\SeoBundle\Twig\Extension;

use Sonata\SeoBundle\Seo\StructuredDataAwarePage;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class StructuredDataExtension extends \Twig_Extension
{
    /**
     * @var StructuredDataAwarePage
     */
    protected $page;

    /**
     * @var string
     */
    protected $encoding;

    /**
     * @param StructuredDataAwarePage $page
     */
    public function __construct(StructuredDataAwarePage $page)
    {
        $this->page = $page;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('sonata_seo_structured_data', [$this, 'getStructuredData'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Creates a script tag with type 'json-ld' and the JSON-LD string stored in page object.
     *
     * @return string
     */
    public function getStructuredData()
    {
        if (empty($this->page->getStructuredData())) {
            return '';
        }

        return sprintf("<script type=\"application/ld+json\">%s</script>\n", $this->page->getStructuredData());
    }
}
