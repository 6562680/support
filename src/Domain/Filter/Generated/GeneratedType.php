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
use Gzhegow\Support\Filter;

abstract class GeneratedType
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
     * @return bool
     */
    public function call(string $customFilter, ...$arguments): bool
    {
        return null !== $this->filter->call($customFilter, ...$arguments);
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
    public function isNumber($value): bool
    {
        return null !== $this->filter->filterNumber($value);
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
    public function isStringOrNumber($value): bool
    {
        return null !== $this->filter->filterStringOrNumber($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isWordOrNumber($value): bool
    {
        return null !== $this->filter->filterWordOrNumber($value);
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
     * @param null|InvokableInfoVO                 $invokableInfo
     *
     * @return bool
     */
    public function isCallable($callable, InvokableInfoVO &$invokableInfo = null): bool
    {
        return null !== $this->filter->filterCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfoVO        $invokableInfo
     *
     * @return bool
     */
    public function isCallableString($callableString, InvokableInfoVO &$invokableInfo = null): bool
    {
        return null !== $this->filter->filterCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfoVO  $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringFunction($callableString, InvokableInfoVO &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfoVO  $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringStatic($callableString, InvokableInfoVO &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return bool
     */
    public function isCallableArray($callableArray, InvokableInfoVO &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayStatic($callableArray, InvokableInfoVO &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayPublic($callableArray, InvokableInfoVO &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed       $closure
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return bool
     */
    public function isClosure($closure, InvokableInfoVO &$invokableInfo = null): ?bool
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
     * @param array|mixed          $methodArray
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return bool
     */
    public function isMethodArrayReflection($methodArray, InvokableInfoVO &$invokableInfo = null): ?bool
    {
        return null !== $this->filter->filterMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed         $handler
     * @param null|InvokableInfoVO $invokableInfo
     *
     * @return bool
     */
    public function isHandler($handler, InvokableInfoVO &$invokableInfo = null): ?bool
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
}
