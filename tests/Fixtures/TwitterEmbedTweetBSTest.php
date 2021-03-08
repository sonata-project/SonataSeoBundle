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

namespace Sonata\SeoBundle\Tests\Fixtures\Block;

use Sonata\SeoBundle\Block\Social\TwitterEmbedTweetBlockService;

final class TwitterEmbedTweetBSTest extends TwitterEmbedTweetBlockService
{
    public function publicBuildUri($uriMatched, array $settings)
    {
        return $this->buildUri($uriMatched, $settings);
    }
}
