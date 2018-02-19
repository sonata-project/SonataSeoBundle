<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Twig\Extension;

use Sonata\SeoBundle\Seo\StructuredDataAwarePage;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class StructuredDataExtension extends AbstractExtension
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
            new TwigFunction('sonata_seo_structured_data', [$this, 'getStructuredData'], ['is_safe' => ['html']]),
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
