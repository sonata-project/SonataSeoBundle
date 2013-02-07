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
     */
    public function addSource($group, SourceIteratorInterface $source)
    {
        if (!isset($this->sources[$group])) {
            $this->sources[$group] = new ChainSourceIterator();
        }

        $this->sources[$group]->addSource($source);
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