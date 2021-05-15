<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Domain\Type\Interfaces\CanToArrayInterface;
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
     * hash
     * возвращает строчный идентификатор значения любой переменной на текущий момент в виде строки для дальнейшего сравнения
     * идентификаторы могут быть позже использованы другими обьектами, поэтому его актуальность до тех пор, пока конкретный обьект существует
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

        throw new UnexpectedValueException('Unable to hash passed element', func_get_args());
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
     * @param mixed $data
     *
     * @return array
     */
    public function arrval($data) : array
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
                    ( null !== $this->filter->filterKey($idx) )
                        ? ( $result[ $idx ] = $item )
                        : ( $result[] = $item );
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
     * @param callable $if
     * @param mixed    ...$items
     *
     * @return null|array
     */
    public function listvalIf(callable $if, ...$items) : ?array
    {
        $list = $this->listval(...$items);

        $result = $this->filter->filterList($list, $if);

        return $result;
    }

    /**
     * @param callable $if
     * @param mixed    ...$items
     *
     * @return null|array
     */
    public function listvalFlattenIf(callable $if, ...$items) : ?array
    {
        $list = $this->listvalFlatten(...$items);

        $result = $this->filter->filterList($list, $if);

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
            if (null === $this->filter->filterNumerable($sleep)) {
                throw new InvalidArgumentException(
                    'Each sleep should be numerable',
                    [ func_get_args(), $sleep ]
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
     * @param array         $args
     * @param int|int[]     $num
     * @param null|callable $filter
     *
     * @return null|mixed
     */
    protected function overload(array &$args, $num, callable $filter = null) // : ?mixed
    {
        $arr = $this->listvalFlatten($num);
        $arr = array_map('intval', $arr);

        $min = max(0, min($arr));
        $max = max(0, max($arr));

        $result = null;
        for ( $i = $max; $i >= $min; $i-- ) {
            if (array_key_exists($i, $args)) {
                if (! $filter) {
                    $result = $args[ $i ];
                    $args[ $i ] = null;

                } elseif (null !== ( $result = $filter($args[ $i ], $num, $args) )) {
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
