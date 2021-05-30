<?php /** @noinspection PhpUnusedAliasInspection */

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Filter\Type;
use Gzhegow\Support\Domain\Filter\Assert;
use Gzhegow\Support\Domain\Filter\InvokableInfoVO;
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
     * Constructor
     */
    public function __construct()
    {
        $this->assert = new Assert($this);
        $this->type = new Type($this);
    }


    /**
     * @return callable[]
     */
    public function getCustomFilters() : array
    {
        return static::$customFilters;
    }


    /**
     * @param int|mixed $value
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
     * @param float|mixed $value
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
     * @param float|mixed $value
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
     * @param int|float|mixed $value
     *
     * @return null|int|float
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
     * @param int|string|mixed $value
     *
     * @return null|int|string
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
     * @param float|string|mixed $value
     *
     * @return null|float|string
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
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
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
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterString($value) : ?string
    {
        $result = is_string($value)
            ? $value
            : null;

        return $result;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterWord($value) : ?string
    {
        $result = ( is_string($value) && ( '' !== $value ) )
            ? $value
            : null;

        return $result;
    }


    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrInt($value) // : ?null|int|float|string
    {
        $result = ( is_string($value)
            || ( null !== $this->filterInt($value) )
        )
            ? $value
            : null;

        return $result;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrInt($value) // : ?null|int|float|string
    {
        $result = ( 0
            || ( null !== $this->filterWord($value) )
            || ( null !== $this->filterInt($value) )
        );

        return $result
            ? $value
            : null;
    }


    /**
     * @param int|float|string|mixed $value
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
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrNumber($value) // : ?null|int|float|string
    {
        $result = ( 0
            || ( null !== $this->filterWord($value) )
            || ( null !== $this->filterNumber($value) )
        );

        return $result
            ? $value
            : null;
    }


    /**
     * @param string|mixed $value
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
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterWordval($value) : ?string
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
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterKey($value) // : ?int|string
    {
        if (null === $this->filterStringOrInt($value)) {
            return null;
        }

        return $value;
    }


    /**
     * @param array|mixed   $array
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
     * @param array|mixed   $list
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
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterDict($dict, callable $of = null) : ?array
    {
        if (! is_array($dict)) return null;
        if (! $dict) return null; // empty array is a dict

        foreach ( $dict as $key => &$val ) {
            if (null === $this->filterWord($key)) {
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
     * @param array|mixed   $assoc
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
            $hasStr = $hasStr || ( null !== $this->filterWord($key) );

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
     * @param array|mixed $array
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
     * @return null|mixed
     */
    public function filterArrval($value) // : ?mixed
    {
        if (is_array($value)
            || is_null($value)
            || is_scalar($value)
            || is_iterable($value)
        ) {
            return $value;

        } elseif (is_object($value)) {
            $result = null;
            try {
                $result = $value->toArray();
            }
            catch ( \Throwable $e ) {
            }

            return null !== $result
                ? $value
                : null;
        }

        return null;
    }


    /**
     * @param string|mixed $value
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
     * @param string|mixed $value
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
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfoVO                 $invokableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public function filterCallable($callable, InvokableInfoVO &$invokableInfo = null) // : ?string|array|\Closure
    {
        if (0
            || ( null !== $this->filterClosure($callable, $invokableInfo) )
            || ( null !== $this->filterCallableString($callable, $invokableInfo) )
            || ( null !== $this->filterCallableArray($callable, $invokableInfo) )
        ) {
            return $callable;
        }

        return null;
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfoVO        $invokableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableString($callableString, InvokableInfoVO &$invokableInfo = null) // : ?string|array
    {
        if (! is_array($callableString)
            && ( 0
                || ( null !== $this->filterCallableStringFunction($callableString, $invokableInfo) )
                || ( null !== $this->filterCallableStringStatic($callableString, $invokableInfo) )
            )
        ) {
            return $callableString;
        }

        return null;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfoVO  $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringFunction($callableString, InvokableInfoVO &$invokableInfo = null) : ?string
    {
        $invokableInfo = $invokableInfo ?? new InvokableInfoVO();

        if (( null !== $this->filterWord($callableString) )
            && function_exists($callableString)
        ) {
            $invokableInfo->function = $callableString;
            $invokableInfo->callable = $callableString;

            return $callableString;
        }

        return null;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfoVO  $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringStatic($callableString, InvokableInfoVO &$invokableInfo = null) : ?string
    {
        if (! $isCallable = ( null !== $this->filterWord($callableString) )
            && ( 1 === substr_count($callableString, '::') )
        ) {
            return null;
        }

        $callable = explode('::', $callableString, 2);

        if (null !== $this->filterCallableArrayStatic($callable, $invokableInfo)) {
            return $callableString;
        }

        return null;
    }


    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArray($callableArray, InvokableInfoVO &$invokableInfo = null) : ?array
    {
        if (is_array($callableArray)
            && ( 0
                || $this->filterCallableArrayStatic($callableArray, $invokableInfo)
                || $this->filterCallableArrayPublic($callableArray, $invokableInfo)
            )
        ) {
            return $callableArray;
        }

        return null;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayStatic($callableArray, InvokableInfoVO &$invokableInfo = null) : ?array
    {
        $invokableInfo = $invokableInfo ?? new InvokableInfoVO();

        if (is_array($callableArray)
            && isset($callableArray[ 0 ]) && ( null !== $this->filterWord($callableArray[ 0 ]) )
            && isset($callableArray[ 1 ]) && ( null !== $this->filterWord($callableArray[ 1 ]) )
            && is_callable($callableArray)
        ) {
            $invokableInfo->class = $callableArray[ 0 ];
            $invokableInfo->method = $callableArray[ 1 ];
            $invokableInfo->callable = $callableArray;

            return $callableArray;
        }

        return null;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayPublic($callableArray, InvokableInfoVO &$invokableInfo = null) : ?array
    {
        $invokableInfo = $invokableInfo ?? new InvokableInfoVO();

        if (is_array($callableArray)
            && isset($callableArray[ 0 ]) && is_object($callableArray[ 0 ])
            && isset($callableArray[ 1 ]) && ( null !== $this->filterWord($callableArray[ 1 ]) )
            && is_callable($callableArray)
        ) {
            $invokableInfo->object = $callableArray[ 0 ];
            $invokableInfo->class = get_class($callableArray[ 0 ]);
            $invokableInfo->method = $callableArray[ 1 ];
            $invokableInfo->callable = $callableArray;

            return $callableArray;
        }

        return null;
    }


    /**
     * @param \Closure|mixed       $closure
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterClosure($closure, InvokableInfoVO &$invokableInfo = null) : ?\Closure
    {
        $invokableInfo = $invokableInfo ?? new InvokableInfoVO();

        if (is_object($closure) && ( get_class($closure) === \Closure::class )) {
            $invokableInfo->closure = $closure;
            $invokableInfo->class = \Closure::class;

            return $closure;
        }

        return null;
    }


    /**
     * @param array|mixed $methodArray
     *
     * @return null|array
     */
    public function filterMethodArray($methodArray) : ?array
    {
        if (is_array($methodArray)
            && isset($methodArray[ 0 ])
            && isset($methodArray[ 1 ]) && ( null !== $this->filterWord($methodArray[ 1 ]) )
        ) {
            $isObject = is_object($methodArray[ 0 ]);
            $isClass = ! $isObject
                && ( null !== $this->filterWord($methodArray[ 0 ]) )
                && class_exists($methodArray[ 0 ]);

            if (! $isObject && ! $isClass) {
                return null;
            }

            return $methodArray;
        }

        return null;
    }

    /**
     * @param array|mixed          $methodArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return null|array
     */
    public function filterMethodArrayReflection($methodArray, InvokableInfoVO &$invokableInfo = null) : ?array
    {
        [ $objectOrClass, $method ] = $this->filterMethodArray($methodArray);

        try {
            $rm = new \ReflectionMethod($objectOrClass, $method);

            $invokableInfo = $invokableInfo ?? new InvokableInfoVO();
            $invokableInfo->method = $rm->getName();

            if (is_object($objectOrClass)) {
                $invokableInfo->object = $objectOrClass;
                $invokableInfo->class = get_class($objectOrClass);

            } elseif ($objectOrClass) {
                $invokableInfo->class = $objectOrClass;
            }
        }
        catch ( \ReflectionException $e ) {
            return null;
        }

        return $methodArray;
    }


    /**
     * @param string|mixed         $handler
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterHandler($handler, InvokableInfoVO &$invokableInfo = null) : ?string
    {
        if (! $isCallable = ( null !== $this->filterWord($handler) )
            && ( 1 === substr_count($handler, '@') )
        ) {
            return null;
        }

        [ $class, $method ] = explode('@', $handler, 2);

        try {
            $rm = new \ReflectionMethod($class, $method);

            $invokableInfo = $invokableInfo ?? new InvokableInfoVO();
            $invokableInfo->class = $class;
            $invokableInfo->method = $method;

            if (! $rm->isPublic() || $rm->isStatic() || $rm->isAbstract()) {
                return null;
            }

            return $handler;
        }
        catch ( \ReflectionException $e ) {
        }

        return null;
    }


    /**
     * @param string|mixed $class
     *
     * @return null|string
     */
    public function filterClass($class) : ?string
    {
        if (null === $this->filterWord($class)) {
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
     * @param string|mixed $className
     *
     * @return null|string
     */
    public function filterClassName($className) : ?string
    {
        if (null === $this->filterWord($className)) {
            return null;
        }

        if (false !== preg_match('~^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$~', $className)) {
            return $className;
        }

        return null;
    }


    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterStdClass($value) // : ?object
    {
        return ( is_object($value)
            && $value instanceof \StdClass
        )
            ? $value
            : null;
    }


    /**
     * @param \SplFileInfo|mixed $value
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
     * @param \SplFileObject|mixed $value
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
     * @param \ReflectionClass|mixed $value
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
     * @param \ReflectionFunction|mixed $value
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
     * @param \ReflectionMethod|mixed $value
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
     * @param \ReflectionProperty|mixed $value
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
     * @param \ReflectionParameter|mixed $value
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
     * @param \ReflectionType|mixed $value
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
     * @param resource|mixed $h
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
     * @param resource|mixed $h
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
     * @param resource|mixed $h
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
     * @param resource|mixed $h
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
     * @param resource|mixed $h
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
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return Assert
     */
    public function assert($message = null, ...$arguments) : Assert
    {
        if (null !== $message) {
            $this->assert->message($message, ...$arguments);
        }

        return $this->assert;
    }

    /**
     * @return Type
     */
    public function type() : Type
    {
        return $this->type;
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
