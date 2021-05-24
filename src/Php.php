<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;


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
     * @param mixed &$value
     *
     * @return bool
     */
    public function isEmpty(&$value) : bool
    {
        if (empty($value)) {
            return true;
        }

        if (is_object($value)) {
            if (is_countable($value)) {
                return ! count($value);

            } elseif (is_iterable($value)) {
                $i = 0;
                foreach ( $value as $v ) {
                    $i++;
                }

                return $i === 0;
            }
        }

        return false;
    }


    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertEmpty(&$value) // : mixed
    {
        if (false === $this->isEmpty($value)) {
            throw new InvalidArgumentException('Value should exists');
        }

        return $value;
    }

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertIsset(&$value) // : mixed
    {
        if (false === isset($value)) {
            throw new InvalidArgumentException('Value should exists');
        }

        return $value;
    }


    /**
     * @param string $key
     * @param array  $array
     *
     * @return mixed
     */
    public function assertKeyExists(string $key, array $array) // : mixed
    {
        if (false === array_key_exists($key, $array)) {
            throw new InvalidArgumentException('Key not found: ' . $key);
        }

        return $array[ $key ];
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
     * возвращает строчный идентификатор значения любой переменной в виде строки для дальнейшего сравнения
     * идентификаторы могут быть позже использованы другими обьектами
     * поэтому его актуальность до тех пор, пока конкретный обьект существует
     *
     * @param mixed $value
     *
     * @return string
     */
    public function hash($value) : string
    {
        switch ( true ):
            case is_null($value):
            case is_bool($value):
                return var_export($value, 1);

            case is_int($value):
                return sprintf('%d', $value);

            case ( is_float($value) && is_nan($value) ):
                return 'NaN';

            case is_float($value):
                return sprintf('%f', $value);

            case is_string($value):
                return $value;

            case is_array($value):
                return md5('#' . json_encode($value));

            case is_object($value):
                return '{' . spl_object_hash((object) $value) . '}';

            case ( is_resource($value) || 'resource (closed)' === gettype($value) ):
                return '{#' . intval($value) . '}';

        endswitch;

        throw new UnexpectedValueException(
            [ 'Unable to hash passed element: %s', $value ]
        );
    }


    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function intval($value) : ?int
    {
        if (null === $this->filter->filterIntval($value)) {
            return null;
        }

        $result = intval($value);

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function floatval($value) : ?float
    {
        if (null === $this->filter->filterFloatval($value)) {
            return null;
        }

        $result = floatval($value);

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function numval($value) // : ?int|float
    {
        if (null === $this->filter->filterNumval($value)) {
            return null;
        }

        return null
            ?? $this->intval($value)
            ?? $this->floatval($value);
    }


    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function strval($value) : ?string
    {
        if (null === $this->filter->filterStrval($value)) {
            return null;
        }

        $result = strval($value);

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function theStrval($value) : ?string
    {
        if (null === $this->filter->filterTheStrval($value)) {
            return null;
        }

        $result = strval($value);

        return $result;
    }


    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public function arrval($value) : ?array
    {
        if (is_array($value)) {
            return $value;

        } elseif (is_null($value)) {
            return [];

        } elseif (is_scalar($value)) {
            return [ $value ];

        } elseif (is_iterable($value)) {
            $result = [];

            foreach ( $value as $key => $item ) {
                ( null === ( $strval = $this->filter->filterKey($key) ) )
                    ? ( $result[ $strval ] = $item )
                    : ( $result[] = $item );
            }

            return $result;

        } elseif (is_object($value)) {
            // if (method_exists($value, 'toArray')) // too slow

            $result = null;
            try {
                $result = $value->toArray();
            }
            catch ( \Throwable $e ) {
            }

            /** @noinspection PhpExpressionAlwaysNullInspection */
            return $result;
        }

        return null;
    }


    /**
     * @param mixed $classOrObject
     *
     * @return null|string
     */
    public function classval($classOrObject) : ?string
    {
        $result = null;

        if (null !== ( $class = $this->filter->filterClass($classOrObject) )) {
            $result = $class;

        } elseif (is_object($classOrObject)) {
            if (null !== ( $reflectionClass = $this->filter->filterReflectionClass($classOrObject) )) {
                $result = $reflectionClass->getName();

            } else {
                $result = get_class($classOrObject);
            }
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
     * @param int|float|int[]|float[] $sleeps
     *
     * @return static
     */
    public function sleep($sleeps)
    {
        $sleeps = is_array($sleeps)
            ? $sleeps
            : [ $sleeps ];

        foreach ( $sleeps as $sleep ) {
            if (null === $this->numval($sleep)) {
                throw new InvalidArgumentException(
                    [ 'Each sleep should be numerable: %s', $sleep ],
                );
            }
        }

        $sleepMin = max(0, min($sleeps));
        $sleepMax = max(0, max($sleeps));

        $sleepCurrent = $sleepMin;

        if ($sleepCurrent !== $sleepMax) {
            $sleepCurrent = ( $sleepMin + lcg_value() * ( abs($sleepMax - $sleepMin) ) );

            // wait microseconds
            usleep($sleepCurrent * 1000 * 1000);

        } elseif (is_float($sleepCurrent)) {
            // wait microseconds
            usleep($sleepCurrent * 1000 * 1000);

        } else {
            // wait seconds
            sleep($sleepCurrent);
        }

        return $this;
    }


    /**
     * @param null|\Throwable $e
     * @param null|int        $limit
     *
     * @return array
     */
    public function throwableMessages(\Throwable $e, int $limit = -1)
    {
        $messages = [];

        $parent = $e;
        while ( null !== $parent ) {
            $messages[ get_class($parent) ][] = $parent->getMessage();

            if (! $limit--) break;

            $parent = $parent->getPrevious();
        }

        return $messages;
    }


    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и отфильтровать их
     *
     * @param array         $args
     * @param int|int[]     $num
     * @param null|callable $coalesce
     *
     * @return null|mixed
     */
    protected function overload(array &$args, $num, callable $coalesce = null) // : ?mixed
    {
        $arr = $this->listvalFlatten($num);
        $arr = array_map('intval', $arr);

        $min = max(0, min($arr));
        $max = max(0, max($arr));

        $result = null;
        for ( $i = $max; $i >= $min; $i-- ) {
            if (array_key_exists($i, $args)) {
                if (! $coalesce) {
                    $result = $args[ $i ];
                    $args[ $i ] = null;

                } elseif (null !== ( $result = $coalesce($args[ $i ], $num, $args) )) {
                    $args[ $i ] = null;

                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и проверить их
     *
     * @param array         $args
     * @param int|int[]     $num
     * @param null|callable $if
     *
     * @return null|mixed
     */
    protected function overloadIf(array &$args, $num, callable $if = null) // : ?mixed
    {
        $arr = $this->listvalFlatten($num);
        $arr = array_map('intval', $arr);

        $min = max(0, min($arr));
        $max = max(0, max($arr));

        $result = null;
        for ( $i = $max; $i >= $min; $i-- ) {
            if (array_key_exists($i, $args)) {
                if (! $if) {
                    $result = $args[ $i ];
                    $args[ $i ] = null;

                } elseif ($if($args[ $i ], $num, $args)) {
                    $result = $args[ $i ];
                    $args[ $i ] = null;

                    break;
                }
            }
        }

        return $result;
    }
}
