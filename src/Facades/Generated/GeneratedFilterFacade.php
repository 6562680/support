<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Domain\Filter\Assert;
use Gzhegow\Support\Domain\Filter\CallableInfoVO;
use Gzhegow\Support\Domain\Filter\Type;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Filter;

abstract class GeneratedFilterFacade
{
    /**
     * @return callable[]
     */
    public static function getCustomFilters(): array
    {
        return static::getInstance()->getCustomFilters();
    }

    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public static function filterInt($value): ?int
    {
        return static::getInstance()->filterInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function filterFloat($value): ?float
    {
        return static::getInstance()->filterFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function filterNan($value): ?float
    {
        return static::getInstance()->filterNan($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public static function filterNumber($value)
    {
        return static::getInstance()->filterNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public static function filterIntval($value): ?int
    {
        return static::getInstance()->filterIntval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float|string
     */
    public static function filterFloatval($value): ?float
    {
        return static::getInstance()->filterFloatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNumval($value)
    {
        return static::getInstance()->filterNumval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function filterString($value): ?string
    {
        return static::getInstance()->filterString($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function filterWord($value): ?string
    {
        return static::getInstance()->filterWord($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterStringOrInt($value)
    {
        return static::getInstance()->filterStringOrInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterWordOrInt($value)
    {
        return static::getInstance()->filterWordOrInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterStringOrNumber($value)
    {
        return static::getInstance()->filterStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterWordOrNumber($value)
    {
        return static::getInstance()->filterWordOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function filterStrval($value): ?string
    {
        return static::getInstance()->filterStrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function filterWordval($value): ?string
    {
        return static::getInstance()->filterWordval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param mixed $value
     *
     * @return null|int|string
     */
    public static function filterKey($value)
    {
        return static::getInstance()->filterKey($value);
    }

    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterArray($array, callable $of = null): ?array
    {
        return static::getInstance()->filterArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterList($list, callable $of = null): ?array
    {
        return static::getInstance()->filterList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterDict($dict, callable $of = null): ?array
    {
        return static::getInstance()->filterDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterAssoc($assoc, callable $of = null): ?array
    {
        return static::getInstance()->filterAssoc($assoc, $of);
    }

    /**
     * @param mixed $array
     *
     * @return null|array
     */
    public static function filterPlainArray($array): ?array
    {
        return static::getInstance()->filterPlainArray($array);
    }

    /**
     * @param mixed $value
     *
     * @return null|mixed
     */
    public static function filterArrval($value)
    {
        return static::getInstance()->filterArrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function filterLink($value): ?string
    {
        return static::getInstance()->filterLink($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function filterUrl($value): ?string
    {
        return static::getInstance()->filterUrl($value);
    }

    /**
     * @param mixed               $callable
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public static function filterCallable($callable, CallableInfoVO &$callableInfo = null)
    {
        return static::getInstance()->filterCallable($callable, $callableInfo);
    }

    /**
     * @param mixed               $callableString
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|string|array|callable
     */
    public static function filterCallableString($callableString, CallableInfoVO &$callableInfo = null)
    {
        return static::getInstance()->filterCallableString($callableString, $callableInfo);
    }

    /**
     * @param mixed               $callableString
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|string|callable
     */
    public static function filterCallableStringFunction($callableString, CallableInfoVO &$callableInfo = null): ?string
    {
        return static::getInstance()->filterCallableStringFunction($callableString, $callableInfo);
    }

    /**
     * @param mixed               $callableString
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|string|callable
     */
    public static function filterCallableStringStatic($callableString, CallableInfoVO &$callableInfo = null): ?string
    {
        return static::getInstance()->filterCallableStringStatic($callableString, $callableInfo);
    }

    /**
     * @param mixed               $callableArray
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArray($callableArray, CallableInfoVO &$callableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArray($callableArray, $callableInfo);
    }

    /**
     * @param mixed               $callableArray
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArrayStatic($callableArray, CallableInfoVO &$callableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArrayStatic($callableArray, $callableInfo);
    }

    /**
     * @param mixed               $callableArray
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArrayPublic($callableArray, CallableInfoVO &$callableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArrayPublic($callableArray, $callableInfo);
    }

    /**
     * @param mixed               $closure
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|\Closure
     */
    public static function filterClosure($closure, CallableInfoVO &$callableInfo = null): ?\Closure
    {
        return static::getInstance()->filterClosure($closure, $callableInfo);
    }

    /**
     * @param mixed               $handler
     * @param null|CallableInfoVO $callableInfo
     *
     * @return null|string|callable
     */
    public static function filterHandler($handler, CallableInfoVO &$callableInfo = null): ?string
    {
        return static::getInstance()->filterHandler($handler, $callableInfo);
    }

    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public static function filterClass($class): ?string
    {
        return static::getInstance()->filterClass($class);
    }

    /**
     * @param mixed $className
     *
     * @return null|string
     */
    public static function filterClassName($className): ?string
    {
        return static::getInstance()->filterClassName($className);
    }

    /**
     * @param object $value
     *
     * @return null|object
     */
    public static function filterStdClass($value)
    {
        return static::getInstance()->filterStdClass($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterFileInfo($value): ?\SplFileInfo
    {
        return static::getInstance()->filterFileInfo($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileObject
     */
    public static function filterFileObject($value): ?\SplFileObject
    {
        return static::getInstance()->filterFileObject($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionClass
     */
    public static function filterReflectionClass($value): ?\ReflectionClass
    {
        return static::getInstance()->filterReflectionClass($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionFunction
     */
    public static function filterReflectionFunction($value): ?\ReflectionFunction
    {
        return static::getInstance()->filterReflectionFunction($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionMethod
     */
    public static function filterReflectionMethod($value): ?\ReflectionMethod
    {
        return static::getInstance()->filterReflectionMethod($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionProperty
     */
    public static function filterReflectionProperty($value): ?\ReflectionProperty
    {
        return static::getInstance()->filterReflectionProperty($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionParameter
     */
    public static function filterReflectionParameter($value): ?\ReflectionParameter
    {
        return static::getInstance()->filterReflectionParameter($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|\ReflectionType
     */
    public static function filterReflectionType($value): ?\ReflectionType
    {
        return static::getInstance()->filterReflectionType($value);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function filterResource($h)
    {
        return static::getInstance()->filterResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function filterOpenedResource($h)
    {
        return static::getInstance()->filterOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function filterClosedResource($h)
    {
        return static::getInstance()->filterClosedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function filterReadableResource($h)
    {
        return static::getInstance()->filterReadableResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function filterWritableResource($h)
    {
        return static::getInstance()->filterWritableResource($h);
    }

    /**
     * @param string   $filter
     * @param \Closure $callable
     *
     * @return Filter
     */
    public static function addCustomFilter(string $filter, \Closure $callable)
    {
        return static::getInstance()->addCustomFilter($filter, $callable);
    }

    /**
     * @param null|string|array $message
     * @param mixed             ...$arguments
     *
     * @return Assert
     */
    public static function assert($message = null, ...$arguments): Assert
    {
        return static::getInstance()->assert($message, ...$arguments);
    }

    /**
     * @return Type
     */
    public static function type(): Type
    {
        return static::getInstance()->type();
    }

    /**
     * @param string $customFilter
     * @param mixed  ...$arguments
     *
     * @return null|mixed
     */
    public static function call(string $customFilter, ...$arguments)
    {
        return static::getInstance()->call($customFilter, ...$arguments);
    }

    /**
     * @param string $filter
     * @param mixed  ...$arguments
     *
     * @return \Closure
     */
    public static function bind(string $filter, ...$arguments): \Closure
    {
        return static::getInstance()->bind($filter, ...$arguments);
    }

    /**
     * @param string   $filter
     * @param \Closure $callable
     *
     * @return Filter
     */
    public static function replaceCustomFilter(string $filter, \Closure $callable)
    {
        return static::getInstance()->replaceCustomFilter($filter, $callable);
    }

    /**
     * @param string $filter
     *
     * @return null|\Closure
     */
    public static function findCustomFilter(string $filter): ?\Closure
    {
        return static::getInstance()->findCustomFilter($filter);
    }

    /**
     * @return Filter
     */
    abstract public static function getInstance(): Filter;
}
