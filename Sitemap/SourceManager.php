<?php

namespace Sonata\SeoBundle\Sitemap;

use Exporter\Source\SourceIteratorInterface;
use Exporter\Source\ChainSourceIterator;

/**
 * SourceManager
 *
 * Manager several chain source iterator grouped
 */
class SourceManager implements SourceIteratorInterface
{
    /**
     * @var \ArrayIterator[]
     */
    protected $sources;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->sources = new \ArrayIterator();
    }

    /**
     * Adding source with his group
     *
     * @param string                  $group
     * @param SourceIteratorInterface $source
     * @param array                   $types
     */
    public function addSource($group, SourceIteratorInterface $source, array $types = array())
    {
        if (!isset($this->sources[$group])) {
            $this->sources[$group] = new \stdClass();

            $this->sources[$group]->sources = new ChainSourceIterator();
            $this->sources[$group]->types   = array();
        }

        $this->sources[$group]->sources->addSource($source);

        if ($types) {
            $this->sources[$group]->types += array_diff($types, $this->sources[$group]->types);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->sources->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->sources->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->sources->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->sources->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->sources->rewind();
    }
}
