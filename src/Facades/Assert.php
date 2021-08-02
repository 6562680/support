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

use Gzhegow\Support\Domain\Debug\Message;
use Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Generated\GeneratedAssert;
use Gzhegow\Support\IAssert;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZAssert;

class Assert
{
    /**
     * @return Message
     */
    public static function getMessage(): Message
    {
        return static::getInstance()->getMessage();
    }

    /**
     * @param null|string|array $text
     * @param array             ...$arguments
     *
     * @return null|array
     */
    public static function getError($text = null, ...$arguments): ?array
    {
        return static::getInstance()->getError($text, ...$arguments);
    }

    /**
     * @param null|string|array $text
     * @param array             ...$arguments
     *
     * @return null|array
     */
    public static function getErrorOr($text = null, ...$arguments): ?array
    {
        return static::getInstance()->getErrorOr($text, ...$arguments);
    }

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public static function getThrowable(\Throwable $throwable = null)
    {
        return static::getInstance()->getThrowable($throwable);
    }

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public static function getThrowableOr(\Throwable $throwable = null)
    {
        return static::getInstance()->getThrowableOr($throwable);
    }

    /**
     * @param null|string|array|\Throwable $error
     * @param mixed                        ...$arguments
     *
     * @return \Gzhegow\Support\IAssert
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public static function assert($error = null, ...$arguments): IAssert
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
    public static function type(): \Gzhegow\Support\IType
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
     * @param bool|mixed $value
     *
     * @return bool
     */
    public static function assertBool($value): ?bool
    {
        return static::getInstance()->assertBool($value);
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public static function assertInt($value): ?int
    {
        return static::getInstance()->assertInt($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public static function assertFloat($value): ?float
    {
        return static::getInstance()->assertFloat($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public static function assertNan($value): ?float
    {
        return static::getInstance()->assertNan($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public static function assertNum($value)
    {
        return static::getInstance()->assertNum($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public static function assertIntval($value): ?int
    {
        return static::getInstance()->assertIntval($value);
    }

    /**
     * @param float|string|mixed $value
     *
     * @return float|string
     */
    public static function assertFloatval($value): ?float
    {
        return static::getInstance()->assertFloatval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public static function assertNumval($value)
    {
        return static::getInstance()->assertNumval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public static function assertNumericval($value)
    {
        return static::getInstance()->assertNumericval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function assertPositiveVal($value)
    {
        return static::getInstance()->assertPositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function assertNonNegativeVal($value)
    {
        return static::getInstance()->assertNonNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function assertNegativeVal($value)
    {
        return static::getInstance()->assertNegativeVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function assertNonPositiveVal($value)
    {
        return static::getInstance()->assertNonPositiveVal($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public static function assertPositiveIntval($value): ?int
    {
        return static::getInstance()->assertPositiveIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public static function assertNonNegativeIntval($value): ?int
    {
        return static::getInstance()->assertNonNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public static function assertNegativeIntval($value): ?int
    {
        return static::getInstance()->assertNegativeIntval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public static function assertNonPositiveIntval($value): ?int
    {
        return static::getInstance()->assertNonPositiveIntval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertString($value): ?string
    {
        return static::getInstance()->assertString($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertWord($value): ?string
    {
        return static::getInstance()->assertWord($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertUtf8($value): ?string
    {
        return static::getInstance()->assertUtf8($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public static function assertStringOrInt($value)
    {
        return static::getInstance()->assertStringOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public static function assertWordOrInt($value)
    {
        return static::getInstance()->assertWordOrInt($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public static function assertStringOrNum($value)
    {
        return static::getInstance()->assertStringOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public static function assertWordOrNum($value)
    {
        return static::getInstance()->assertWordOrNum($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertStrval($value): ?string
    {
        return static::getInstance()->assertStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertWordval($value): ?string
    {
        return static::getInstance()->assertWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertTrimval($value): ?string
    {
        return static::getInstance()->assertTrimval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public static function assertKey($value)
    {
        return static::getInstance()->assertKey($value);
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return array
     */
    public static function assertArray($array, callable $of = null): ?array
    {
        return static::getInstance()->assertArray($array, $of);
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return array
     */
    public static function assertList($list, callable $of = null): ?array
    {
        return static::getInstance()->assertList($list, $of);
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return array
     */
    public static function assertDict($dict, callable $of = null): ?array
    {
        return static::getInstance()->assertDict($dict, $of);
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return array
     */
    public static function assertAssoc($assoc, callable $of = null): ?array
    {
        return static::getInstance()->assertAssoc($assoc, $of);
    }

    /**
     * Array that contains array
     *
     * @param array|mixed $array
     *
     * @return array
     */
    public static function assertDeepArray($array): ?array
    {
        return static::getInstance()->assertDeepArray($array);
    }

    /**
     * Array that can be safely serialized
     *
     * @param array|mixed $array
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
     * @return mixed
     */
    public static function assertArrval($value)
    {
        return static::getInstance()->assertArrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertLink($value): ?string
    {
        return static::getInstance()->assertLink($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertUrl($value): ?string
    {
        return static::getInstance()->assertUrl($value);
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfo                   $invokableInfo
     *
     * @return string|array|\Closure|callable
     */
    public static function assertCallable($callable, InvokableInfo &$invokableInfo = null)
    {
        return static::getInstance()->assertCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfo          $invokableInfo
     *
     * @return string|array|callable
     */
    public static function assertCallableString($callableString, InvokableInfo &$invokableInfo = null)
    {
        return static::getInstance()->assertCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return string|callable
     */
    public static function assertCallableStringFunction($callableString, InvokableInfo &$invokableInfo = null): ?string
    {
        return static::getInstance()->assertCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return string|callable
     */
    public static function assertCallableStringStatic($callableString, InvokableInfo &$invokableInfo = null): ?string
    {
        return static::getInstance()->assertCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArray($callableArray, InvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArrayStatic($callableArray, InvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArrayPublic($callableArray, InvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed     $closure
     * @param null|InvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public static function assertClosure($closure, InvokableInfo &$invokableInfo = null): ?\Closure
    {
        return static::getInstance()->assertClosure($closure, $invokableInfo);
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return array
     */
    public static function assertMethodArray($methodArray): ?array
    {
        return static::getInstance()->assertMethodArray($methodArray);
    }

    /**
     * @param array|mixed        $methodArray
     * @param null|InvokableInfo $invokableInfo
     *
     * @return array
     */
    public static function assertMethodArrayReflection($methodArray, InvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->assertMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed       $handler
     * @param null|InvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public static function assertHandler($handler, InvokableInfo &$invokableInfo = null): ?string
    {
        return static::getInstance()->assertHandler($handler, $invokableInfo);
    }

    /**
     * @param string|mixed $className
     *
     * @return string
     */
    public static function assertClassName($className): ?string
    {
        return static::getInstance()->assertClassName($className);
    }

    /**
     * @param string|mixed $class
     *
     * @return string
     */
    public static function assertClassFQN($class): ?string
    {
        return static::getInstance()->assertClassFQN($class);
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public static function assertThrowable($value)
    {
        return static::getInstance()->assertThrowable($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public static function assertError($value)
    {
        return static::getInstance()->assertError($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public static function assertException($value)
    {
        return static::getInstance()->assertException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public static function assertRuntimeException($value)
    {
        return static::getInstance()->assertRuntimeException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public static function assertLogicException($value)
    {
        return static::getInstance()->assertLogicException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public static function assertStdClass($value)
    {
        return static::getInstance()->assertStdClass($value);
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return \SplFileInfo
     */
    public static function assertFileInfo($value): ?\SplFileInfo
    {
        return static::getInstance()->assertFileInfo($value);
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return \SplFileObject
     */
    public static function assertFileObject($value): ?\SplFileObject
    {
        return static::getInstance()->assertFileObject($value);
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return \ReflectionClass
     */
    public static function assertReflectionClass($value): ?\ReflectionClass
    {
        return static::getInstance()->assertReflectionClass($value);
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return \ReflectionFunction
     */
    public static function assertReflectionFunction($value): ?\ReflectionFunction
    {
        return static::getInstance()->assertReflectionFunction($value);
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return \ReflectionMethod
     */
    public static function assertReflectionMethod($value): ?\ReflectionMethod
    {
        return static::getInstance()->assertReflectionMethod($value);
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return \ReflectionProperty
     */
    public static function assertReflectionProperty($value): ?\ReflectionProperty
    {
        return static::getInstance()->assertReflectionProperty($value);
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return \ReflectionParameter
     */
    public static function assertReflectionParameter($value): ?\ReflectionParameter
    {
        return static::getInstance()->assertReflectionParameter($value);
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return \ReflectionType
     */
    public static function assertReflectionType($value): ?\ReflectionType
    {
        return static::getInstance()->assertReflectionType($value);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return \ReflectionUnionType
     */
    public static function assertReflectionUnionType($reflectionType)
    {
        return static::getInstance()->assertReflectionUnionType($reflectionType);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return \ReflectionNamedType
     */
    public static function assertReflectionNamedType($reflectionType)
    {
        return static::getInstance()->assertReflectionNamedType($reflectionType);
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public static function assertResource($h)
    {
        return static::getInstance()->assertResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public static function assertOpenedResource($h)
    {
        return static::getInstance()->assertOpenedResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public static function assertClosedResource($h)
    {
        return static::getInstance()->assertClosedResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public static function assertReadableResource($h)
    {
        return static::getInstance()->assertReadableResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public static function assertWritableResource($h)
    {
        return static::getInstance()->assertWritableResource($h);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return resource|\CurlHandle
     */
    public static function assertCurl($ch)
    {
        return static::getInstance()->assertCurl($ch);
    }

    /**
     * @return IAssert
     */
    public static function getInstance(): IAssert
    {
        return SupportFactory::getInstance()->getAssert();
    }
}
