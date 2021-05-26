<?php /** @noinspection PhpUnusedAliasInspection */

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Filter\CallableInfo;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;


/**
 * Filter
 */
class Filter
{
    /**
     * @var Assert
     */
    protected $assert;

    /**
     * @var Type
     */
    protected $type;


    /**
     * @return callable[]
     */
    public function getCustomFilters() : array
    {
        return static::$customFilters;
    }


    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public function filterKey($value) // : ?int|string
    {
        // \Generator can pass any object as foreach key, so this check is recommended

        if (null === $this->filterStringOrNumber($value)) {
            return null;
        }

        return $value;
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
        )
            ? $value
            : null;

        return $result;
    }


    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterTheString($value) : ?string
    {
        $result = ( is_string($value) && ( '' !== $value ) )
            ? $value
            : null;

        return $result;
    }


    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrNumber($value) // : ?null|int|float|string
    {
        $result = ( is_string($value)
            || ( null !== $this->filterNumber($value) )
        )
            ? $value
            : null;

        return $result;
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
     * @param mixed $array
     *
     * @return null|array
     */
    public function filterPlainArray($array) : ?array
    {
        if (! is_array($array)) {
            return null;
        }

        $queue = [ $array ];
        while ( null !== key($queue) ) {
            $current = array_shift($queue);

            if (is_array($current) && [] !== $current) {
                foreach ( $current as $value ) {
                    $queue[] = $value;
                }

            } else {
                if ([] === $current
                    || is_null($current)
                    || is_scalar($current)
                ) {
                    continue;
                }

                return null;
            }
        }

        return $array;
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
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public function filterCallable($callable, CallableInfo &$callableInfo = null) // : ?string|array|\Closure
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
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableString($callableString, CallableInfo &$callableInfo = null) // : ?string|array
    {
        if (! is_array($callableString)
            && ( 0
                || ( null !== $this->filterCallableStringFunction($callableString, $callableInfo) )
                || ( null !== $this->filterCallableStringStatic($callableString, $callableInfo) )
            )
        ) {
            return $callableString;
        }

        return null;
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringFunction($callableString, CallableInfo &$callableInfo = null) : ?string
    {
        $callableInfo = $callableInfo ?? new CallableInfo();

        if (( null !== $this->filterTheString($callableString) )
            && function_exists($callableString)
        ) {
            $callableInfo->function = $callableString;
            $callableInfo->callable = $callableString;

            return $callableString;
        }

        return null;
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringStatic($callableString, CallableInfo &$callableInfo = null) : ?string
    {
        if (! $isCallable = ( null !== $this->filterTheString($callableString) )
            && ( 1 === substr_count($callableString, '::') )
        ) {
            return null;
        }

        $callable = explode('::', $callableString, 2);

        if (null !== $this->filterCallableArrayStatic($callable, $callableInfo)) {
            return $callable;
        }

        return null;
    }


    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArray($callableArray, CallableInfo &$callableInfo = null) : ?array
    {
        if (is_array($callableArray)
            && ( 0
                || $this->filterCallableArrayStatic($callableArray, $callableInfo)
                || $this->filterCallableArrayPublic($callableArray, $callableInfo)
            )
        ) {
            return $callableArray;
        }

        return null;
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayStatic($callableArray, CallableInfo &$callableInfo = null) : ?array
    {
        $callableInfo = $callableInfo ?? new CallableInfo();

        if (is_array($callableArray)
            && isset($callableArray[ 0 ]) && ( null !== $this->filterTheString($callableArray[ 0 ]) )
            && isset($callableArray[ 1 ]) && ( null !== $this->filterTheString($callableArray[ 1 ]) )
            && is_callable($callableArray)
        ) {
            $callableInfo->class = $callableArray[ 0 ];
            $callableInfo->method = $callableArray[ 1 ];
            $callableInfo->callable = $callableArray;

            return $callableArray;
        }

        return null;
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayPublic($callableArray, CallableInfo &$callableInfo = null) : ?array
    {
        $callableInfo = $callableInfo ?? new CallableInfo();

        if (is_array($callableArray)
            && isset($callableArray[ 0 ]) && is_object($callableArray[ 0 ])
            && isset($callableArray[ 1 ]) && ( null !== $this->filterTheString($callableArray[ 1 ]) )
            && is_callable($callableArray)
        ) {
            $callableInfo->object = $callableArray[ 0 ];
            $callableInfo->class = get_class($callableArray[ 0 ]);
            $callableInfo->method = $callableArray[ 1 ];
            $callableInfo->callable = $callableArray;

            return $callableArray;
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
     * @param mixed $class
     *
     * @return null|string
     */
    public function filterClass($class) : ?string
    {
        if (null === $this->filterTheString($class)) {
            return null;
        }

        $validate = preg_replace('~[a-zA-Z0-9_\x80-\xff]*~', '', $class);

        $letters = '' !== $validate
            ? str_split($validate)
            : [];

        foreach ( $letters as $letter ) {
            if ($letter !== '\\') {
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
    public function filterClassName($className) : ?string
    {
        if (null === $this->filterTheString($className)) {
            return null;
        }

        if (false !== preg_match('~^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$~', $className)) {
            return $className;
        }

        return null;
    }


    /**
     * @param object $value
     *
     * @return null|object
     */
    public function filterStdClass($value) // : ?object
    {
        return ( is_object($value) && $value instanceof \StdClass )
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
     * @param mixed $value
     *
     * @return null|\SplFileObject
     */
    public function filterFileObject($value) : ?\SplFileObject
    {
        return ( is_object($value) && is_a($value, \SplFileObject::class) )
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|\ReflectionClass
     */
    public function filterReflectionClass($value) : ?\ReflectionClass
    {
        return ( is_object($value) && is_a($value, \ReflectionClass::class) )
            ? $value
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionFunction
     */
    public function filterReflectionFunction($value) : ?\ReflectionFunction
    {
        return ( is_object($value) && is_a($value, \ReflectionFunction::class) )
            ? $value
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionMethod
     */
    public function filterReflectionMethod($value) : ?\ReflectionMethod
    {
        return ( is_object($value) && is_a($value, \ReflectionMethod::class) )
            ? $value
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionProperty
     */
    public function filterReflectionProperty($value) : ?\ReflectionProperty
    {
        return ( is_object($value) && is_a($value, \ReflectionProperty::class) )
            ? $value
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionParameter
     */
    public function filterReflectionParameter($value) : ?\ReflectionParameter
    {
        return ( is_object($value) && is_a($value, \ReflectionParameter::class) )
            ? $value
            : null;
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionType
     */
    public function filterReflectionType($value) : ?\ReflectionType
    {
        return ( is_object($value) && is_a($value, \ReflectionType::class) )
            ? $value
            : null;
    }


    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public function filterResource($h) // : ?resource
    {
        return ( is_resource($h) || 'resource (closed)' === gettype($h) )
            ? $h
            : null;
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public function filterOpenedResource($h) // : ?resource
    {
        return is_resource($h)
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
        return ( 'resource (closed)' === gettype($h) )
            ? $h
            : null;
    }


    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public function filterReadableResource($h) // : ?resource
    {
        if (null === $this->filterOpenedResource($h)) {
            return null;
        }

        $meta = stream_get_meta_data($h);
        if (false === strpos($meta[ 'mode' ], 'r')) {
            return null;
        }

        if (feof($h)) {
            return null;
        }

        return $h;
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public function filterWritableResource($h) // : ?resource
    {
        if (null === $this->filterOpenedResource($h)) {
            return null;
        }

        $meta = stream_get_meta_data($h);
        if (false === strpos($meta[ 'mode' ], 'w')) {
            return null;
        }

        return $h;
    }


    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function filterIntval($value) : ?int
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
    public function filterFloatval($value) : ?float
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
    public function filterNumval($value) // : ?int|float
    {
        if (null !== $this->filterNumber($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return null
                ?? $this->filterIntval($value)
                ?? $this->filterFloatval($value);
        }

        return null;
    }


    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterStrval($value) : ?string
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
            return $value;
        }

        try {
            if (false === settype($value, 'string')) {
                return null; // __toString()
            }
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterTheStrval($value) : ?string
    {
        if ('' === $value) {
            return null;
        }

        if (null === $this->filterStrval($value)) {
            return null;
        }

        return $value;
    }


    /**
     * @param string   $filter
     * @param \Closure $callable
     *
     * @return static
     */
    public function addCustomFilter(string $filter, \Closure $callable)
    {
        if (null !== $this->findCustomFilter($filter)) {
            throw new UnderflowException('FilterService is already defined: ' . $filter);
        }

        $filterLower = strtolower($filter);

        static::$customFilters[ $filterLower ] = $callable;

        return $this;
    }


    /**
     * @return Filter
     */
    public function filter() : Filter
    {
        return $this;
    }

    /**
     * @return Assert
     */
    public function assert() : Assert
    {
        return $this->assert = $this->assert
            ?? new Assert($this);
    }

    /**
     * @return Type
     */
    public function type() : Type
    {
        return $this->type = $this->type
            ?? new Type($this);
    }


    /**
     * @param string $customFilter
     * @param mixed  ...$arguments
     *
     * @return null|mixed
     */
    public function call(string $customFilter, ...$arguments) // : ?mixed
    {
        if (null === ( $filterCallable = $this->findCustomFilter($customFilter) )) {
            throw new UnderflowException('Filter not defined: ' . $customFilter);
        }

        $filtered = call_user_func_array($filterCallable, $arguments);

        return $filtered;
    }

    /**
     * @param string $filter
     * @param mixed  ...$arguments
     *
     * @return \Closure
     */
    public function bind(string $filter, ...$arguments) : \Closure
    {
        if (null === ( $filterCallable = $this->findCustomFilter($filter) )) {
            throw new UnderflowException('Filter not defined: ' . $filter);
        }

        $closure = function (...$args) use ($filterCallable, $arguments) {
            $bind = array_replace(
                $arguments,
                array_slice($args, 0, count($arguments))
            );

            return call_user_func_array($arguments, $bind);
        };

        return $closure;
    }


    /**
     * @param string   $filter
     * @param \Closure $callable
     *
     * @return static
     */
    public function replaceCustomFilter(string $filter, \Closure $callable)
    {
        if (null === $this->findCustomFilter($filter)) {
            throw new UnderflowException('FilterService is not defined: ' . $filter);
        }

        $filterLower = strtolower($filter);

        static::$customFilters[ $filterLower ] = $callable;

        return $this;
    }

    /**
     * @param string $filter
     *
     * @return null|\Closure
     */
    public function findCustomFilter(string $filter) : ?\Closure
    {
        $filterLower = strtolower($filter);

        return isset(static::$customFilters[ $filterLower ])
            ? static::$customFilters[ $filterLower ]
            : null;
    }


    /**
     * @var callable[]
     */
    protected static $customFilters = [];
}
