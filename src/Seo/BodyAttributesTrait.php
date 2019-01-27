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

trait BodyAttributesTrait
{
    private $bodyAttributes;

    public function setBodyAttributes(array $attributes): BodyAttributeInterface
    {
        $this->bodyAttributes = $attributes;

        return $this;
    }

    public function addBodyAttribute(string $name, string $value): BodyAttributeInterface
    {
        $this->bodyAttributes[$name] = $value;

        return $this;
    }

    public function removeBodyAttribute(string $name): BodyAttributeInterface
    {
        unset($this->bodyAttributes[$name]);

        return $this;
    }

    public function getBodyAttributes(): array
    {
        return $this->bodyAttributes;
    }

    public function hasBodyAttribute(string $name): bool
    {
        return isset($this->bodyAttributes[$name]);
    }
}
