<?php

namespace Sonata\SeoBundle\Seo;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
interface StructuredDataAwarePage
{
    /**
     * Set the structured data as an JSON-LD string.
     *
     * @param string $structuredData
     *
     * @return SeoPageInterface
     */
    public function setStructuredData($structuredData);

    /**
     * Returns a JSON-LD string to serve i.e. as a google snippet definition.
     *
     * @return string
     */
    public function getStructuredData();
}
