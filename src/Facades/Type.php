<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo;
use Gzhegow\Support\Generated\GeneratedType;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\IType;
use Gzhegow\Support\ZType;

class Type
{
    /**
     * @param null|string|array|\Throwable $error
     * @param mixed                        ...$arguments
     *
     * @return \Gzhegow\Support\IAssert
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public static function assert($error = null, ...$arguments): \Gzhegow\Support\IAssert
    {
        return static::getInstance()->assert($error, ...$arguments);
    }

    /**
     * @return \Gzhegow\Support\IFilter
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public static function filter(): IFilter
    {
        return static::getInstance()->filter();
    }

    /**
     * @return \Gzhegow\Support\IType
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public static function type(): IType
    {
        return static::getInstance()->type();
    }

    /**
     * @return IType
     */
    public static function getInstance()
    {
        return static::getInstance()->getInstance();
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
     * @param bool|mixed $value
     *
     * @return bool
     */
    public static function isBool($value): ?bool
    {
        return static::getInstance()->isBool($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return bool
     */
    public static function isInt($value): ?bool
    {
        return static::getInstance()->isInt($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public static function isFloat($value): ?bool
    {
        return static::getInstance()->isFloat($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public static function isNan($value): ?bool
    {
        return static::getInstance()->isNan($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return bool
     */
    public static function isNum($value): bool
    {
        return static::getInstance()->isNum($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public static function isIntval($value): ?bool
    {
        return static::getInstance()->isIntval($value);
    }

    /**
     * @param float|string|mixed $value
     *
     * @return bool
     */
    public static function isFloatval($value): ?bool
    {
        return static::getInstance()->isFloatval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNumval($value): bool
    {
        return static::getInstance()->isNumval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNumericval($value): bool
    {
        return static::getInstance()->isNumericval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isPositiveVal($value): bool
    {
        return static::getInstance()->isPositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNonNegativeVal($value): bool
    {
        return static::getInstance()->isNonNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNegativeVal($value): bool
    {
        return static::getInstance()->isNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNonPositiveVal($value): bool
    {
        return static::getInstance()->isNonPositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isPositiveIntval($value): ?bool
    {
        return static::getInstance()->isPositiveIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNonNegativeIntval($value): ?bool
    {
        return static::getInstance()->isNonNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNegativeIntval($value): ?bool
    {
        return static::getInstance()->isNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNonPositiveIntval($value): ?bool
    {
        return static::getInstance()->isNonPositiveIntval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isString($value): ?bool
    {
        return static::getInstance()->isString($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isWord($value): ?bool
    {
        return static::getInstance()->isWord($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public static function isStringOrInt($value): bool
    {
        return static::getInstance()->isStringOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public static function isWordOrInt($value): bool
    {
        return static::getInstance()->isWordOrInt($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isStringOrNum($value): bool
    {
        return static::getInstance()->isStringOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isWordOrNum($value): bool
    {
        return static::getInstance()->isWordOrNum($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isStrval($value): ?bool
    {
        return static::getInstance()->isStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isWordval($value): ?bool
    {
        return static::getInstance()->isWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isTrimval($value): ?bool
    {
        return static::getInstance()->isTrimval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public static function isKey($value): bool
    {
        return static::getInstance()->isKey($value);
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isArray($array, callable $of = null): ?bool
    {
        return static::getInstance()->isArray($array, $of);
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isList($list, callable $of = null): ?bool
    {
        return static::getInstance()->isList($list, $of);
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isDict($dict, callable $of = null): ?bool
    {
        return static::getInstance()->isDict($dict, $of);
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isAssoc($assoc, callable $of = null): ?bool
    {
        return static::getInstance()->isAssoc($assoc, $of);
    }

    /**
     * @param array|mixed $array
     *
     * @return bool
     */
    public static function isPlainArray($array): ?bool
    {
        return static::getInstance()->isPlainArray($array);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isArrval($value): bool
    {
        return static::getInstance()->isArrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isLink($value): ?bool
    {
        return static::getInstance()->isLink($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isUrl($value): ?bool
    {
        return static::getInstance()->isUrl($value);
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfo                   $invokableInfo
     *
     * @return bool
     */
    public static function isCallable($callable, InvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed                                   $callableString
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableString($callableString, InvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed                                         $callableString
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableStringFunction($callableString, InvokableInfo &$invokableInfo = null): ?bool
    {
        return static::getInstance()->isCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed                                         $callableString
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableStringStatic($callableString, InvokableInfo &$invokableInfo = null): ?bool
    {
        return static::getInstance()->isCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed                                          $callableArray
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableArray($callableArray, InvokableInfo &$invokableInfo = null): ?bool
    {
        return static::getInstance()->isCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed                                          $callableArray
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableArrayStatic($callableArray, InvokableInfo &$invokableInfo = null): ?bool
    {
        return static::getInstance()->isCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed                                          $callableArray
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableArrayPublic($callableArray, InvokableInfo &$invokableInfo = null): ?bool
    {
        return static::getInstance()->isCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed                                                $closure
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isClosure($closure, InvokableInfo &$invokableInfo = null): ?bool
    {
        return static::getInstance()->isClosure($closure, $invokableInfo);
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return bool
     */
    public static function isMethodArray($methodArray): ?bool
    {
        return static::getInstance()->isMethodArray($methodArray);
    }

    /**
     * @param array|mixed                                                   $methodArray
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isMethodArrayReflection($methodArray, InvokableInfo &$invokableInfo = null): ?bool
    {
        return static::getInstance()->isMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed                                                  $handler
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isHandler($handler, InvokableInfo &$invokableInfo = null): ?bool
    {
        return static::getInstance()->isHandler($handler, $invokableInfo);
    }

    /**
     * @param string|mixed $class
     *
     * @return bool
     */
    public static function isClass($class): ?bool
    {
        return static::getInstance()->isClass($class);
    }

    /**
     * @param string|mixed $className
     *
     * @return bool
     */
    public static function isClassName($className): ?bool
    {
        return static::getInstance()->isClassName($className);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public static function isThrowable($value): bool
    {
        return static::getInstance()->isThrowable($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public static function isException($value): bool
    {
        return static::getInstance()->isException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public static function isRuntimeException($value): bool
    {
        return static::getInstance()->isRuntimeException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public static function isLogicException($value): bool
    {
        return static::getInstance()->isLogicException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public static function isStdClass($value): bool
    {
        return static::getInstance()->isStdClass($value);
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return bool
     */
    public static function isFileInfo($value): ?bool
    {
        return static::getInstance()->isFileInfo($value);
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return bool
     */
    public static function isFileObject($value): ?bool
    {
        return static::getInstance()->isFileObject($value);
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return bool
     */
    public static function isReflectionClass($value): ?bool
    {
        return static::getInstance()->isReflectionClass($value);
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return bool
     */
    public static function isReflectionFunction($value): ?bool
    {
        return static::getInstance()->isReflectionFunction($value);
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return bool
     */
    public static function isReflectionMethod($value): ?bool
    {
        return static::getInstance()->isReflectionMethod($value);
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return bool
     */
    public static function isReflectionProperty($value): ?bool
    {
        return static::getInstance()->isReflectionProperty($value);
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return bool
     */
    public static function isReflectionParameter($value): ?bool
    {
        return static::getInstance()->isReflectionParameter($value);
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return bool
     */
    public static function isReflectionType($value): ?bool
    {
        return static::getInstance()->isReflectionType($value);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return bool
     */
    public static function isReflectionUnionType($reflectionType): bool
    {
        return static::getInstance()->isReflectionUnionType($reflectionType);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return bool
     */
    public static function isReflectionNamedType($reflectionType): bool
    {
        return static::getInstance()->isReflectionNamedType($reflectionType);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public static function isResource($h): bool
    {
        return static::getInstance()->isResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public static function isOpenedResource($h): bool
    {
        return static::getInstance()->isOpenedResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public static function isClosedResource($h): bool
    {
        return static::getInstance()->isClosedResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public static function isReadableResource($h): bool
    {
        return static::getInstance()->isReadableResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public static function isWritableResource($h): bool
    {
        return static::getInstance()->isWritableResource($h);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return bool
     */
    public static function isCurl($ch): bool
    {
        return static::getInstance()->isCurl($ch);
    }
}
