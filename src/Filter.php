<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Type\CallableInfo;
use Gzhegow\Support\Domain\Type\Interfaces\CanToArrayInterface;


/**
 * Filter
 */
class Filter
{
    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public function filterKey($value) // : ?int|string
    {
        // \Generator can pass any object as foreach key, so this check is recommended

        return ( null !== $this->filterStringOrNumber($value) )
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function filterInt($value) : ?int
    {
        if (is_int($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function filterFloat($value) : ?float
    {
        if (( is_float($value) && ! is_nan($value) )) {
            return $value;
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function filterNan($value) : ?float
    {
        if (( is_float($value) && is_nan($value) )) {
            return $value;
        }

        return null;
    }


    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public function filterNumber($value) // : ?null|int|float
    {
        $result = ( 0
            || ( null !== $this->filterInt($value) )
            || ( null !== $this->filterFloat($value) )
        );

        return $result
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterTheString($value) : ?string
    {
        return ( is_string($value) && ( '' !== $value ) )
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrNumber($value) // : ?null|int|float|string
    {
        return ( is_string($value)
            || ( null !== $this->filterNumber($value) )
        )
            ? $value
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public function filterTheStringOrNumber($value) // : ?null|int|float|string
    {
        $result = ( 0
            || ( null !== $this->filterTheString($value) )
            || ( null !== $this->filterNumber($value) )
        );

        return $result
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function filterIntable($value) : ?int
    {
        if (null !== $this->filterInt($value)) {
            return $value;
        }

        if (false !== ( $result = filter_var($value, FILTER_VALIDATE_INT) )) {
            return $result;
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function filterFloatable($value) : ?float
    {
        if (null !== $this->filterFloat($value)) {
            return $value;
        }

        if (false !== ( $result = filter_var($value, FILTER_VALIDATE_FLOAT) )) {
            return $result;
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function filterNumerable($value) // : ?int|float
    {
        if (null !== $this->filterNumber($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return null
                ?? $this->filterInt($value)
                ?? $this->filterFloat($value);
        }

        return null;
    }


    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterStringable($value) : ?string
    {
        if (is_null($value)) {
            return null; // becomes '' and causes data lost
        }

        if (is_bool($value)) {
            return null; // becomes '' on false and causes data lost
        }

        if (is_array($value)) {
            return null; // becomes 'Array' and causes data lost
        }

        if (null !== $this->filterStringOrNumber($value)) {
            return strval($value);
        }

        try {
            if (false === settype($value, 'string')) {
                return null; // __toString()
            }
        }
        catch ( \Throwable $e ) {
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
    public function filterTheStringable($value) : ?string
    {
        if (is_null($value)) {
            return null; // becomes '' and causes data lost
        }

        if (is_bool($value)) {
            return null; // becomes '' on false and causes data lost
        }

        if (is_array($value)) {
            return null; // becomes 'Array' and causes data lost
        }

        if (null !== $this->filterTheStringOrNumber($value)) {
            return strval($value);
        }

        if (false === settype($value, 'string')) {
            return null; // __toString()
        }

        $coalesce = strval($value);
        $result = '' !== $coalesce
            ? $coalesce
            : null;

        return $result;
    }


    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public function filterArrayable($value) : ?array
    {
        if (is_null($value)) {
            return [];

        } elseif (is_scalar($value)) {
            return [ $value ];

        } elseif (is_iterable($value)) {
            $result = [];

            foreach ( $value as $item ) {
                ( null === ( $key = $this->filterStringable($item) ) )
                    ? ( $result[ $key ] = $item )
                    : ( $result[] = $item );
            }

            return $result;

        } elseif (is_object($value)) {
            if (is_a($value, CanToArrayInterface::class)) {
                return $value->toArray();

            } else {
                // too slow
                // } elseif (method_exists($value, 'toArray')) {

                $result = null;

                try {
                    $result = $value->toArray();
                }
                catch ( \Throwable $e ) {
                }

                /** @noinspection PhpExpressionAlwaysNullInspection */
                return $result;
            }
        }

        return null;
    }


    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterArray($array, callable $of = null) : ?array
    {
        if (! is_array($array)) return null;
        if (! $array) return null;

        foreach ( $array as $key => &$val ) {
            if ($of && ! $of($val)) {
                return null;
            }
        }
        unset($val);

        return $array;
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterList($list, callable $of = null) : ?array
    {
        if (! is_iterable($list)) return null;
        if (! $list) return null; // empty array is a list

        // contains string key? not a list
        foreach ( $list as $key => &$val ) {
            if (! is_int($key)) {
                return null;
            }

            if ($of && ! $of($val)) {
                return null;
            }
        }
        unset($val);

        return $list;
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterDict($dict, callable $of = null) : ?array
    {
        if (! is_array($dict)) return null;
        if (! $dict) return null; // empty array is a dict

        foreach ( $dict as $key => &$val ) {
            if (null === $this->filterTheString($key)) {
                return null;
            }

            if ($of && ! $of($val)) {
                return null;
            }
        }
        unset($val);

        return $dict;
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterAssoc($assoc, callable $of = null) : ?array
    {
        if (! is_array($assoc)) return null;
        if (! $assoc) return null; // empty array is an assoc

        // contains simulateonsly string/int key? is an assoc
        $hasStr = false;
        $hasInt = false;
        foreach ( $assoc as $key => &$val ) {
            $hasInt = $hasInt || is_int($key);
            $hasStr = $hasStr || ( null !== $this->filterTheString($key) );

            if ($hasInt && $hasStr) {
                break;
            }
        }
        unset($val);

        if (! ( $hasInt && $hasStr )) {
            return null;
        }

        if ($of) {
            foreach ( $assoc as $key => &$val ) {
                if (! $of($val)) {
                    return null;
                }
            }
            unset($val);
        }

        return $assoc;
    }


    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public function filterCallable($callable, CallableInfo &$callableInfo = null) // : ?callable
    {
        if (0
            || ( null !== $this->filterClosure($callable, $callableInfo) )
            || ( null !== $this->filterCallableString($callable, $callableInfo) )
            || ( null !== $this->filterCallableArray($callable, $callableInfo) )
        ) {
            return $callable;
        }

        return null;
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public function filterCallableString($callable, CallableInfo &$callableInfo = null) // : ?callable
    {
        $callableInfo = $callableInfo ?? new CallableInfo();

        if (( null !== $this->filterTheString($callable) )
            && is_callable($callable)
        ) {
            $callableInfo->function = $callable;
            $callableInfo->callable = $callable;

            return $callable;
        }

        return null;
    }


    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public function filterCallableArray($callable, CallableInfo &$callableInfo = null) // : ?callable
    {
        if (is_array($callable)
            && ( 0
                || $this->filterCallableArrayStatic($callable, $callableInfo)
                || $this->filterCallableArrayPublic($callable, $callableInfo)
            )
        ) {
            return $callable;
        }

        return null;
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public function filterCallableArrayStatic($callable, CallableInfo &$callableInfo = null) // : ?callable
    {
        $callableInfo = $callableInfo ?? new CallableInfo();

        if (is_array($callable)
            && isset($callable[ 0 ]) && ( null !== $this->filterTheString($callable[ 0 ]) )
            && isset($callable[ 1 ]) && ( null !== $this->filterTheString($callable[ 1 ]) )
            && is_callable($callable)
        ) {
            $callableInfo->class = $callable[ 0 ];
            $callableInfo->method = $callable[ 1 ];
            $callableInfo->callable = $callable;

            return $callable;
        }

        return null;
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public function filterCallableArrayPublic($callable, CallableInfo &$callableInfo = null) // : ?callable
    {
        $callableInfo = $callableInfo ?? new CallableInfo();

        if (is_array($callable)
            && isset($callable[ 0 ]) && is_object($callable[ 0 ])
            && isset($callable[ 1 ]) && ( null !== $this->filterTheString($callable[ 1 ]) )
            && is_callable($callable)
        ) {
            $callableInfo->object = $callable[ 0 ];
            $callableInfo->class = get_class($callable[ 0 ]);
            $callableInfo->method = $callable[ 1 ];
            $callableInfo->callable = $callable;

            return $callable;
        }

        return null;
    }


    /**
     * @param mixed             $closure
     * @param null|CallableInfo $callableInfo
     *
     * @return null|\Closure
     */
    public function filterClosure($closure, CallableInfo &$callableInfo = null) : ?\Closure
    {
        $callableInfo = $callableInfo ?? new CallableInfo();

        if (is_object($closure) && ( get_class($closure) === \Closure::class )) {
            $callableInfo->closure = $closure;
            $callableInfo->class = \Closure::class;

            return $closure;
        }

        return null;
    }


    /**
     * @param mixed             $handler
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public function filterCallableHandler($handler, CallableInfo &$callableInfo = null) // : ?callable
    {
        $isHandler = ( null !== $this->filterTheString($handler) )
            && ( $handler[ 0 ] !== '@' )
            && ( 1 === substr_count($handler, '@') );

        if (! $isHandler) {
            return null;
        }

        $callable = explode('@', $handler, 2);

        if (null !== $this->filterCallableArrayStatic($callable, $callableInfo)) {
            return $callable;
        }

        return null;
    }


    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public function filterClass($class) : ?string
    {
        return ( ( null !== $this->filterTheString($class) )
            && class_exists($class)
        )
            ? $class
            : null;
    }


    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public function filterValidClass($class) : ?string
    {
        if (null === $this->filterTheString($class)) {
            return null;
        }

        foreach ( explode('\\', $class) as $part ) {
            if (! $result = $this->filterValidClassName($part)) {
                return null;
            }
        }

        return $class;
    }

    /**
     * @param mixed $className
     *
     * @return null|string
     */
    public function filterValidClassName($className) : ?string
    {
        if (( null !== $this->filterTheString($className) )
            && ( false !== preg_match('~^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$~', $className) )
        ) {
            return $className;
        }

        return null;
    }


    /**
     * @param \ReflectionClass  $reflectionClass
     * @param string|null      &$class
     *
     * @return null|\ReflectionClass
     */
    public function filterReflectionClass($reflectionClass, string &$class = null) : ?\ReflectionClass
    {
        if (is_object($reflectionClass) && is_a($reflectionClass, \ReflectionClass::class)) {
            $class = $reflectionClass->getName();

            return $reflectionClass;
        }

        return null;
    }


    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterLink($value) : ?string
    {
        return ( is_string($value)
            && ( false !== parse_url($value) )
        )
            ? $value
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterUrl($value) : ?string
    {
        return ( is_string($value)
            && ( false !== filter_var($value, FILTER_VALIDATE_URL) )
            && ( false !== parse_url($value) )
        )
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterFileInfo($value) : ?\SplFileInfo
    {
        return ( is_object($value) && is_a($value, \SplFileInfo::class) )
            ? $value
            : null;
    }


    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public function filterOpenedResource($h) // : ?resource
    {
        return ( is_resource($h) && 'resource (closed)' !== gettype($h) )
            ? $h
            : null;
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public function filterClosedResource($h) // : ?resource
    {
        return ( is_resource($h) && 'resource (closed)' === gettype($h) )
            ? $h
            : null;
    }
}
