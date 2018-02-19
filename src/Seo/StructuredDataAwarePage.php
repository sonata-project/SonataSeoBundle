<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
