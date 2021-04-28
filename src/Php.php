<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Php
 */
class Php
{
    /**
     * @var Type
     */
    protected $type;


    /**
     * Constructor
     *
     * @param Type $type
     */
    public function __construct(Type $type)
    {
        $this->type = $type;
    }


    /**
     * @param object $object
     *
     * @return array
     */
    public function getPublicVars(object $object) : array
    {
        return get_object_vars($object);
    }


    /**
     * @param string $name
     * @param null   $value
     *
     * @return null|string
     */
    public function const(string $name, $value = null) : ?string
    {
        if (! $name) {
            throw new InvalidArgumentException('Argument 1 should be defined');
        }

        if (! defined($name)) {
            define($name, $value);

        } else {
            if (isset($value)) {
                throw new RuntimeException('Constant is already defined: ' . $name);
            }
        }

        return constant($name);
    }


    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargs(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        foreach ( $arguments as $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    if ($this->type->isInt($key)) {
                        $args[ $key ] = $val;

                    } else {
                        $kwargs[ $key ] = $val;

                    }
                }
            } else {
                $args[] = $argument;
            }
        }

        return [ $kwargs, $args ];
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargsFlatten(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        array_walk_recursive($arguments, function ($val, $key) use (&$kwargs, &$args) {
            if ($this->type->isInt($key)) {
                $args[ $key ] = $val;

            } else {
                $kwargs[ $key ] = $val;

            }
        });

        return [ $kwargs, $args ];
    }


    /**
     * @param mixed ...$arguments
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function kwparams(...$arguments) : array
    {
        $registry = [];

        $kwargs = [];
        $args = [];
        foreach ( $arguments as $idx => $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    if (isset($registry[ $key ])) {
                        throw new InvalidArgumentException('Duplicate key found: ' . $key, $arguments);

                    } else {
                        $registry[ $key ] = true;

                        if ($this->type->isInt($key)) {
                            $args[ $key ] = $val;

                        } else {
                            $kwargs[ $key ] = $val;

                        }
                    }
                }
            } else {
                if (! isset($registry[ $idx ])) {
                    $registry[ $idx ] = true;

                    $args[ $idx ] = $argument;

                } else {
                    throw new InvalidArgumentException('Duplicate key found: ' . $idx, $arguments);
                }
            }
        }

        return [ $kwargs, $args ];
    }


    /**
     * @param string|object $item
     *
     * @return array
     */
    public function splitclass($item) : array
    {
        $class = $item;

        switch ( true ):
            case is_object($item):
                $class = get_class($item);
                break;

        endswitch;

        if (! is_string($class)) {
            throw new InvalidArgumentException('Class should be string or object');
        }

        $result = explode('\\', $class);

        return $result;
    }


    /**
     * @param mixed $item
     *
     * @return array
     */
    public function nsclass($item) : array
    {
        $array = $this->splitclass($item);

        $class = array_pop($array);
        $namespace = implode($separator = '\\', $array)
            ?: null;

        return [ $namespace, $class ];
    }

    /**
     * @param mixed $item
     *
     * @return string
     */
    public function class($item) : string
    {
        $array = $this->splitclass($item);

        return array_pop($array);
    }

    /**
     * @param             $item
     *
     * @return null|string
     */
    public function namespace($item) : ?string
    {
        $array = $this->splitclass($item);

        array_pop($array);

        return implode('\\', $array);
    }


    /**
     * @param mixed       $item
     * @param string|null $base
     *
     * @return string
     */
    public function baseclass($item, string $base = null) : string
    {
        switch ( true ):
            case is_string($item) && class_exists($item):
                $class = $item;
                break;

            case is_object($item):
                $class = get_class($item);
                break;

            default:
                throw new InvalidArgumentException('Argument 1 should be object or class', func_get_args());

        endswitch;

        $relative = $class;

        if ($base && 0 === stripos($class, rtrim($base, '\\'))) {
            $relative = str_ireplace($base . '\\', '', $class);
        }

        return $relative;
    }
}
