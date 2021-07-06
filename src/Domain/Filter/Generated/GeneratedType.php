<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Domain\Filter\Generated;

use Gzhegow\Support\Domain\Filter\ValueObjects\InvokableInfo;
use Gzhegow\Support\Filter;

/**
 * Gzhegow_Support_Generator_TypeBlueprint
 */
abstract class GeneratedType
{
    /** @var Filter */
    protected $filter;

    /**
     * Constructor
     *
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param string $customFilter
     * @param mixed  ...$arguments
     *
     * @return null|mixed
     */
    public function call(string $customFilter, ...$arguments)
    {
        return \null !== $this->filter->call($customFilter, ...$arguments);
    }

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public function isBool($value): ?bool
    {
        return null !== $this->filter->filterBool($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return bool
     */
    public function isInt($value): ?bool
    {
        return null !== $this->filter->filterInt($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public function isFloat($value): ?bool
    {
        return null !== $this->filter->filterFloat($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public function isNan($value): ?bool
    {
        return null !== $this->filter->filterNan($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return bool
     */
    public function isNum($value): bool
    {
        return null !== $this->filter->filterNum($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isIntval($value): ?bool
    {
        return null !== $this->filter->filterIntval($value);
    }

    /**
     * @param float|string|mixed $value
     *
     * @return bool
     */
    public function isFloatval($value): ?bool
    {
        return null !== $this->filter->filterFloatval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumval($value): bool
    {
        return null !== $this->filter->filterNumval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumericval($value): bool
    {
        return null !== $this->filter->filterNumericval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isPositiveVal($value): bool
    {
        return null !== $this->filter->filterPositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNonNegativeVal($value): bool
    {
        return null !== $this->filter->filterNonNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNegativeVal($value): bool
    {
        return null !== $this->filter->filterNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNonPositiveVal($value): bool
    {
        return null !== $this->filter->filterNonPositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isPositiveIntval($value): ?bool
    {
        return null !== $this->filter->filterPositiveIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNonNegativeIntval($value): ?bool
    {
        return null !== $this->filter->filterNonNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNegativeIntval($value): ?bool
    {
        return null !== $this->filter->filterNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNonPositiveIntval($value): ?bool
    {
        return null !== $this->filter->filterNonPositiveIntval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isString($value): ?bool
    {
        return null !== $this->filter->filterString($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isWord($value): ?bool
    {
        return null !== $this->filter->filterWord($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isStringOrInt($value): bool
    {
        return null !== $this->filter->filterStringOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isWordOrInt($value): bool
    {
        return null !== $this->filter->filterWordOrInt($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isStringOrNum($value): bool
    {
        return null !== $this->filter->filterStringOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isWordOrNum($value): bool
    {
        return null !== $this->filter->filterWordOrNum($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isStrval($value): ?bool
    {
        return null !== $this->filter->filterStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isWordval($value): ?bool
    {
        return null !== $this->filter->filterWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isTrimval($value): ?bool
    {
        return null !== $this->filter->filterTrimval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isKey($value): bool
    {
        return null !== $this->filter->filterKey($value);
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return bool
     */
    public function isArray($array, callable $of = null): ?bool
    {
        return null !== $this->filter->filterArray($array, $of);
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return bool
     */
    public function isList($list, callable $of = null): ?bool
    {
        return null !== $this->filter->filterList($list, $of);
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public function isDict($dict, callable $of = null): ?bool
    {
        return null !== $this->filter->filterDict($dict, $of);
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public function isAssoc($assoc, callable $of = null): ?bool
    {
        return null !== $this->filter->filterAssoc($assoc, $of);
    }

    /**
     * @param array|mixed $array
     *
     * @return bool
     */
    public function isPlainArray($array): ?bool
    {
        return null !== $this->filter->filterPlainArray($array);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isArrval($value): bool
    {
        return null !== $this->filter->filterArrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isLink($value): ?bool
    {
        return null !== $this->filter->filterLink($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isUrl($value): ?bool
    {
        return null !== $this->filter->filterUrl($value);
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfo                   $invokableInfo
     *
     * @return bool
     */
    public function isCallable($callable, InvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->filter->filterCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfo          $invokableInfo
     *
     * @return bool
     */
    public function isCallableString($callableString, InvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->filter->filterCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringFunction($callableString, InvokableInfo &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringStatic($callableString, InvokableInfo &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return bool
     */
    public function isCallableArray($callableArray, InvokableInfo &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayStatic($callableArray, InvokableInfo &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayPublic($callableArray, InvokableInfo &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed     $closure
     * @param null|InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isClosure($closure, InvokableInfo &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterClosure($closure, $invokableInfo);
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return bool
     */
    public function isMethodArray($methodArray): ?bool
    {
        return null !== $this->filter->filterMethodArray($methodArray);
    }

    /**
     * @param array|mixed        $methodArray
     * @param null|InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isMethodArrayReflection($methodArray, InvokableInfo &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed       $handler
     * @param null|InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isHandler($handler, InvokableInfo &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterHandler($handler, $invokableInfo);
    }

    /**
     * @param string|mixed $class
     *
     * @return bool
     */
    public function isClass($class): ?bool
    {
        return null !== $this->filter->filterClass($class);
    }

    /**
     * @param string|mixed $className
     *
     * @return bool
     */
    public function isClassName($className): ?bool
    {
        return null !== $this->filter->filterClassName($className);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isThrowable($value): bool
    {
        return null !== $this->filter->filterThrowable($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isException($value): bool
    {
        return null !== $this->filter->filterException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isRuntimeException($value): bool
    {
        return null !== $this->filter->filterRuntimeException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isLogicException($value): bool
    {
        return null !== $this->filter->filterLogicException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isStdClass($value): bool
    {
        return null !== $this->filter->filterStdClass($value);
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return bool
     */
    public function isFileInfo($value): ?bool
    {
        return null !== $this->filter->filterFileInfo($value);
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return bool
     */
    public function isFileObject($value): ?bool
    {
        return null !== $this->filter->filterFileObject($value);
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return bool
     */
    public function isReflectionClass($value): ?bool
    {
        return null !== $this->filter->filterReflectionClass($value);
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return bool
     */
    public function isReflectionFunction($value): ?bool
    {
        return null !== $this->filter->filterReflectionFunction($value);
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return bool
     */
    public function isReflectionMethod($value): ?bool
    {
        return null !== $this->filter->filterReflectionMethod($value);
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return bool
     */
    public function isReflectionProperty($value): ?bool
    {
        return null !== $this->filter->filterReflectionProperty($value);
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return bool
     */
    public function isReflectionParameter($value): ?bool
    {
        return null !== $this->filter->filterReflectionParameter($value);
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return bool
     */
    public function isReflectionType($value): ?bool
    {
        return null !== $this->filter->filterReflectionType($value);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return bool
     */
    public function isReflectionUnionType($reflectionType): bool
    {
        return null !== $this->filter->filterReflectionUnionType($reflectionType);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return bool
     */
    public function isReflectionNamedType($reflectionType): bool
    {
        return null !== $this->filter->filterReflectionNamedType($reflectionType);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResource($h): bool
    {
        return null !== $this->filter->filterResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isOpenedResource($h): bool
    {
        return null !== $this->filter->filterOpenedResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isClosedResource($h): bool
    {
        return null !== $this->filter->filterClosedResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isReadableResource($h): bool
    {
        return null !== $this->filter->filterReadableResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isWritableResource($h): bool
    {
        return null !== $this->filter->filterWritableResource($h);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return bool
     */
    public function isCurl($ch): bool
    {
        return null !== $this->filter->filterCurl($ch);
    }
}
