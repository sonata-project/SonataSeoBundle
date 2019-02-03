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

final class AttributeBag implements \IteratorAggregate
{
    private $attributes = [];

    /**
     * @param string[] $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $this->add($name, $value);
        }
    }

    public function has(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * @param string[] $attributes
     */
    public function set(array $attributes): void
    {
        $this->attributes = [];
        foreach ($attributes as $name => $value) {
            $this->add($name, $value);
        }
    }

    public function add(string $name, string $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function get(string $name, string $default = null): ?string
    {
        return $this->attributes[$name] ?? $default;
    }

    public function remove(string $name): void
    {
        unset($this->attributes[$name]);
    }

    /**
     * @return string[]
     */
    public function all(): array
    {
        return $this->attributes;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->attributes);
    }
}
