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
use Gzhegow\Support\Domain\Filter\InvokableInfoVal;
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
     * @param bool|mixed $value
     *
     * @return null|bool
     */
    public static function filterBool($value): ?bool
    {
        return static::getInstance()->filterBool($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public static function filterInt($value): ?int
    {
        return static::getInstance()->filterInt($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public static function filterFloat($value): ?float
    {
        return static::getInstance()->filterFloat($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public static function filterNan($value): ?float
    {
        return static::getInstance()->filterNan($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumber($value)
    {
        return static::getInstance()->filterNumber($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public static function filterIntval($value): ?int
    {
        return static::getInstance()->filterIntval($value);
    }

    /**
     * @param float|string|mixed $value
     *
     * @return null|float|string
     */
    public static function filterFloatval($value): ?float
    {
        return static::getInstance()->filterFloatval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNumval($value)
    {
        return static::getInstance()->filterNumval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterPositive($value)
    {
        return static::getInstance()->filterPositive($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNonNegative($value)
    {
        return static::getInstance()->filterNonNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNegative($value)
    {
        return static::getInstance()->filterNegative($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterNonPositive($value)
    {
        return static::getInstance()->filterNonPositive($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterString($value): ?string
    {
        return static::getInstance()->filterString($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterWord($value): ?string
    {
        return static::getInstance()->filterWord($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterStringOrInt($value)
    {
        return static::getInstance()->filterStringOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterWordOrInt($value)
    {
        return static::getInstance()->filterWordOrInt($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterStringOrNumber($value)
    {
        return static::getInstance()->filterStringOrNumber($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterWordOrNumber($value)
    {
        return static::getInstance()->filterWordOrNumber($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterStrval($value): ?string
    {
        return static::getInstance()->filterStrval($value);
    }

    /**
     * @param string|mixed $value
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
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public static function filterKey($value)
    {
        return static::getInstance()->filterKey($value);
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterArray($array, callable $of = null): ?array
    {
        return static::getInstance()->filterArray($array, $of);
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterList($list, callable $of = null): ?array
    {
        return static::getInstance()->filterList($list, $of);
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterDict($dict, callable $of = null): ?array
    {
        return static::getInstance()->filterDict($dict, $of);
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterAssoc($assoc, callable $of = null): ?array
    {
        return static::getInstance()->filterAssoc($assoc, $of);
    }

    /**
     * @param array|mixed $array
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
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterLink($value): ?string
    {
        return static::getInstance()->filterLink($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterUrl($value): ?string
    {
        return static::getInstance()->filterUrl($value);
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfoVal                $invokableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public static function filterCallable($callable, InvokableInfoVal &$invokableInfo = null)
    {
        return static::getInstance()->filterCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfoVal       $invokableInfo
     *
     * @return null|string|array|callable
     */
    public static function filterCallableString($callableString, InvokableInfoVal &$invokableInfo = null)
    {
        return static::getInstance()->filterCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfoVal $invokableInfo
     *
     * @return null|string|callable
     */
    public static function filterCallableStringFunction(
        $callableString,
        InvokableInfoVal &$invokableInfo = null
    ): ?string {
        return static::getInstance()->filterCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfoVal $invokableInfo
     *
     * @return null|string|callable
     */
    public static function filterCallableStringStatic($callableString, InvokableInfoVal &$invokableInfo = null): ?string
    {
        return static::getInstance()->filterCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|InvokableInfoVal $invokableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArray($callableArray, InvokableInfoVal &$invokableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|InvokableInfoVal $invokableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArrayStatic($callableArray, InvokableInfoVal &$invokableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|InvokableInfoVal $invokableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArrayPublic($callableArray, InvokableInfoVal &$invokableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed        $closure
     * @param null|InvokableInfoVal $invokableInfo
     *
     * @return null|\Closure
     */
    public static function filterClosure($closure, InvokableInfoVal &$invokableInfo = null): ?\Closure
    {
        return static::getInstance()->filterClosure($closure, $invokableInfo);
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return null|array
     */
    public static function filterMethodArray($methodArray): ?array
    {
        return static::getInstance()->filterMethodArray($methodArray);
    }

    /**
     * @param array|mixed           $methodArray
     * @param null|InvokableInfoVal $invokableInfo
     *
     * @return null|array
     */
    public static function filterMethodArrayReflection($methodArray, InvokableInfoVal &$invokableInfo = null): ?array
    {
        return static::getInstance()->filterMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed          $handler
     * @param null|InvokableInfoVal $invokableInfo
     *
     * @return null|string|callable
     */
    public static function filterHandler($handler, InvokableInfoVal &$invokableInfo = null): ?string
    {
        return static::getInstance()->filterHandler($handler, $invokableInfo);
    }

    /**
     * @param string|mixed $class
     *
     * @return null|string
     */
    public static function filterClass($class): ?string
    {
        return static::getInstance()->filterClass($class);
    }

    /**
     * @param string|mixed $className
     *
     * @return null|string
     */
    public static function filterClassName($className): ?string
    {
        return static::getInstance()->filterClassName($className);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public static function filterStdClass($value)
    {
        return static::getInstance()->filterStdClass($value);
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterFileInfo($value): ?\SplFileInfo
    {
        return static::getInstance()->filterFileInfo($value);
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return null|\SplFileObject
     */
    public static function filterFileObject($value): ?\SplFileObject
    {
        return static::getInstance()->filterFileObject($value);
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return null|\ReflectionClass
     */
    public static function filterReflectionClass($value): ?\ReflectionClass
    {
        return static::getInstance()->filterReflectionClass($value);
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return null|\ReflectionFunction
     */
    public static function filterReflectionFunction($value): ?\ReflectionFunction
    {
        return static::getInstance()->filterReflectionFunction($value);
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return null|\ReflectionMethod
     */
    public static function filterReflectionMethod($value): ?\ReflectionMethod
    {
        return static::getInstance()->filterReflectionMethod($value);
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return null|\ReflectionProperty
     */
    public static function filterReflectionProperty($value): ?\ReflectionProperty
    {
        return static::getInstance()->filterReflectionProperty($value);
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return null|\ReflectionParameter
     */
    public static function filterReflectionParameter($value): ?\ReflectionParameter
    {
        return static::getInstance()->filterReflectionParameter($value);
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return null|\ReflectionType
     */
    public static function filterReflectionType($value): ?\ReflectionType
    {
        return static::getInstance()->filterReflectionType($value);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResource($h)
    {
        return static::getInstance()->filterResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterOpenedResource($h)
    {
        return static::getInstance()->filterOpenedResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterClosedResource($h)
    {
        return static::getInstance()->filterClosedResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterReadableResource($h)
    {
        return static::getInstance()->filterReadableResource($h);
    }

    /**
     * @param resource|mixed $h
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
