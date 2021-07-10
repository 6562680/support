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

use Gzhegow\Support\Domain\Debug\Message;
use Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Generated\GeneratedAssert;

interface IAssert
{
    /**
     * @return Message
     */
    public function getMessage(): Message;

    /**
     * @param null|string|array $text
     * @param array             ...$arguments
     *
     * @return null|array
     */
    public function getError($text = null, ...$arguments): ?array;

    /**
     * @param null|string|array $text
     * @param array             ...$arguments
     *
     * @return null|array
     */
    public function getErrorOr($text = null, ...$arguments): ?array;

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public function getThrowable(\Throwable $throwable = null);

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public function getThrowableOr(\Throwable $throwable = null);

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
    public function assertBool($value): ?bool;

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function assertInt($value): ?int;

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function assertFloat($value): ?float;

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function assertNan($value): ?float;

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function assertNum($value);

    /**
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertIntval($value): ?int;

    /**
     * @param float|string|mixed $value
     *
     * @return float|string
     */
    public function assertFloatval($value): ?float;

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertNumval($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertNumericval($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertPositiveVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNonNegativeVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNegativeVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNonPositiveVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function assertPositiveIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function assertNonNegativeIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function assertNegativeIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return int
     */
    public function assertNonPositiveIntval($value): ?int;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertString($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertWord($value): ?string;

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrInt($value);

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrInt($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrNum($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrNum($value);

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertStrval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertWordval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertTrimval($value): ?string;

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertKey($value);

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return array
     */
    public function assertArray($array, callable $of = null): ?array;

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return array
     */
    public function assertList($list, callable $of = null): ?array;

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return array
     */
    public function assertDict($dict, callable $of = null): ?array;

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return array
     */
    public function assertAssoc($assoc, callable $of = null): ?array;

    /**
     * @param array|mixed $array
     *
     * @return array
     */
    public function assertPlainArray($array): ?array;

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function assertArrval($value);

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertLink($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertUrl($value): ?string;

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfo                   $invokableInfo
     *
     * @return string|array|\Closure|callable
     */
    public function assertCallable($callable, InvokableInfo &$invokableInfo = null);

    /**
     * @param string|array|callable|mixed                                   $callableString
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return string|array|callable
     */
    public function assertCallableString($callableString, InvokableInfo &$invokableInfo = null);

    /**
     * @param string|callable|mixed                                         $callableString
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringFunction($callableString, InvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param string|callable|mixed                                         $callableString
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringStatic($callableString, InvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param array|callable|mixed                                          $callableArray
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArray($callableArray, InvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param array|callable|mixed                                          $callableArray
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayStatic($callableArray, InvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param array|callable|mixed                                          $callableArray
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayPublic($callableArray, InvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param \Closure|mixed                                                $closure
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public function assertClosure($closure, InvokableInfo &$invokableInfo = null): ?\Closure;

    /**
     * @param array|mixed $methodArray
     *
     * @return array
     */
    public function assertMethodArray($methodArray): ?array;

    /**
     * @param array|mixed                                                   $methodArray
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return array
     */
    public function assertMethodArrayReflection($methodArray, InvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param string|mixed                                                  $handler
     * @param null|\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertHandler($handler, InvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param string|mixed $class
     *
     * @return string
     */
    public function assertClass($class): ?string;

    /**
     * @param string|mixed $className
     *
     * @return string
     */
    public function assertClassName($className): ?string;

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertThrowable($value);

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertException($value);

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertRuntimeException($value);

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertLogicException($value);

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertStdClass($value);

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return \SplFileInfo
     */
    public function assertFileInfo($value): ?\SplFileInfo;

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return \SplFileObject
     */
    public function assertFileObject($value): ?\SplFileObject;

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return \ReflectionClass
     */
    public function assertReflectionClass($value): ?\ReflectionClass;

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return \ReflectionFunction
     */
    public function assertReflectionFunction($value): ?\ReflectionFunction;

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return \ReflectionMethod
     */
    public function assertReflectionMethod($value): ?\ReflectionMethod;

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return \ReflectionProperty
     */
    public function assertReflectionProperty($value): ?\ReflectionProperty;

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return \ReflectionParameter
     */
    public function assertReflectionParameter($value): ?\ReflectionParameter;

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return \ReflectionType
     */
    public function assertReflectionType($value): ?\ReflectionType;

    /**
     * @param mixed $reflectionType
     *
     * @return \ReflectionUnionType
     */
    public function assertReflectionUnionType($reflectionType);

    /**
     * @param mixed $reflectionType
     *
     * @return \ReflectionNamedType
     */
    public function assertReflectionNamedType($reflectionType);

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResource($h);

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertOpenedResource($h);

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertClosedResource($h);

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertReadableResource($h);

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertWritableResource($h);

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return resource|\CurlHandle
     */
    public function assertCurl($ch);
}
