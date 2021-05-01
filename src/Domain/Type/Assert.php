<?php

namespace Gzhegow\Support\Domain\Type;

use Gzhegow\Support\Domain\Type\Interfaces\CanToArrayInterface;


/**
 * Assert
 */
class Assert
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isEmpty($value) : bool
    {
        if (is_object($value) && is_countable($value)) {
            return ! count($value);
        }

        if (false === $value) {
            return false;
        }

        return empty($value);
    }


    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public function isKey($value) // : ?int|string
    {
        // \Generator can pass any object as foreach key, so this check is recommended

        return ( is_int($value) || is_string($value) )
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function isInt($value) : ?int
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
    public function isFloat($value) : ?float
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
    public function isNan($value) : ?float
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
    public function isNumber($value) // : ?null|int|float
    {
        return ( $this->isInt($value) || $this->isFloat($value) )
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function isTheString($value) : ?string
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
    public function isStringOrNumber($value) // : ?null|int|float|string
    {
        return ( is_string($value) || $this->isNumber($value) )
            ? $value
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public function isTheStringOrNumber($value) // : ?null|int|float|string
    {
        return ( $this->isTheString($value) || $this->isNumber($value) )
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function isIntable($value) : ?int
    {
        if ($this->isInt($value)) {
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
    public function isFloatable($value) : ?float
    {
        if ($this->isFloat($value)) {
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
    public function isNumerable($value) // : ?int|float
    {
        if ($this->isNumber($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return null
                ?? $this->isInt($value)
                ?? $this->isFloat($value);
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function isStringable($value) : ?string
    {
        if (is_array($value)) {
            return null;
        }

        if ($this->isStringOrNumber($value)) {
            return strval($value);
        }

        if (false === settype($value, 'string')) {
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
    public function isArrayable($value) : ?array
    {
        if (is_null($value)) {
            return [];

        } elseif (is_scalar($value)) {
            return [ $value ];

        } elseif (is_iterable($value)) {
            $result = [];

            foreach ( $value as $item ) {
                $key = $this->isStringable($item);

                ( null === $key )
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
    public function isArray($array, callable $of = null) : ?array
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
    public function isList($list, callable $of = null) : ?array
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
    public function isDict($dict, callable $of = null) : ?array
    {
        if (! is_array($dict)) return null;
        if (! $dict) return null; // empty array is a dict

        foreach ( $dict as $key => &$val ) {
            if (! $this->isTheString($key)) {
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
    public function isAssoc($assoc, callable $of = null) : ?array
    {
        if (! is_array($assoc)) return null;
        if (! $assoc) return null; // empty array is an assoc

        // contains simulateonsly string/int key? is an assoc
        $hasStr = false;
        $hasInt = false;
        foreach ( $assoc as $key => &$val ) {
            $hasInt = $hasInt || is_int($key);
            $hasStr = $hasStr || $this->isTheString($key);

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
    public function isCallable($callable, CallableInfo $callableInfo = null) // : ?callable
    {
        if (0
            || ( $this->isClosure($callable, $callableInfo) )
            || ( $this->isCallableString($callable, $callableInfo) )
            || ( $this->isCallableArray($callable, $callableInfo) )
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
    public function isCallableString($callable, CallableInfo $callableInfo = null) // : ?callable
    {
        if ($this->isTheString($callable) && is_callable($callable)) {
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
    public function isCallableArray($callable, CallableInfo $callableInfo = null) // : ?callable
    {
        if (is_array($callable)
            && ( 0
                || $this->isCallableArrayStatic($callable, $callableInfo)
                || $this->isCallableArrayPublic($callable, $callableInfo)
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
    public function isCallableArrayStatic($callable, CallableInfo $callableInfo = null) // : ?callable
    {
        if (is_array($callable)
            && isset($callable[ 0 ]) && $this->isTheString($callable[ 0 ])
            && isset($callable[ 1 ]) && $this->isTheString($callable[ 1 ])
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
    public function isCallableArrayPublic($callable, CallableInfo $callableInfo = null) // : ?callable
    {
        if (is_array($callable)
            && isset($callable[ 0 ]) && is_object($callable[ 0 ])
            && isset($callable[ 1 ]) && $this->isTheString($callable[ 1 ])
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
    public function isClosure($closure, CallableInfo $callableInfo = null) : ?\Closure
    {
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
    public function isCallableHandler($handler, CallableInfo $callableInfo = null) // : ?callable
    {
        $isHandler = $this->isTheString($handler)
            && ( $handler[ 0 ] !== '@' )
            && ( 1 === substr_count($handler, '@') );

        if (! $isHandler) {
            return null;
        }

        $callable = explode('@', $handler, 2);

        if ($this->isCallableArrayStatic($callable, $callableInfo)) {
            return $callable;
        }

        return null;
    }


    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public function isClass($class) : ?string
    {
        return ( is_string($class) && class_exists($class) )
            ? $class
            : null;
    }


    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public function isValidClass($class) : ?string
    {
        if (! is_string($class)) return null;
        if ('' === $class) return null;

        foreach ( explode('\\', $class) as $part ) {
            if (! $result = $this->isValidClassName($part)) {
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
    public function isValidClassName($className) : ?string
    {
        if (is_string($className)
            && ( '' !== $className )
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
    public function isReflectionClass($reflectionClass, string &$class = null) : ?\ReflectionClass
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
     * @return null|\SplFileInfo
     */
    public function isFileInfo($value) : ?\SplFileInfo
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
    public function isOpenedResource($h) // : ?resource
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
    public function isClosedResource($h) // : ?resource
    {
        return ( is_resource($h) && 'resource (closed)' === gettype($h) )
            ? $h
            : null;
    }
}
