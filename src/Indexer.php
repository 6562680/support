<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Indexer
 */
class Indexer
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Php
     */
    protected $php;

    /**
     * @var string
     */
    protected $separator = "\0";



    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Php    $php
     */
    public function __construct(
        Filter $filter,
        Php $php
    )
    {
        $this->filter = $filter;
        $this->php = $php;
    }


    /**
     * @return string
     */
    public function getSeparator() : string
    {
        return $this->separator;
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function isIndexValue($value) : bool
    {
        if (! ( 0
            || is_array($value)
            || $this->isIndexValueItem($value)
        )) {
            return false;
        }

        $result = true;

        $queue = [ $value ];
        while ( null !== key($queue) ) {
            $current = array_shift($queue);

            if (is_array($current)) {
                foreach ( $current as $v ) {
                    $queue[] = $v;
                }

            } elseif (! $this->isIndexValueItem($current)) {
                $result = false;

                break;
            }
        }

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function isIndexValueItem($value) : bool
    {
        return is_null($value)
            || is_scalar($value);
    }


    /**
     * @param string $separator
     *
     * @return static
     */
    public function setSeparator(string $separator)
    {
        $this->separator = $separator;

        return $this;
    }


    /**
     * @param string|string[] $keys
     *
     * @return string
     */
    public function index(...$keys) : string
    {
        $path = $this->path(...$keys);

        $result = implode($this->separator, $path);

        return $result;
    }

    /**
     * @param string|string[] $keys
     *
     * @return string
     */
    public function indexUnsafe(...$keys) : string
    {
        $path = $this->pathUnsafe(...$keys);

        $result = implode($this->separator, $path);

        return $result;
    }


    /**
     * @param string|string[] $indexes
     *
     * @return array
     */
    public function path(...$indexes) : array
    {
        $args = $this->php->listvalFlatten(...$indexes);

        $path = [];
        foreach ( $args as $arg ) {
            if (null === $this->filter->filterStringOrNumber($arg)) {
                throw new InvalidArgumentException('Each part should be string or number', $indexes);
            }

            $list = is_string($arg)
                ? explode($this->separator, $arg)
                : [ $arg ];

            foreach ( $list as $part ) {
                $path[] = $part;
            }
        }

        return $path;
    }

    /**
     * @param string|string[] $indexes
     *
     * @return array
     */
    public function pathUnsafe(...$indexes) : array
    {
        $args = $this->php->listvalFlatten(...$indexes);

        $path = [];
        foreach ( $args as $arg ) {
            if (null !== $this->filter->filterStringOrNumber($arg)) {
                $list = is_string($arg)
                    ? explode($this->separator, $arg)
                    : [ $arg ];

                foreach ( $list as $part ) {
                    $path[] = $part;
                }
            }
        }

        return $path;
    }


    /**
     * @param mixed $value
     *
     * @return string
     */
    public function indexValue($value) : string
    {
        if (! $this->isIndexValue($value)) {
            throw new InvalidArgumentException('Value cannot be an index, allowed only: nulls, scalars, arrays with scalars',
                $value);
        }

        $result = json_encode($value);

        return $result;
    }
}
