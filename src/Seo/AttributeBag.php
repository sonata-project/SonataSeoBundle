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

class AttributeBag implements \IteratorAggregate
{
    private $attributes = [];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function has(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public function set(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function add(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function get(string $name, $default = null): ?string
    {
        return $this->attributes[$name] ?? $default;
    }

    public function remove(string $name): void
    {
        unset($this->attributes[$name]);
    }

    public function all(): array
    {
        return $this->attributes;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->attributes);
    }
}
