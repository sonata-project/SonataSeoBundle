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

use Sonata\Exporter\Source\ChainSourceIterator;
use Sonata\Exporter\Source\SourceIteratorInterface;

/**
 * @final since sonata-project/seo-bundle 2.x
 *
 * Manager several chain source iterator grouped.
 */
final class SourceManager implements SourceIteratorInterface
{
    /**
     * @var \ArrayIterator
     */
    private $sources;

    public function __construct()
    {
        $this->sources = new \ArrayIterator();
    }

    /**
     * Adding source with his group.
     *
     * @param string $group
     */
    public function addSource($group, SourceIteratorInterface $source, array $types = []): void
    {
        if (!isset($this->sources[$group])) {
            $this->sources[$group] = new \stdClass();

            $this->sources[$group]->sources = new ChainSourceIterator();
            $this->sources[$group]->types = [];
        }

        $this->sources[$group]->sources->addSource($source);

        if ($types) {
            $this->sources[$group]->types += array_diff($types, $this->sources[$group]->types);
        }
    }

    public function current()
    {
        return $this->sources->current();
    }

    public function next(): void
    {
        $this->sources->next();
    }

    public function key()
    {
        return $this->sources->key();
    }

    public function valid()
    {
        return $this->sources->valid();
    }

    public function rewind(): void
    {
        $this->sources->rewind();
    }
}
