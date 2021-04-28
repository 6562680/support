<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


/**
 * Indexer
 */
class Indexer
{
    const INDEX_SEPARATOR = "\0";


    /**
     * @var Php
     */
    protected $php;


    /**
     * @var array
     */
    protected $values = [];


    /**
     * Constructor
     *
     * @param Php $php
     */
    public function __construct(Php $php)
    {
        $this->php = $php;
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
            if (empty($part)) {
                throw new UnexpectedValueException('Empty index detected while parsing keys', $keys);
            }

            $path[] = $part;
        }

        return implode(static::INDEX_SEPARATOR, $path);
    }

    /**
     * @param string|string[] $keys
     *
     * @return string
     */
    public function indexUnsafe(...$keys) : string
    {
        [ , $args ] = $this->php->kwargsFlatten($keys);

        return implode(static::INDEX_SEPARATOR, $args);
    }


    /**
     * @param string|string[] $indexes
     *
     * @return array
     */
    public function path(...$indexes) : array
    {
        $path = [];
        foreach ( $this->pathUnsafe($indexes) as $part ) {
            if (empty($part)) {
                throw new UnexpectedValueException('Empty part detected while parsing sequence', $indexes);
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
            foreach ( explode(static::INDEX_SEPARATOR, $arg) as $part ) {
                $path[] = $part;
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
        if (! $this->assertIndexValue($value)) {
            throw new InvalidArgumentException('Value cannot be an index, allowed only: nulls, scalars, arrays with scalars',
                $value);
        }

        return json_encode($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function assertIndexValue($value) : bool
    {
        if (! ( 0
            || is_array($value)
            || $this->assertIndexValueItem($value)
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

            } elseif (! $this->assertIndexValueItem($current)) {
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
    protected function assertIndexValueItem($value) : bool
    {
        return is_null($value)
            || is_scalar($value);
    }
}
