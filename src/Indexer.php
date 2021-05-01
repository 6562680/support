<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


/**
 * Indexer
 */
class Indexer
{
    /**
     * @var Php
     */
    protected $php;
    /**
     * @var Type
     */
    protected $type;

    /**
     * @var string
     */
    protected $separator = "\0";


    /**
     * Constructor
     *
     * @param Php  $php
     * @param Type $type
     */
    public function __construct(
        Php $php,
        Type $type
    )
    {
        $this->php = $php;
        $this->type = $type;
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
        [ , $args ] = $this->php->kwargsFlatten($keys);

        $path = [];
        foreach ( $args as $part ) {
            if (! $this->type->isTheStringOrNumber($part)) {
                throw new UnexpectedValueException('Invalid index while parsing keys', $keys);
            }

            $path[] = $part;
        }

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
        [ , $args ] = $this->php->kwargsFlatten($keys);

        $path = [];
        foreach ( $args as $part ) {
            if ($this->type->isTheStringOrNumber($part)) {
                $path[] = $part;
            }
        }

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
        [ , $args ] = $this->php->kwargsFlatten($indexes);

        $path = [];
        foreach ( $args as $arg ) {
            foreach ( explode($this->separator, $arg) as $part ) {
                if (! $this->type->isTheStringOrNumber($part)) {
                    throw new UnexpectedValueException('Invalid part while parsing sequence', $indexes);
                }

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
        [ , $args ] = $this->php->kwargsFlatten($indexes);

        $path = [];
        foreach ( $args as $arg ) {
            foreach ( explode($this->separator, $arg) as $part ) {
                if ($this->type->isTheStringOrNumber($part)) {
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
