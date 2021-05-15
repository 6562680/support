<?php

namespace Gzhegow\Support\Domain\Arr;


/**
 * WalkIterator
 */
class WalkIterator implements \Iterator
{
    /**
     * @var array
     */
    protected $array;
    /**
     * @var int
     */
    protected $flags;

    /**
     * @var \Iterator
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
     * @param array $array
     * @param int   $flags
     */
    public function __construct(array $array = [], $flags = 0)
    {
        $this->array = $array;
        $this->flags = $flags;

        $this->rewind();
    }


    /**
     * @param array $array
     * @param int   $flags
     *
     * @return \ArrayIterator
     */
    public function newIterator(array $array = [], $flags = 0) : \ArrayIterator
    {
        $iterator = new \ArrayIterator($array, $flags);

        return $iterator;
    }


    /**
     * @return array
     */
    public function getArray() : array
    {
        return $this->array;
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
        $this->iterator = $this->newIterator($this->array, $this->flags);
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
            $this->stack[] = $this->newIterator($val, $this->flags);
            $this->pathes[] = $key;
        }

        $this->iterator->next();
    }


    /**
     * @return bool
     */
    public function valid() : bool
    {
        $isValid = $this->iterator && ( null !== $this->iterator->key() );

        while ( ! $isValid && ( null !== key($this->stack) ) ) {
            $this->iterator = array_shift($this->stack);
            $this->path = array_shift($this->pathes);

            if ($isValid = $this->iterator && ( null !== $this->iterator->key() )) {
                break;
            }
        }

        return $isValid;
    }
}
