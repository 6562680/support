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
    public function isBlank(&$value) : bool
    {
        if (0 === $value) {
            return false;
        }

        if (0.0 === $value) {
            return false;
        }

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
     * @return bool
     */
    public function isNotBlank(&$value) : bool
    {
        return ! $this->isBlank($value);
    }


    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertBlank(&$value) // : mixed
    {
        if (false === $this->isBlank($value)) {
            throw new InvalidArgumentException([ 'Value should be empty: %s', $value ]);
        }

        return $value;
    }

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public function assertNotBlank(&$value) // : mixed
    {
        if (false === $this->isNotBlank($value)) {
            throw new InvalidArgumentException([ 'Value should not be blank: %s', $value ]);
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
            throw new InvalidArgumentException([ 'Value should exists: %s', $value ]);
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

            case ( null !== $this->filter->filterPlainArray($value) ):
                return json_encode($value);

            case ( is_array($value) ):
                return md5(json_encode($value));

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
     * @param mixed ...$items
     *
     * @return array
     */
    public function listval(...$items) : array
    {
        $result = [];

        array_walk_recursive($items, function ($item) use (&$result) {
            if (is_iterable($item)) {
                foreach ( $item as $val ) {
                    $result[] = $val;
                }
            } else {
                $result[] = $item;
            }
        });

        return $result;
    }

    /**
     * @param mixed ...$lists
     *
     * @return array
     */
    public function listvals(...$lists) : array
    {
        $result = [];

        foreach ( $lists as $idx => $list ) {
            $result[ $idx ] = $this->listval($list);
        }

        return $result;
    }


    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public function mapval(...$items) : array
    {
        $result = [];

        array_walk_recursive($items, function ($item, $key) use (&$result) {
            $map = [];

            if (is_iterable($item)) {
                foreach ( $item as $itemKey => $itemVal ) {
                    $map[ $itemKey ] = $itemVal;
                }
            } else {
                $map[ $key ] = $item;
            }

            foreach ( $map as $valOrKey => $valOrBool ) {
                $isIgnore = null === $valOrBool
                    || false === $valOrBool
                    || '' === $valOrBool;

                if ($isIgnore) {
                    continue;
                }

                $value = null
                    ?? ( true === $valOrBool ? $valOrKey : null )
                    ?? $this->filter->filterWord($valOrKey)
                    ?? $this->filter->filterWordOrNumber($valOrBool)
                    ?? $this->filter->filterInt($valOrKey);

                if (null === $value) {
                    continue;
                }

                $result[ $this->hash($value) ] = $value;
            }
        });

        $result = array_values($result);

        return $result;
    }

    /**
     * @param mixed ...$maps
     *
     * @return array
     */
    public function mapvals(...$maps) : array
    {
        $result = [];

        foreach ( $maps as $idx => $map ) {
            $result[ $idx ] = $this->mapval($map);
        }

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
                    is_int($key)
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
                    is_int($key)
                        ? ( $args[ $key ] = $val )
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
    public function theKwargs(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        $flatten = [];
        foreach ( $arguments as $idx => $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    $flatten[] = [ $key, $val ];
                }
            } else {
                $flatten[] = [ $idx, $argument ];
            }
        }

        $registry = [];
        foreach ( $flatten as [ $key, $val ] ) {
            if (isset($registry[ $key ])) {
                throw new InvalidArgumentException('Duplicate key: ' . $key);
            }

            $registry[ $key ] = true;

            is_int($key)
                ? ( $args[ $key ] = $val )
                : ( $kwargs[ $key ] = $val );
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
            is_int($key)
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
            is_int($key)
                ? ( $args[ $key ] = $val )
                : ( $kwargs[ $key ] = $val );
        });

        return [ $kwargs, $args ];
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function theKwargsFlatten(...$arguments) : array
    {
        $kwargs = [];
        $args = [];

        $flatten = [];
        array_walk_recursive($arguments, function ($val, $key) use (&$flatten) {
            $flatten[] = [ $key, $val ];
        });

        $registry = [];
        foreach ( $flatten as [ $key, $val ] ) {
            if (isset($registry[ $key ])) {
                throw new InvalidArgumentException('Duplicate key: ' . $key);
            }

            $registry[ $key ] = true;

            is_int($key)
                ? ( $args[ $key ] = $val )
                : ( $kwargs[ $key ] = $val );
        }

        return [ $kwargs, $args ];
    }


    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function distinct(array $values) : array
    {
        $result = [];

        $arr = [];
        foreach ( $values as $idx => $value ) {
            $arr[ $this->hash($value) ] = $idx;
        }

        foreach ( $arr as $idx ) {
            $result[ $idx ] = $values[ $idx ];
        }

        return $result;
    }


    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function unique(...$values) : array
    {
        $arr = [];
        foreach ( $values as $value ) {
            $arr[ $this->hash($value) ] = $value;
        }

        return array_values($arr);
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function uniqueFlatten(...$values) : array
    {
        $arr = [];
        array_walk_recursive($values, function ($value) use (&$arr) {
            $arr[ $this->hash($value) ] = $value;
        });

        return array_values($arr);
    }


    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function duplicates(...$values) : array
    {
        $arr = [];
        $duplicates = [];
        foreach ( $values as $value ) {
            $hash = $this->hash($value);

            if (isset($arr[ $hash ])) {
                $duplicates[ $hash ][] = $value;
            }

            $arr[ $hash ] = true;
        }

        return $duplicates;
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public function duplicatesFlatten(...$values) : array
    {
        $arr = [];
        $duplicates = [];
        array_walk_recursive($values, function ($value) use (&$duplicates, &$arr) {
            $hash = $this->hash($value);

            if (isset($arr[ $hash ])) {
                $duplicates[ $hash ][] = $value;
            }

            $arr[ $hash ] = true;
        });

        return $duplicates;
    }


    /**
     * @param int|float|int[]|float[] $sleeps
     *
     * @return static
     */
    public function sleep(...$sleeps)
    {
        $sleeps = $this->listval(...$sleeps);

        foreach ( $sleeps as $idx => $sleep ) {
            if (! is_numeric($sleep)) {
                throw new InvalidArgumentException(
                    [ 'Each sleep should be numeric: %s', $sleep ],
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
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и отфильтровать их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $coalesce
     *
     * @return null|mixed
     */
    public function overload(?array &$args, $num, callable $coalesce = null) // : ?mixed
    {
        $args = $args ?? [];

        $num = is_array($num)
            ? $num
            : [ $num ];

        foreach ( $num as $n ) {
            if (! is_int($n)) {
                throw new InvalidArgumentException(
                    [ 'Each num should be integer: %s', $n ]
                );
            }
        }

        $numMin = max(0, min($num));
        $numMax = max(0, max($num));

        $result = null;
        for ( $i = $numMax; $i >= $numMin; $i-- ) {
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
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $if
     *
     * @return null|mixed
     */
    public function overloadIf(?array &$args, $num, callable $if = null) // : ?mixed
    {
        $args = $args ?? [];

        $num = is_array($num)
            ? $num
            : [ $num ];

        foreach ( $num as $n ) {
            if (! is_int($n)) {
                throw new InvalidArgumentException(
                    [ 'Each num should be integer: %s', $n ]
                );
            }
        }

        $numMin = max(0, min($num));
        $numMax = max(0, max($num));

        $result = null;
        for ( $i = $numMax; $i >= $numMin; $i-- ) {
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
}
