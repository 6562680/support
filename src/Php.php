<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Domain\Type\Interfaces\CanToArrayInterface;


/**
 * Php
 */
class Php
{
    /**
     * @var Filter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param Filter $filter
     */
    public function __construct(
        Filter $filter
    )
    {
        $this->filter = $filter;
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
     * @param null $data
     *
     * @return array
     */
    public function arrval($data = null) : array
    {
        $result = [];

        if (is_null($data)) {
            $result = [];

        } elseif (is_scalar($data)) {
            $result = [ $data ];

        } elseif (is_array($data)) {
            $result = $data;

        } elseif (is_object($data)) {
            if (is_a($data, CanToArrayInterface::class)) {
                $result = $data->toArray();

            } elseif (is_iterable($data)) {
                foreach ( $data as $idx => $item ) {
                    if (null !== $this->filter->filterKey($idx)) {
                        $result[ $idx ] = $item;

                    } else {
                        $result[] = $item;

                    }
                }

            } else {
                $result = null;

                try {
                    $result = $data->toArray();
                }
                catch ( \Throwable $e ) {
                    throw new InvalidArgumentException('Unable to convert variable to array', $data);
                }

                return $result;
            }

        } else {
            throw new InvalidArgumentException('Unable to convert variable to array', $data);
        }

        return $result;
    }


    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public function listval(...$items) : array
    {
        $result = [];

        foreach ( $items as $idx => $item ) {
            if (is_iterable($item)) {
                foreach ( $item as $val ) {
                    $result[] = $val;
                }
            } else {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public function listvalFlatten(...$items) : array
    {
        $result = [];

        array_walk_recursive($items, function ($item) use (&$result) {
            if (is_iterable($item)) {
                foreach ( $item as $int => $val ) {
                    $result[] = $val;
                }
            } else {
                $result[] = $item;
            }
        });

        return $result;
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
                    ( null !== $this->filter->filterInt($key) )
                        ? ( $args[] = $val )
                        : ( $kwargs[ $key ] = $val );
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
    public function kwargsDistinct(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        foreach ( $arguments as $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    ( null !== ( $int = $this->filter->filterInt($key) ) )
                        ? ( $args[ $int ] = $val )
                        : ( $kwargs[ $key ] = $val );
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
            ( null !== $this->filter->filterInt($key) )
                ? ( $args[] = $val )
                : ( $kwargs[ $key ] = $val );
        });

        return [ $kwargs, $args ];
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargsFlattenDistinct(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        array_walk_recursive($arguments, function ($val, $key) use (&$kwargs, &$args) {
            ( null !== ( $int = $this->filter->filterInt($key) ) )
                ? ( $args[ $int ] = $val )
                : ( $kwargs[ $key ] = $val );
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
        $kwargs = [];
        $args = [];

        $registry = [];
        foreach ( $arguments as $idx => $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    if (isset($registry[ $key ])) {
                        throw new InvalidArgumentException('Duplicate key found: ' . $key, $arguments);

                    } else {
                        $registry[ $key ] = true;

                        ( null !== ( $int = $this->filter->filterInt($key) ) )
                            ? ( $args[ $int ] = $val )
                            : ( $kwargs[ $key ] = $val );
                    }
                }
            } else {
                if (isset($registry[ $idx ])) {
                    throw new InvalidArgumentException('Duplicate key found: ' . $idx, $arguments);

                } else {
                    $registry[ $idx ] = true;

                    $args[ $idx ] = $argument;
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
     * @return string[]
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
