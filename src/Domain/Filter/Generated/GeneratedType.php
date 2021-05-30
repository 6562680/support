<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Domain\Filter\Generated;

use Gzhegow\Support\Domain\Filter\CallableInfoVO;
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
     * @param mixed $value
     *
     * @return bool
     */
    public function isInt($value): ?bool
    {
        return null !== $this->filter->filterInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFloat($value): ?bool
    {
        return null !== $this->filter->filterFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNan($value): ?bool
    {
        return null !== $this->filter->filterNan($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNumber($value): bool
    {
        return null !== $this->filter->filterNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isIntval($value): ?bool
    {
        return null !== $this->filter->filterIntval($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFloatval($value): ?bool
    {
        return null !== $this->filter->filterFloatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNumval($value): bool
    {
        return null !== $this->filter->filterNumval($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isString($value): ?bool
    {
        return null !== $this->filter->filterString($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isWord($value): ?bool
    {
        return null !== $this->filter->filterWord($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isStringOrInt($value): bool
    {
        return null !== $this->filter->filterStringOrInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isWordOrInt($value): bool
    {
        return null !== $this->filter->filterWordOrInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isStringOrNumber($value): bool
    {
        return null !== $this->filter->filterStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isWordOrNumber($value): bool
    {
        return null !== $this->filter->filterWordOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isStrval($value): ?bool
    {
        return null !== $this->filter->filterStrval($value);
    }

    /**
     * @param mixed $value
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
     * @param mixed $value
     *
     * @return bool
     */
    public function isKey($value): bool
    {
        return null !== $this->filter->filterKey($value);
    }

    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return bool
     */
    public function isArray($array, callable $of = null): ?bool
    {
        return null !== $this->filter->filterArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return bool
     */
    public function isList($list, callable $of = null): ?bool
    {
        return null !== $this->filter->filterList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public function isDict($dict, callable $of = null): ?bool
    {
        return null !== $this->filter->filterDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public function isAssoc($assoc, callable $of = null): ?bool
    {
        return null !== $this->filter->filterAssoc($assoc, $of);
    }

    /**
     * @param mixed $array
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
     * @param mixed $value
     *
     * @return bool
     */
    public function isLink($value): ?bool
    {
        return null !== $this->filter->filterLink($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isUrl($value): ?bool
    {
        return null !== $this->filter->filterUrl($value);
    }

    /**
     * @param mixed               $callable
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isCallable($callable, CallableInfoVO &$callableInfo = null): bool
    {
        return null !== $this->filter->filterCallable($callable, $callableInfo);
    }

    /**
     * @param mixed               $callableString
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isCallableString($callableString, CallableInfoVO &$callableInfo = null): bool
    {
        return null !== $this->filter->filterCallableString($callableString, $callableInfo);
    }

    /**
     * @param mixed               $callableString
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isCallableStringFunction($callableString, CallableInfoVO &$callableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableStringFunction($callableString, $callableInfo);
    }

    /**
     * @param mixed               $callableString
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isCallableStringStatic($callableString, CallableInfoVO &$callableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableStringStatic($callableString, $callableInfo);
    }

    /**
     * @param mixed               $callableArray
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isCallableArray($callableArray, CallableInfoVO &$callableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArray($callableArray, $callableInfo);
    }

    /**
     * @param mixed               $callableArray
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isCallableArrayStatic($callableArray, CallableInfoVO &$callableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArrayStatic($callableArray, $callableInfo);
    }

    /**
     * @param mixed               $callableArray
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isCallableArrayPublic($callableArray, CallableInfoVO &$callableInfo = null): ?bool
    {
        return null !== $this->filter->filterCallableArrayPublic($callableArray, $callableInfo);
    }

    /**
     * @param mixed               $closure
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isClosure($closure, CallableInfoVO &$callableInfo = null): ?bool
    {
        return null !== $this->filter->filterClosure($closure, $callableInfo);
    }

    /**
     * @param mixed               $handler
     * @param null|CallableInfoVO $callableInfo
     *
     * @return bool
     */
    public function isHandler($handler, CallableInfoVO &$callableInfo = null): ?bool
    {
        return null !== $this->filter->filterHandler($handler, $callableInfo);
    }

    /**
     * @param mixed $class
     *
     * @return bool
     */
    public function isClass($class): ?bool
    {
        return null !== $this->filter->filterClass($class);
    }

    /**
     * @param mixed $className
     *
     * @return bool
     */
    public function isClassName($className): ?bool
    {
        return null !== $this->filter->filterClassName($className);
    }

    /**
     * @param object $value
     *
     * @return bool
     */
    public function isStdClass($value): bool
    {
        return null !== $this->filter->filterStdClass($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFileInfo($value): ?bool
    {
        return null !== $this->filter->filterFileInfo($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFileObject($value): ?bool
    {
        return null !== $this->filter->filterFileObject($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isReflectionClass($value): ?bool
    {
        return null !== $this->filter->filterReflectionClass($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isReflectionFunction($value): ?bool
    {
        return null !== $this->filter->filterReflectionFunction($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isReflectionMethod($value): ?bool
    {
        return null !== $this->filter->filterReflectionMethod($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isReflectionProperty($value): ?bool
    {
        return null !== $this->filter->filterReflectionProperty($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isReflectionParameter($value): ?bool
    {
        return null !== $this->filter->filterReflectionParameter($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isReflectionType($value): ?bool
    {
        return null !== $this->filter->filterReflectionType($value);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isResource($h): bool
    {
        return null !== $this->filter->filterResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isOpenedResource($h): bool
    {
        return null !== $this->filter->filterOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isClosedResource($h): bool
    {
        return null !== $this->filter->filterClosedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isReadableResource($h): bool
    {
        return null !== $this->filter->filterReadableResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isWritableResource($h): bool
    {
        return null !== $this->filter->filterWritableResource($h);
    }
}