<?php

namespace Gzhegow\Support\Domain\Arr;

use Gzhegow\Support\Exceptions\RuntimeException;


/**
 * TreeIterator
 */
class TreeIterator implements \Iterator
{
    /**
     * @var iterable
     */
    protected $iterable;
    /**
     * @var int
     */
    protected $flags;

    /**
     * @var \Traversable
     */
    protected $iterator;
    /**
     * @var array
     */
    protected $path = [];

    /**
     * @var array
     */
    protected $stack = [];
    /**
     * @var array
     */
    protected $pathes = [];


    /**
     * Constructor
     *
     * @param iterable $iterable
     * @param int      $flags
     */
    public function __construct(iterable $iterable = [], $flags = 0)
    {
        $this->iterable = $iterable;
        $this->flags = $flags;

        $this->rewind();
    }


    /**
     * @param iterable|array $iterable
     * @param int            $flags
     *
     * @return \ArrayIterator
     */
    public function newIterator(iterable $iterable = [], $flags = 0) : \Traversable
    {
        $iterator = null;

        if (is_object($iterable)) {
            if (is_a($iterable, \IteratorAggregate::class)) {
                try {
                    $iterator = $iterable->getIterator();
                }
                catch ( \Exception $e ) {
                    throw new RuntimeException('Unable to retrieve iterator from ' . \IteratorAggregate::class,
                        $iterable);
                }
            } elseif (is_a($iterable, \Traversable::class)) {
                $iterator = $iterable;
            }
        } else {
            $iterator = new \ArrayIterator($iterable, $flags);
        }

        return $iterator;
    }


    /**
     * @return iterable
     */
    public function getIterable()
    {
        return $this->iterable;
    }

    /**
     * @return int
     */
    public function getFlags() : int
    {
        return $this->flags;
    }


    /**
     * @return void
     */
    public function rewind()
    {
        $this->iterator = $this->newIterator($this->iterable, $this->flags);
        $this->path = [];

        $this->stack = [];
        $this->pathes = [];
    }


    /**
     * @return mixed
     */
    public function current()
    {
        $result = $this->valid()
            ? $this->iterator->current()
            : null;

        return $result;
    }

    /**
     * @return array
     */
    public function key() : array
    {
        $fullpath = $this->path ?? [];
        $fullpath[] = $this->iterator->key();

        return $fullpath;
    }


    /**
     * @return void
     */
    public function next()
    {
        $val = $this->current();
        $key = $this->key();

        if (is_iterable($val)) {
            $this->stack[] = $this->newIterator($val, $this->getFlags());
            $this->pathes[] = $key;
        }

        $this->iterator->next();

        if (! $this->valid()) {
            if (null !== key($this->stack)) {
                $this->iterator = array_shift($this->stack);
                $this->path = array_shift($this->pathes);
            }
        }
    }


    /**
     * @return bool
     */
    public function valid() : bool
    {
        return isset($this->iterator)
            && ( null !== $this->iterator->key() );
    }
}
