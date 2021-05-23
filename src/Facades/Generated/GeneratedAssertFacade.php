<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Assert;
use Gzhegow\Support\Domain\Filter\CallableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Filter;

abstract class GeneratedAssertFacade
{
    /**
     * @param string $filter
     * @param mixed ...$arguments
     *
     * @return null|mixed
     */
    public static function assert(string $filter, ...$arguments)
    {
        return static::getInstance()->assert($filter, ...$arguments);
    }

    /**
     * @param mixed $value
     *
     * @return int|string
     */
    public static function assertKey($value)
    {
        return static::getInstance()->assertKey($value);
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    public static function assertInt($value): ?int
    {
        return static::getInstance()->assertInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public static function assertFloat($value): ?float
    {
        return static::getInstance()->assertFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public static function assertNan($value): ?float
    {
        return static::getInstance()->assertNan($value);
    }

    /**
     * @param mixed $value
     *
     * @return int|string
     */
    public static function assertNumber($value)
    {
        return static::getInstance()->assertNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function assertTheString($value): ?string
    {
        return static::getInstance()->assertTheString($value);
    }

    /**
     * @param mixed $value
     *
     * @return int|float|string
     */
    public static function assertStringOrNumber($value)
    {
        return static::getInstance()->assertStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return int|float|string
     */
    public static function assertTheStringOrNumber($value)
    {
        return static::getInstance()->assertTheStringOrNumber($value);
    }

    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return array
     */
    public static function assertArray($array, callable $of = null): ?array
    {
        return static::getInstance()->assertArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return array
     */
    public static function assertList($list, callable $of = null): ?array
    {
        return static::getInstance()->assertList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return array
     */
    public static function assertDict($dict, callable $of = null): ?array
    {
        return static::getInstance()->assertDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return array
     */
    public static function assertAssoc($assoc, callable $of = null): ?array
    {
        return static::getInstance()->assertAssoc($assoc, $of);
    }

    /**
     * @param mixed $array
     *
     * @return array
     */
    public static function assertPlainArray($array): ?array
    {
        return static::getInstance()->assertPlainArray($array);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function assertLink($value): ?string
    {
        return static::getInstance()->assertLink($value);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function assertUrl($value): ?string
    {
        return static::getInstance()->assertUrl($value);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return string|array|\Closure|callable
     */
    public static function assertCallable($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->assertCallable($callable, $callableInfo);
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return string|array|callable
     */
    public static function assertCallableString($callableString, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->assertCallableString($callableString, $callableInfo);
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return string|callable
     */
    public static function assertCallableStringFunction($callableString, CallableInfo &$callableInfo = null): ?string
    {
        return static::getInstance()->assertCallableStringFunction($callableString, $callableInfo);
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return string|callable
     */
    public static function assertCallableStringStatic($callableString, CallableInfo &$callableInfo = null): ?string
    {
        return static::getInstance()->assertCallableStringStatic($callableString, $callableInfo);
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArray($callableArray, CallableInfo &$callableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArray($callableArray, $callableInfo);
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArrayStatic($callableArray, CallableInfo &$callableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArrayStatic($callableArray, $callableInfo);
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArrayPublic($callableArray, CallableInfo &$callableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArrayPublic($callableArray, $callableInfo);
    }

    /**
     * @param mixed             $closure
     * @param null|CallableInfo $callableInfo
     *
     * @return \Closure
     */
    public static function assertClosure($closure, CallableInfo &$callableInfo = null): ?\Closure
    {
        return static::getInstance()->assertClosure($closure, $callableInfo);
    }

    /**
     * @param mixed $class
     *
     * @return string
     */
    public static function assertClass($class): ?string
    {
        return static::getInstance()->assertClass($class);
    }

    /**
     * @param mixed $className
     *
     * @return string
     */
    public static function assertClassName($className): ?string
    {
        return static::getInstance()->assertClassName($className);
    }

    /**
     * @param object $value
     *
     * @return object
     */
    public static function assertStdClass($value)
    {
        return static::getInstance()->assertStdClass($value);
    }

    /**
     * @param mixed $value
     *
     * @return \SplFileInfo
     */
    public static function assertFileInfo($value): ?\SplFileInfo
    {
        return static::getInstance()->assertFileInfo($value);
    }

    /**
     * @param mixed $value
     *
     * @return \SplFileObject
     */
    public static function assertFileObject($value): ?\SplFileObject
    {
        return static::getInstance()->assertFileObject($value);
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionClass
     */
    public static function assertReflectionClass($value): ?\ReflectionClass
    {
        return static::getInstance()->assertReflectionClass($value);
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionFunction
     */
    public static function assertReflectionFunction($value): ?\ReflectionFunction
    {
        return static::getInstance()->assertReflectionFunction($value);
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionMethod
     */
    public static function assertReflectionMethod($value): ?\ReflectionMethod
    {
        return static::getInstance()->assertReflectionMethod($value);
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionProperty
     */
    public static function assertReflectionProperty($value): ?\ReflectionProperty
    {
        return static::getInstance()->assertReflectionProperty($value);
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionParameter
     */
    public static function assertReflectionParameter($value): ?\ReflectionParameter
    {
        return static::getInstance()->assertReflectionParameter($value);
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionType
     */
    public static function assertReflectionType($value): ?\ReflectionType
    {
        return static::getInstance()->assertReflectionType($value);
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public static function assertResource($h)
    {
        return static::getInstance()->assertResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public static function assertOpenedResource($h)
    {
        return static::getInstance()->assertOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public static function assertClosedResource($h)
    {
        return static::getInstance()->assertClosedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public static function assertReadableResource($h)
    {
        return static::getInstance()->assertReadableResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public static function assertWritableResource($h)
    {
        return static::getInstance()->assertWritableResource($h);
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    public static function assertIntval($value): ?int
    {
        return static::getInstance()->assertIntval($value);
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public static function assertFloatval($value): ?float
    {
        return static::getInstance()->assertFloatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return int|float
     */
    public static function assertNumval($value)
    {
        return static::getInstance()->assertNumval($value);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function assertStrval($value): ?string
    {
        return static::getInstance()->assertStrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function assertTheStrval($value): ?string
    {
        return static::getInstance()->assertTheStrval($value);
    }

    /**
     * @return Assert
     */
    abstract public static function getInstance(): Assert;
}
