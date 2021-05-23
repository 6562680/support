<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Domain\Filter\CallableInfo;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Type;

abstract class GeneratedTypeFacade
{
    /**
     * @param string $filter
     * @param mixed ...$arguments
     *
     * @return bool
     */
    public static function is(string $filter, ...$arguments): bool
    {
        return static::getInstance()->is($filter, ...$arguments);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isKey($value): bool
    {
        return static::getInstance()->isKey($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isInt($value): ?bool
    {
        return static::getInstance()->isInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFloat($value): ?bool
    {
        return static::getInstance()->isFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isNan($value): ?bool
    {
        return static::getInstance()->isNan($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isNumber($value): bool
    {
        return static::getInstance()->isNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isTheString($value): ?bool
    {
        return static::getInstance()->isTheString($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isStringOrNumber($value): bool
    {
        return static::getInstance()->isStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isTheStringOrNumber($value): bool
    {
        return static::getInstance()->isTheStringOrNumber($value);
    }

    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isArray($array, callable $of = null): ?bool
    {
        return static::getInstance()->isArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isList($list, callable $of = null): ?bool
    {
        return static::getInstance()->isList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isDict($dict, callable $of = null): ?bool
    {
        return static::getInstance()->isDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isAssoc($assoc, callable $of = null): ?bool
    {
        return static::getInstance()->isAssoc($assoc, $of);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isLink($value): ?bool
    {
        return static::getInstance()->isLink($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isUrl($value): ?bool
    {
        return static::getInstance()->isUrl($value);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallable($callable, CallableInfo &$callableInfo = null): bool
    {
        return static::getInstance()->isCallable($callable, $callableInfo);
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableString($callableString, CallableInfo &$callableInfo = null): bool
    {
        return static::getInstance()->isCallableString($callableString, $callableInfo);
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableStringFunction($callableString, CallableInfo &$callableInfo = null): ?bool
    {
        return static::getInstance()->isCallableStringFunction($callableString, $callableInfo);
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableStringStatic($callableString, CallableInfo &$callableInfo = null): ?bool
    {
        return static::getInstance()->isCallableStringStatic($callableString, $callableInfo);
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableArray($callableArray, CallableInfo &$callableInfo = null): ?bool
    {
        return static::getInstance()->isCallableArray($callableArray, $callableInfo);
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableArrayStatic($callableArray, CallableInfo &$callableInfo = null): ?bool
    {
        return static::getInstance()->isCallableArrayStatic($callableArray, $callableInfo);
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableArrayPublic($callableArray, CallableInfo &$callableInfo = null): ?bool
    {
        return static::getInstance()->isCallableArrayPublic($callableArray, $callableInfo);
    }

    /**
     * @param mixed             $closure
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isClosure($closure, CallableInfo &$callableInfo = null): ?bool
    {
        return static::getInstance()->isClosure($closure, $callableInfo);
    }

    /**
     * @param mixed $class
     *
     * @return bool
     */
    public static function isClass($class): ?bool
    {
        return static::getInstance()->isClass($class);
    }

    /**
     * @param mixed $className
     *
     * @return bool
     */
    public static function isClassName($className): ?bool
    {
        return static::getInstance()->isClassName($className);
    }

    /**
     * @param object $value
     *
     * @return bool
     */
    public static function isStdClass($value): bool
    {
        return static::getInstance()->isStdClass($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFileInfo($value): ?bool
    {
        return static::getInstance()->isFileInfo($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFileObject($value): ?bool
    {
        return static::getInstance()->isFileObject($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isReflectionClass($value): ?bool
    {
        return static::getInstance()->isReflectionClass($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isReflectionFunction($value): ?bool
    {
        return static::getInstance()->isReflectionFunction($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isReflectionMethod($value): ?bool
    {
        return static::getInstance()->isReflectionMethod($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isReflectionProperty($value): ?bool
    {
        return static::getInstance()->isReflectionProperty($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isReflectionParameter($value): ?bool
    {
        return static::getInstance()->isReflectionParameter($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isReflectionType($value): ?bool
    {
        return static::getInstance()->isReflectionType($value);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public static function isOpenedResource($h): bool
    {
        return static::getInstance()->isOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public static function isClosedResource($h): bool
    {
        return static::getInstance()->isClosedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public static function isReadableResource($h): bool
    {
        return static::getInstance()->isReadableResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public static function isWritableResource($h): bool
    {
        return static::getInstance()->isWritableResource($h);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isIntval($value): ?bool
    {
        return static::getInstance()->isIntval($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFloatval($value): ?bool
    {
        return static::getInstance()->isFloatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isNumval($value): bool
    {
        return static::getInstance()->isNumval($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isStrval($value): ?bool
    {
        return static::getInstance()->isStrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isTheStrval($value): ?bool
    {
        return static::getInstance()->isTheStrval($value);
    }

    /**
     * @return Type
     */
    abstract public static function getInstance(): Type;
}
