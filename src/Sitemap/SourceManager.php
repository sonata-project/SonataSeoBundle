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

namespace Sonata\SeoBundle\Sitemap;

/**
 * Manager several chain source iterator grouped.
 *
 * @phpstan-implements \Iterator<string, Source>
 */
final class SourceManager implements \Iterator
{
    /**
     * @var \ArrayIterator<string, Source>
     */
    private \ArrayIterator $sources;

    public function __construct()
    {
        $this->sources = new \ArrayIterator();
    }

    /**
     * Adding source with his group.
     *
     * @param mixed[] $types
     *
     * @psalm-suppress PossiblyNullReference
     */
    public function addSource(string $group, \Iterator $source, array $types = []): void
    {
        if (!isset($this->sources[$group])) {
            $this->sources[$group] = new Source();
        }

        $this->sources[$group]->addSource($source);

        if ([] !== $types) {
            $this->sources[$group]->addTypes($types);
        }
    }

    /**
     * @return Source
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        $current = $this->sources->current();
        \assert(null !== $current);

        return $current;
    }

    public function next(): void
    {
        $this->sources->next();
    }

    /**
     * @return string
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        $key = $this->sources->key();
        \assert(null !== $key);

        return $key;
    }

    public function valid(): bool
    {
        return $this->sources->valid();
    }

    public function rewind(): void
    {
        $this->sources->rewind();
    }
}
