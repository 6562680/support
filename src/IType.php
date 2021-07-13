<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo;
use Gzhegow\Support\Generated\GeneratedType;

interface IType
{
    /**
     * @param null|string|array|\Throwable $error
     * @param mixed                        ...$arguments
     *
     * @return \Gzhegow\Support\IAssert
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function assert($error = null, ...$arguments): IAssert;

    /**
     * @return \Gzhegow\Support\IFilter
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function filter(): IFilter;

    /**
     * @return \Gzhegow\Support\IType
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function type(): IType;

    /**
     * @param string $customFilter
     * @param mixed  ...$arguments
     *
     * @return null|mixed
     */
    public function call(string $customFilter, ...$arguments);

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public function isBool($value): ?bool;

    /**
     * @param int|mixed $value
     *
     * @return bool
     */
    public function isInt($value): ?bool;

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public function isFloat($value): ?bool;

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public function isNan($value): ?bool;

    /**
     * @param int|float|mixed $value
     *
     * @return bool
     */
    public function isNum($value): bool;

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isIntval($value): ?bool;

    /**
     * @param float|string|mixed $value
     *
     * @return bool
     */
    public function isFloatval($value): ?bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumval($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumericval($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isPositiveVal($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNonNegativeVal($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNegativeVal($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNonPositiveVal($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isPositiveIntval($value): ?bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNonNegativeIntval($value): ?bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNegativeIntval($value): ?bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNonPositiveIntval($value): ?bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isString($value): ?bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isWord($value): ?bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isUtf8($value): ?bool;

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isStringOrInt($value): bool;

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isWordOrInt($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isStringOrNum($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isWordOrNum($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isStrval($value): ?bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isWordval($value): ?bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isTrimval($value): ?bool;

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isKey($value): bool;

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return bool
     */
    public function isArray($array, callable $of = null): ?bool;

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return bool
     */
    public function isList($list, callable $of = null): ?bool;

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public function isDict($dict, callable $of = null): ?bool;

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public function isAssoc($assoc, callable $of = null): ?bool;

    /**
     * Array that contains array
     *
     * @param array|mixed $array
     *
     * @return bool
     */
    public function isDeepArray($array): ?bool;

    /**
     * Array that can be safely serialized
     *
     * @param array|mixed $array
     *
     * @return bool
     */
    public function isPlainArray($array): ?bool;

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isArrval($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isLink($value): ?bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isUrl($value): ?bool;

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfo                   $invokableInfo
     *
     * @return bool
     */
    public function isCallable($callable, InvokableInfo &$invokableInfo = null): bool;

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfo          $invokableInfo
     *
     * @return bool
     */
    public function isCallableString($callableString, InvokableInfo &$invokableInfo = null): bool;

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringFunction($callableString, InvokableInfo &$invokableInfo = null): ?bool;

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringStatic($callableString, InvokableInfo &$invokableInfo = null): ?bool;

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return bool
     */
    public function isCallableArray($callableArray, InvokableInfo &$invokableInfo = null): ?bool;

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayStatic($callableArray, InvokableInfo &$invokableInfo = null): ?bool;

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayPublic($callableArray, InvokableInfo &$invokableInfo = null): ?bool;

    /**
     * @param \Closure|mixed     $closure
     * @param null|InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isClosure($closure, InvokableInfo &$invokableInfo = null): ?bool;

    /**
     * @param array|mixed $methodArray
     *
     * @return bool
     */
    public function isMethodArray($methodArray): ?bool;

    /**
     * @param array|mixed        $methodArray
     * @param null|InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isMethodArrayReflection($methodArray, InvokableInfo &$invokableInfo = null): ?bool;

    /**
     * @param string|mixed       $handler
     * @param null|InvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isHandler($handler, InvokableInfo &$invokableInfo = null): ?bool;

    /**
     * @param string|mixed $class
     *
     * @return bool
     */
    public function isClass($class): ?bool;

    /**
     * @param string|mixed $className
     *
     * @return bool
     */
    public function isClassName($className): ?bool;

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isThrowable($value): bool;

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isError($value): bool;

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isException($value): bool;

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isRuntimeException($value): bool;

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isLogicException($value): bool;

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isStdClass($value): bool;

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return bool
     */
    public function isFileInfo($value): ?bool;

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return bool
     */
    public function isFileObject($value): ?bool;

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return bool
     */
    public function isReflectionClass($value): ?bool;

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return bool
     */
    public function isReflectionFunction($value): ?bool;

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return bool
     */
    public function isReflectionMethod($value): ?bool;

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return bool
     */
    public function isReflectionProperty($value): ?bool;

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return bool
     */
    public function isReflectionParameter($value): ?bool;

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return bool
     */
    public function isReflectionType($value): ?bool;

    /**
     * @param mixed $reflectionType
     *
     * @return bool
     */
    public function isReflectionUnionType($reflectionType): bool;

    /**
     * @param mixed $reflectionType
     *
     * @return bool
     */
    public function isReflectionNamedType($reflectionType): bool;

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResource($h): bool;

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isOpenedResource($h): bool;

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isClosedResource($h): bool;

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isReadableResource($h): bool;

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isWritableResource($h): bool;

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return bool
     */
    public function isCurl($ch): bool;
}
