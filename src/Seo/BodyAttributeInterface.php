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

namespace Sonata\SeoBundle\Seo;

interface BodyAttributeInterface
{
    public function setBodyAttributes(array $attributes): self;

    public function addBodyAttribute(string $name, string $value): self;

    public function removeBodyAttribute(string $name): self;

    public function getBodyAttributes(): array;

    public function hasBodyAttribute(string $name): bool;
}
