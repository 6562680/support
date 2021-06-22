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
     * @param callable $callable
     *
     * @return \ReflectionFunction
     */
    protected function newReflectionFunction($callable) : \ReflectionFunction
    {
        try {
            $rf = new \ReflectionFunction($callable);
        }
        catch ( \ReflectionException $e ) {
            throw new RuntimeException(
                [ 'Unable to reflect function: %s', $callable ],
                null,
                $e
            );
        }

        return $rf;
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
                $i = iterator_count($value);

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
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return bool
     */
    public function isFactory(\Closure $func, string $returnType) : bool
    {
        return null !== $this->filterFactory($func, $returnType);
    }


    /**
     * проверяет возвращаемый тип у замыкания
     *
     * @param \Closure        $factory
     * @param string|callable $returnType
     *
     * @return null|\Closure
     */
    public function filterFactory(\Closure $factory, $returnType) : ?\Closure
    {
        $reflectionFunction = $this->newReflectionFunction($factory);

        $reflectionType = $reflectionFunction->getReturnType();

        // factory requires a type
        $types = [];
        if ($reflectionType) {
            $types = ( is_a($reflectionType, 'ReflectionUnionType') )
                ? $reflectionType->getTypes()
                : [ $reflectionType ];

        } else {
            $lines = array_map('trim', explode("\n", $reflectionFunction->getDocComment()));

            foreach ( $lines as $line ) {
                if (0 === strpos($line, $needle = '* @return ')) {
                    $line = substr($line, strlen($needle));

                    $types = explode(' ', $line)[ 0 ];
                    $types = explode('|', $types);
                }
            }
        }

        // factory returns only one type
        if (count($types) > 1) {
            return null;
        }

        $type = reset($types);

        $returnTypeCallback = is_callable($returnType)
            ? $this->bind($returnType, $type)
            : function ($type) use ($returnType) {
                if (is_a($type, 'ReflectionType')) {
                    if (is_a($type, 'ReflectionNamedType')) {
                        return false
                            || ( $type->isBuiltin() && ( $type->getName() !== $returnType ) )
                            || ( is_a($type->getName(), $returnType) );

                    } elseif ($type->allowsNull()) {
                        return 'null' === $returnType;
                    }
                } else {
                    return $type === $returnType;
                }

                return false;
            };

        $result = $returnTypeCallback($type)
            ? $factory
            : null;

        return $result;
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
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return \Closure
     */
    public function assertFactory(\Closure $func, $returnType) : \Closure
    {
        if (null === $this->filterFactory($func, $returnType)) {
            throw new InvalidArgumentException(
                [ '\Closure has invalid return type: %s', $returnType ]
            );
        }

        return $func;
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
     * @param object $object
     *
     * @return array
     */
    public function objKeys(object $object) : array
    {
        return ( function () {
            return array_keys(get_object_vars($this));
        } )->call($object);
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public function objVars(object $object) : array
    {
        return ( function () {
            return get_object_vars($this);
        } )->call($object);
    }


    /**
     * @param object $object
     *
     * @return array
     */
    public function objKeysPublic(object $object) : array
    {
        return array_keys(get_object_vars($object));
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public function objVarsPublic(object $object) : array
    {
        return get_object_vars($object);
    }


    /**
     * Превращает примитивы и массивы любой вложенности в одноуровневый список
     *
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
     * Превращает каждый аргумент из примитивов и массивов любой вложенности в список списков
     *
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
     * Превращает enum-список любой вложенности (значения могут быть в ключах или в полях) в список уникальных значений
     *
     * @param mixed ...$items
     *
     * @return array
     */
    public function enumval(...$items) : array
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
                    ?? $this->filter->filterWordOrNum($valOrBool)
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
     * Превращает каждый аргумент с помощью enumval
     *
     * @param mixed ...$enums
     *
     * @return array
     */
    public function enumvals(...$enums) : array
    {
        $result = [];

        foreach ( $enums as $idx => $map ) {
            $result[ $idx ] = $this->enumval($map);
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
     * Превращает примитивы и массивы любой вложенности в одноуровневый список
     *
     * @param mixed ...$items
     *
     * @return array
     */
    public function collect(...$items) : array
    {
        $result = [];

        foreach ( $items as $idx => $item ) {
            if (is_iterable($item)) {
                foreach ( $item as $val ) {
                    $result[ $idx ][] = $val;
                }
            } else {
                $result[ $idx ][] = $item;
            }
        }

        return $result;
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

        foreach ( $sleeps as $sleep ) {
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
     * выполняет функцию как шаг array_filter
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return bool|array
     */
    public function filter(?callable $func, $arg, ...$arguments) : bool
    {
        if (! $func) {
            return empty($arg);
        }

        $result = (bool) call_user_func(
            $this->bind($func, $arg, ...$arguments)
        );

        return $result;
    }

    /**
     * выполняет функцию как шаг array_map
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return mixed
     */
    public function map(?callable $func, $arg, ...$arguments) // : mixed
    {
        if (! $func) {
            return $arg;
        }

        $result = call_user_func(
            $this->bind($func, $arg, ...$arguments)
        );

        return $result;
    }

    /**
     * выполняет функцию как шаг array_reduce
     *
     * @param null|callable $func
     * @param               $arg
     * @param null          $carry
     * @param array         $arguments
     *
     * @return mixed
     */
    public function reduce(?callable $func, $arg, $carry = null, ...$arguments) // : mixed
    {
        if (! $func) {
            return $carry;
        }

        $result = call_user_func(
            $this->bind($func, $carry, $arg, ...$arguments)
        );

        return $result;
    }


    /**
     * bind
     * копирует тело функции и присваивает аргументы на их места в переданном порядке
     * bind('is_array', [], 1, 2) -> Closure of (function is_array($var = []))
     *
     * @param callable $func
     * @param mixed    ...$arguments
     *
     * @return \Closure
     */
    public function bind(callable $func, ...$arguments) : \Closure
    {
        // string
        if (is_string($func)) {
            $bind = [];

            $rf = $this->newReflectionFunction($func);

            $requiredCnt = $rf->getNumberOfRequiredParameters();

            while ( $requiredCnt-- ) {
                $bind[] = null !== key($arguments)
                    ? current($arguments)
                    : null;

                next($arguments);
            }

            $func = \Closure::fromCallable($func);

        } else {
            $bind = $arguments;

        }

        $result = function (...$args) use ($func, $bind) {
            $bind = array_replace(
                $bind,
                array_slice($args, 0, count($bind))
            );

            return call_user_func_array($func, $bind);
        };

        return $result;
    }


    /**
     * call
     * шорткат для call_user_func с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function call(callable $func, ...$arguments) // : mixed
    {
        return call_user_func($this->bind($func, ...$arguments));
    }

    /**
     * apply
     * шорткат для call_user_func_array с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function apply(callable $func, array $arguments) // : mixed
    {
        return call_user_func($this->bind($func, ...$arguments));
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
}
