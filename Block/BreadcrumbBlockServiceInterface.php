<?php

namespace Sonata\SeoBundle\Block;

/**
 * Interface BreadcrumbBlockServiceInterface.
 *
 * @package Sonata\SeoBundle\Block
 * @author  Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
interface BreadcrumbBlockServiceInterface
{
    /**
     * Return true if current BlockService handles the given context.
     *
     * @param string $context
     *
     * @return boolean
     */
    public function handleContext($context);
}
