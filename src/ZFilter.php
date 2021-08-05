<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo;


/**
 * ZFilter
 */
class ZFilter implements IFilter
{
    /**
     * @var ZAssert
     */
    protected $assert;
    /**
     * @var ZType
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
     * @param bool|mixed $value
     *
     * @return null|bool
     */
    public function filterBool($value) : ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        return null;
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
        if (is_float($value) && ! is_nan($value)) {
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
        if (is_float($value) && is_nan($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function filterNum($value) // : ?null|int|float
    {
        if (is_int($value)
            || ( is_float($value) && ! is_nan($value) )
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterIntval($value) : ?int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_float($value)) {
            return intval($value) == $value
                ? $value
                : null;
        }

        if (false !== filter_var($value, FILTER_VALIDATE_INT)) {
            return $value;
        }

        if (false !== filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return intval($value) == $value
                ? $value
                : null;
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
        if (is_float($value) && ! is_nan($value)) {
            return $value;
        }

        if (is_int($value)) {
            return floatval($value) == $value
                ? $value
                : null;
        }

        if (false !== filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return is_nan($value)
                ? null
                : $value;
        }

        if (false !== filter_var($value, FILTER_VALIDATE_INT)) {
            return floatval($value) == $value
                ? $value
                : null;
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
        if (null !== $this->filterNum($value)) {
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
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumericval($value) // : ?int|float|string
    {
        if (null !== $this->filterNum($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterPositiveVal($value) // : ?int|float
    {
        if (null === $this->filterNumval($value)) {
            return null;
        }

        if ($value > 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNonNegativeVal($value) // : ?int|float
    {
        if (null === $this->filterNumval($value)) {
            return null;
        }

        if ($value >= 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNegativeVal($value) // : ?int|float
    {
        if (null === $this->filterNumval($value)) {
            return null;
        }

        if ($value < 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNonPositiveVal($value) // : ?int|float
    {
        if (null === $this->filterNumval($value)) {
            return null;
        }

        if ($value <= 0) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function filterPositiveIntval($value) : ?int
    {
        if (null === $this->filterIntval($value)) {
            return null;
        }

        if ($value > 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function filterNonNegativeIntval($value) : ?int
    {
        if (null === $this->filterIntval($value)) {
            return null;
        }

        if ($value >= 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function filterNegativeIntval($value) : ?int
    {
        if (null === $this->filterIntval($value)) {
            return null;
        }

        if ($value < 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function filterNonPositiveIntval($value) : ?int
    {
        if (null === $this->filterIntval($value)) {
            return null;
        }

        if ($value <= 0) {
            return $value;
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
        if (is_string($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLetter($value) : ?string
    {
        if (is_string($value) && ( mb_strlen($value) === 1 )) {
            return $value;
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterWord($value) : ?string
    {
        if (is_string($value) && ( '' !== $value )) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrInt($value) // : ?null|int|float|string
    {
        if (is_string($value) || is_int($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrInt($value) // : ?null|int|float|string
    {
        if (( is_string($value) && ( '' !== $value ) )
            || is_int($value)
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrNum($value) // : ?null|int|float|string
    {
        if (is_string($value)
            || ( null !== $this->filterNum($value) )
        ) {
            return $value;
        }

        return null;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrNum($value) // : ?null|int|float|string
    {
        if (( is_string($value) && ( '' !== $value ) )
            || ( null !== $this->filterNum($value) )
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterStrval($value) : ?string
    {
        if (null !== $this->filterStringOrNum($value)) {
            return $value;
        }

        if (is_object($value)) {
            try {
                if (false !== settype($value, 'string')) {
                    return $value; // __toString()
                }
            }
            catch ( \Throwable $e ) {
            }
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLetterval($value) : ?string
    {
        if (null === $this->filterStrval($value)) {
            return null;
        }

        if (mb_strlen(strval($value)) !== 1) {
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

        } elseif (null !== $this->filterStrval($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterTrimval($value) : ?string
    {
        if ('' === $value) {
            return null;

        } elseif (null === $this->filterStrval($value)) {
            return null;
        }

        if ('' === trim($value)) {
            return null;
        }

        return $value;
    }


    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterUtf8($value) : ?string
    {
        if (! is_string($value)) {
            return null;

        } elseif ('' === $value) {
            return null;
        }

        for ( $i = 0; $i < strlen($value); $i++ ) {
            if (ord($value[ $i ]) < 0x80) {
                continue; // 0bbbbbbb
            }

            if (( ord($value[ $i ]) & 0xE0 ) === 0xC0) {
                $n = 1; // 110bbbbb
            } elseif (( ord($value[ $i ]) & 0xF0 ) === 0xE0) {
                $n = 2; // 1110bbbb
            } elseif (( ord($value[ $i ]) & 0xF8 ) === 0xF0) {
                $n = 3; // 11110bbb
            } elseif (( ord($value[ $i ]) & 0xFC ) === 0xF8) {
                $n = 4; // 111110bb
            } elseif (( ord($value[ $i ]) & 0xFE ) === 0xFC) {
                $n = 5; // 1111110b
            } else {
                return null; // Does not match any model
            }

            for ( $j = 0; $j < $n; $j++ ) { // n bytes matching 10bbbbbb follow ?
                if (++$i === strlen($value) || ( ( ord($value[ $i ]) & 0xC0 ) !== 0x80 )) {
                    return null;
                }
            }
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
        if (null !== $this->filterStringOrInt($value)) {
            return $value;
        }

        return null;
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
        if (! $array) return $array;

        foreach ( $array as &$val ) {
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
        if (! $list) return $list; // empty array is a list

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
        if (! $dict) return $dict; // empty array is a dict

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
        if (! $assoc) return $assoc; // empty array is an assoc

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
            foreach ( $assoc as &$val ) {
                if (! $of($val)) {
                    return null;
                }
            }
            unset($val);
        }

        return $assoc;
    }


    /**
     * Array that contains array
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public function filterDeepArray($array) : ?array
    {
        if (! is_array($array)) {
            return null;
        }

        $queue = $array;

        while ( null !== key($queue) ) {
            $current = array_shift($queue);

            if (is_array($current)) {
                return $array;
            }
        }

        return null;
    }

    /**
     * Array that can be safely serialized
     *
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
        if (is_string($value)
            && ( false !== parse_url($value) )
        ) {
            return $value;
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterUrl($value) : ?string
    {
        if (is_string($value)
            && ( false !== filter_var($value, FILTER_VALIDATE_URL) )
            && ( false !== parse_url($value) )
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfo                   $invokableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public function filterCallable($callable, InvokableInfo &$invokableInfo = null) // : ?string|array|\Closure
    {
        if (( null !== $this->filterClosure($callable, $invokableInfo) )
            || ( null !== $this->filterCallableString($callable, $invokableInfo) )
            || ( null !== $this->filterCallableArray($callable, $invokableInfo) )
        ) {
            return $callable;
        }

        return null;
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfo          $invokableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableString($callableString, InvokableInfo &$invokableInfo = null) // : ?string|array
    {
        if (! is_array($callableString)
            && ( ( null !== $this->filterCallableStringFunction($callableString, $invokableInfo) )
                || ( null !== $this->filterCallableStringStatic($callableString, $invokableInfo) )
            )
        ) {
            return $callableString;
        }

        return null;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringFunction($callableString, InvokableInfo &$invokableInfo = null) : ?string
    {
        $invokableInfo = $invokableInfo ?? new InvokableInfo();

        if (( null !== $this->filterWord($callableString) )
            && function_exists($callableString)
        ) {
            $invokableInfo->setFunction($callableString);
            $invokableInfo->setCallable($callableString);

            return $callableString;
        }

        return null;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringStatic($callableString, InvokableInfo &$invokableInfo = null) : ?string
    {
        if (! ( null !== $this->filterWord($callableString) )
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
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArray($callableArray, InvokableInfo &$invokableInfo = null) : ?array
    {
        if (is_array($callableArray)
            && ( $this->filterCallableArrayStatic($callableArray, $invokableInfo)
                || $this->filterCallableArrayPublic($callableArray, $invokableInfo)
            )
        ) {
            return $callableArray;
        }

        return null;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayStatic($callableArray, InvokableInfo &$invokableInfo = null) : ?array
    {
        $invokableInfo = $invokableInfo ?? new InvokableInfo();

        if (is_array($callableArray)
            && isset($callableArray[ 0 ]) && ( null !== $this->filterWord($callableArray[ 0 ]) )
            && isset($callableArray[ 1 ]) && ( null !== $this->filterWord($callableArray[ 1 ]) )
            && is_callable($callableArray)
        ) {
            $invokableInfo->setClass($callableArray[ 0 ]);
            $invokableInfo->setMethod($callableArray[ 1 ]);
            $invokableInfo->setCallable($callableArray);

            return $callableArray;
        }

        return null;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayPublic($callableArray, InvokableInfo &$invokableInfo = null) : ?array
    {
        $invokableInfo = $invokableInfo ?? new InvokableInfo();

        if (is_array($callableArray)
            && isset($callableArray[ 0 ]) && is_object($callableArray[ 0 ])
            && isset($callableArray[ 1 ]) && ( null !== $this->filterWord($callableArray[ 1 ]) )
            && is_callable($callableArray)
        ) {
            $invokableInfo->setObject($callableArray[ 0 ]);
            $invokableInfo->setClass(get_class($callableArray[ 0 ]));
            $invokableInfo->setMethod($callableArray[ 1 ]);
            $invokableInfo->setCallable($callableArray);

            return $callableArray;
        }

        return null;
    }


    /**
     * @param \Closure|mixed     $closure
     * @param null|InvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterClosure($closure, InvokableInfo &$invokableInfo = null) : ?\Closure
    {
        $invokableInfo = $invokableInfo ?? new InvokableInfo();

        if (is_object($closure) && ( get_class($closure) === \Closure::class )) {
            $invokableInfo->setClosure($closure);
            $invokableInfo->setClass(\Closure::class);

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
     * @param array|mixed        $methodArray
     * @param null|InvokableInfo $invokableInfo
     *
     * @return null|array
     */
    public function filterMethodArrayReflection($methodArray, InvokableInfo &$invokableInfo = null) : ?array
    {
        [ $objectOrClass, $method ] = $this->filterMethodArray($methodArray);

        try {
            $rm = new \ReflectionMethod($objectOrClass, $method);

            $invokableInfo = $invokableInfo ?? new InvokableInfo();
            $invokableInfo->setMethod($rm->getName());

            if (is_object($objectOrClass)) {
                $invokableInfo->setObject($objectOrClass);
                $invokableInfo->setClass(get_class($objectOrClass));

            } elseif ($objectOrClass) {
                $invokableInfo->setClass($objectOrClass);
            }
        }
        catch ( \ReflectionException $e ) {
            return null;
        }

        return $methodArray;
    }


    /**
     * @param string|mixed       $handler
     * @param null|InvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterHandler($handler, InvokableInfo &$invokableInfo = null) : ?string
    {
        if (! ( null !== $this->filterWord($handler) )
            && ( 1 === substr_count($handler, '@') )
        ) {
            return null;
        }

        [ $class, $method ] = explode('@', $handler, 2);

        try {
            $rm = new \ReflectionMethod($class, $method);

            $invokableInfo = $invokableInfo ?? new InvokableInfo();
            $invokableInfo->setClass($class);
            $invokableInfo->setMethod($method);

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
     * @param string|mixed $class
     *
     * @return null|string
     */
    public function filterClassFQN($class) : ?string
    {
        if (null === $this->filterWord($class)) {
            return null;
        }

        $phpClass = ltrim($class, '\\');

        $firstLetter = substr($phpClass, 0, 1);
        if (ctype_digit($firstLetter)) {
            return null;
        }

        $test = preg_replace('~[a-z0-9_\x80-\xff]*~iu', '', $class);

        $letters = '' === $test
            ? [] : str_split($test);

        foreach ( $letters as $letter ) {
            if ($letter !== '\\') {
                return null;
            }
        }

        return $class;
    }


    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterThrowable($value) // : ?object
    {
        if ($value instanceof \Throwable) {
            return $value;
        }

        return null;
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterError($value) // : ?object
    {
        if ($value instanceof \Error) {
            return $value;
        }

        return null;
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterException($value) // : ?object
    {
        if ($value instanceof \Exception) {
            return $value;
        }

        return null;
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterRuntimeException($value) // : ?object
    {
        if ($value instanceof \RuntimeException) {
            return $value;
        }

        return null;
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterLogicException($value) // : ?object
    {
        if ($value instanceof \LogicException) {
            return $value;
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
        if ($value instanceof \StdClass) {
            return $value;
        }

        return null;
    }


    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterFileInfo($value) : ?\SplFileInfo
    {
        if ($value instanceof \SplFileInfo) {
            return $value;
        }

        return null;
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return null|\SplFileObject
     */
    public function filterFileObject($value) : ?\SplFileObject
    {
        if ($value instanceof \SplFileObject) {
            return $value;
        }

        return null;
    }


    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return null|\ReflectionClass
     */
    public function filterReflectionClass($value) : ?\ReflectionClass
    {
        if ($value instanceof \ReflectionClass) {
            return $value;
        }

        return null;
    }


    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return null|\ReflectionFunction
     */
    public function filterReflectionFunction($value) : ?\ReflectionFunction
    {
        if ($value instanceof \ReflectionFunction) {
            return $value;
        }

        return null;
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return null|\ReflectionMethod
     */
    public function filterReflectionMethod($value) : ?\ReflectionMethod
    {
        if ($value instanceof \ReflectionMethod) {
            return $value;
        }

        return null;
    }


    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return null|\ReflectionProperty
     */
    public function filterReflectionProperty($value) : ?\ReflectionProperty
    {
        if ($value instanceof \ReflectionProperty) {
            return $value;
        }

        return null;
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return null|\ReflectionParameter
     */
    public function filterReflectionParameter($value) : ?\ReflectionParameter
    {
        if ($value instanceof \ReflectionParameter) {
            return $value;
        }

        return null;
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return null|\ReflectionType
     */
    public function filterReflectionType($value) : ?\ReflectionType
    {
        if ($value instanceof \ReflectionType) {
            return $value;
        }

        return null;
    }


    /**
     * @param mixed $reflectionType
     *
     * @return null|\ReflectionUnionType
     */
    public function filterReflectionUnionType($reflectionType) // : ?\ReflectionUnionType
    {
        if (is_a($reflectionType, 'ReflectionUnionType')) {
            return $reflectionType;
        }

        return null;
    }

    /**
     * @param mixed $reflectionType
     *
     * @return null|\ReflectionNamedType
     */
    public function filterReflectionNamedType($reflectionType) // : ?\ReflectionNamedType
    {
        if (is_a($reflectionType, 'ReflectionNamedType')) {
            return $reflectionType;
        }

        return null;
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
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurl($ch) // : ?resource|\CurlHandle
    {
        if (is_a($ch, 'CurlHandle')) {
            return $ch;

        } elseif (null !== $this->filterOpenedResource($ch)) {
            if (false === @curl_error($ch)) {
                return null;
            }

            return $ch;
        }

        return null;
    }


    /**
     * @param null|string|array|\Throwable $error
     * @param mixed                        ...$arguments
     *
     * @return \Gzhegow\Support\IAssert
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function assert($error = null, ...$arguments) : \Gzhegow\Support\IAssert
    {
        if (! isset($this->assert)) {
            $this->assert = SupportFactory::getInstance()->getAssert();
        }

        $this->assert->assert($error, ...$arguments);

        return $this->assert;
    }

    /**
     * @return \Gzhegow\Support\IFilter
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function filter() : \Gzhegow\Support\IFilter
    {
        return $this;
    }

    /**
     * @return \Gzhegow\Support\IType
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function type() : \Gzhegow\Support\IType
    {
        if (! isset($this->type)) {
            $this->type = SupportFactory::getInstance()->getType();
        }

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
            throw new UnderflowException('ZFilter not defined: ' . $customFilter);
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
            throw new UnderflowException('ZFilter not defined: ' . $filter);
        }

        $closure = function (...$args) use ($filterCallable, $arguments) {
            $bind = array_replace(
                $arguments,
                array_slice($args, 0, count($arguments))
            );

            return call_user_func_array($filterCallable, $bind);
        };

        return $closure;
    }


    /**
     * @param string $filter
     *
     * @return null|\Closure
     */
    public function findCustomFilter(string $filter) : ?\Closure
    {
        $filterLower = strtolower($filter);

        $result = static::$customFilters[ $filterLower ] ?? null;

        return $result;
    }


    /**
     * @return IFilter
     */
    public static function getInstance() : IFilter
    {
        return SupportFactory::getInstance()->getFilter();
    }


    /**
     * @var callable[]
     */
    protected static $customFilters = [];
}
