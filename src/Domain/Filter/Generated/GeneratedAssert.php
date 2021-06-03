<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Domain\Filter\Generated;

use Gzhegow\Support\Domain\Filter\InvokableInfoVO;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Filter;

abstract class GeneratedAssert
{
    /**
     * @var Filter
     */
    public $filter;

    /**
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param string $customFilter
     * @param mixed ...$arguments
     *
     * @return null|mixed
     */
    public function call(string $customFilter, ...$arguments)
    {
        if (null === ($filtered = $this->filter->call($customFilter, ...$arguments))) {
            throw new InvalidArgumentException($this->flushMessage(...$arguments)
                ?? array_merge([ 'Invalid ' . $customFilter . ' passed: %s' ], $arguments)
            );
        }

        return $filtered;
    }

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public function assertBool($value): ?bool
    {
        if (null === ($filtered = $this->filter->filterBool($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Bool passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function assertInt($value): ?int
    {
        if (null === ($filtered = $this->filter->filterInt($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Int passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function assertFloat($value): ?float
    {
        if (null === ($filtered = $this->filter->filterFloat($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Float passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function assertNan($value): ?float
    {
        if (null === ($filtered = $this->filter->filterNan($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Nan passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function assertNumber($value)
    {
        if (null === ($filtered = $this->filter->filterNumber($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Number passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertIntval($value): ?int
    {
        if (null === ($filtered = $this->filter->filterIntval($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Intval passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param float|string|mixed $value
     *
     * @return float|string
     */
    public function assertFloatval($value): ?float
    {
        if (null === ($filtered = $this->filter->filterFloatval($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Floatval passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertNumval($value)
    {
        if (null === ($filtered = $this->filter->filterNumval($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Numval passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertString($value): ?string
    {
        if (null === ($filtered = $this->filter->filterString($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid String passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertWord($value): ?string
    {
        if (null === ($filtered = $this->filter->filterWord($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Word passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrInt($value)
    {
        if (null === ($filtered = $this->filter->filterStringOrInt($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid StringOrInt passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrInt($value)
    {
        if (null === ($filtered = $this->filter->filterWordOrInt($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid WordOrInt passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrNumber($value)
    {
        if (null === ($filtered = $this->filter->filterStringOrNumber($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid StringOrNumber passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrNumber($value)
    {
        if (null === ($filtered = $this->filter->filterWordOrNumber($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid WordOrNumber passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertStrval($value): ?string
    {
        if (null === ($filtered = $this->filter->filterStrval($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Strval passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertWordval($value): ?string
    {
        if (null === ($filtered = $this->filter->filterWordval($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Wordval passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertKey($value)
    {
        if (null === ($filtered = $this->filter->filterKey($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Key passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return array
     */
    public function assertArray($array, callable $of = null): ?array
    {
        if (null === ($filtered = $this->filter->filterArray($array,$of))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Array passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return array
     */
    public function assertList($list, callable $of = null): ?array
    {
        if (null === ($filtered = $this->filter->filterList($list,$of))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid List passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return array
     */
    public function assertDict($dict, callable $of = null): ?array
    {
        if (null === ($filtered = $this->filter->filterDict($dict,$of))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Dict passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return array
     */
    public function assertAssoc($assoc, callable $of = null): ?array
    {
        if (null === ($filtered = $this->filter->filterAssoc($assoc,$of))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Assoc passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed $array
     *
     * @return array
     */
    public function assertPlainArray($array): ?array
    {
        if (null === ($filtered = $this->filter->filterPlainArray($array))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid PlainArray passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function assertArrval($value)
    {
        if (null === ($filtered = $this->filter->filterArrval($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Arrval passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertLink($value): ?string
    {
        if (null === ($filtered = $this->filter->filterLink($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Link passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertUrl($value): ?string
    {
        if (null === ($filtered = $this->filter->filterUrl($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Url passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfoVO                 $invokableInfo
     *
     * @return string|array|\Closure|callable
     */
    public function assertCallable($callable, InvokableInfoVO &$invokableInfo = null)
    {
        if (null === ($filtered = $this->filter->filterCallable($callable,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Callable passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfoVO        $invokableInfo
     *
     * @return string|array|callable
     */
    public function assertCallableString($callableString, InvokableInfoVO &$invokableInfo = null)
    {
        if (null === ($filtered = $this->filter->filterCallableString($callableString,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid CallableString passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfoVO  $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringFunction($callableString, InvokableInfoVO &$invokableInfo = null): ?string
    {
        if (null === ($filtered = $this->filter->filterCallableStringFunction($callableString,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid CallableStringFunction passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfoVO  $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringStatic($callableString, InvokableInfoVO &$invokableInfo = null): ?string
    {
        if (null === ($filtered = $this->filter->filterCallableStringStatic($callableString,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid CallableStringStatic passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArray($callableArray, InvokableInfoVO &$invokableInfo = null): ?array
    {
        if (null === ($filtered = $this->filter->filterCallableArray($callableArray,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid CallableArray passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayStatic($callableArray, InvokableInfoVO &$invokableInfo = null): ?array
    {
        if (null === ($filtered = $this->filter->filterCallableArrayStatic($callableArray,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid CallableArrayStatic passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayPublic($callableArray, InvokableInfoVO &$invokableInfo = null): ?array
    {
        if (null === ($filtered = $this->filter->filterCallableArrayPublic($callableArray,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid CallableArrayPublic passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \Closure|mixed       $closure
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return \Closure
     */
    public function assertClosure($closure, InvokableInfoVO &$invokableInfo = null): ?\Closure
    {
        if (null === ($filtered = $this->filter->filterClosure($closure,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Closure passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return array
     */
    public function assertMethodArray($methodArray): ?array
    {
        if (null === ($filtered = $this->filter->filterMethodArray($methodArray))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid MethodArray passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed          $methodArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return array
     */
    public function assertMethodArrayReflection($methodArray, InvokableInfoVO &$invokableInfo = null): ?array
    {
        if (null === ($filtered = $this->filter->filterMethodArrayReflection($methodArray,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid MethodArrayReflection passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed         $handler
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return string|callable
     */
    public function assertHandler($handler, InvokableInfoVO &$invokableInfo = null): ?string
    {
        if (null === ($filtered = $this->filter->filterHandler($handler,$invokableInfo))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Handler passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $class
     *
     * @return string
     */
    public function assertClass($class): ?string
    {
        if (null === ($filtered = $this->filter->filterClass($class))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Class passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $className
     *
     * @return string
     */
    public function assertClassName($className): ?string
    {
        if (null === ($filtered = $this->filter->filterClassName($className))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ClassName passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertStdClass($value)
    {
        if (null === ($filtered = $this->filter->filterStdClass($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid StdClass passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return \SplFileInfo
     */
    public function assertFileInfo($value): ?\SplFileInfo
    {
        if (null === ($filtered = $this->filter->filterFileInfo($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid FileInfo passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return \SplFileObject
     */
    public function assertFileObject($value): ?\SplFileObject
    {
        if (null === ($filtered = $this->filter->filterFileObject($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid FileObject passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return \ReflectionClass
     */
    public function assertReflectionClass($value): ?\ReflectionClass
    {
        if (null === ($filtered = $this->filter->filterReflectionClass($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ReflectionClass passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return \ReflectionFunction
     */
    public function assertReflectionFunction($value): ?\ReflectionFunction
    {
        if (null === ($filtered = $this->filter->filterReflectionFunction($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ReflectionFunction passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return \ReflectionMethod
     */
    public function assertReflectionMethod($value): ?\ReflectionMethod
    {
        if (null === ($filtered = $this->filter->filterReflectionMethod($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ReflectionMethod passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return \ReflectionProperty
     */
    public function assertReflectionProperty($value): ?\ReflectionProperty
    {
        if (null === ($filtered = $this->filter->filterReflectionProperty($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ReflectionProperty passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return \ReflectionParameter
     */
    public function assertReflectionParameter($value): ?\ReflectionParameter
    {
        if (null === ($filtered = $this->filter->filterReflectionParameter($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ReflectionParameter passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return \ReflectionType
     */
    public function assertReflectionType($value): ?\ReflectionType
    {
        if (null === ($filtered = $this->filter->filterReflectionType($value))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ReflectionType passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResource($h)
    {
        if (null === ($filtered = $this->filter->filterResource($h))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid Resource passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertOpenedResource($h)
    {
        if (null === ($filtered = $this->filter->filterOpenedResource($h))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid OpenedResource passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertClosedResource($h)
    {
        if (null === ($filtered = $this->filter->filterClosedResource($h))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ClosedResource passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertReadableResource($h)
    {
        if (null === ($filtered = $this->filter->filterReadableResource($h))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid ReadableResource passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertWritableResource($h)
    {
        if (null === ($filtered = $this->filter->filterWritableResource($h))) {
            throw new InvalidArgumentException($this->flushMessage(...func_get_args())
                ?? array_merge([ 'Invalid WritableResource passed: %s' ], func_get_args())
            );
        }

        return $filtered;
    }

    /**
     * @param mixed ...$arguments
     *
     * @return null|string|array
     */
    abstract public function flushMessage(...$arguments);
}
