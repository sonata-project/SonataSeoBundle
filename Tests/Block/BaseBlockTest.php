<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\Block;

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseBlockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Checks if Sonata BlockBundle is present. If not, skip the current test.
     */
    protected function checkBlockBundle()
    {
        return class_exists('Sonata\BlockBundle\SonataBlockBundle');
    }
}
