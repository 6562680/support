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
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;

interface IFilter
{
    /**
     * @return callable[]
     */
    public function getCustomFilters(): array;

    /**
     * @param string   $filter
     * @param \Closure $callable
     *
     * @return ZFilter
     */
    public function addCustomFilter(string $filter, \Closure $callable);

    /**
     * @param string   $filter
     * @param \Closure $callable
     *
     * @return ZFilter
     */
    public function replaceCustomFilter(string $filter, \Closure $callable);

    /**
     * @param bool|mixed $value
     *
     * @return null|bool
     */
    public function filterBool($value): ?bool;

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function filterInt($value): ?int;

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function filterFloat($value): ?float;

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function filterNan($value): ?float;

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function filterNum($value);

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterIntval($value): ?int;

    /**
     * @param float|string|mixed $value
     *
     * @return null|float|string
     */
    public function filterFloatval($value): ?float;

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumval($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumericval($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterPositiveVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNonNegativeVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNegativeVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNonPositiveVal($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function filterPositiveIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function filterNonNegativeIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function filterNegativeIntval($value): ?int;

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int
     */
    public function filterNonPositiveIntval($value): ?int;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterString($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLetter($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterWord($value): ?string;

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrInt($value);

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrInt($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrNum($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrNum($value);

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterStrval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLetterval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterWordval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterTrimval($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterUtf8($value): ?string;

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterKey($value);

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterArray($array, callable $of = null): ?array;

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterList($list, callable $of = null): ?array;

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterDict($dict, callable $of = null): ?array;

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterAssoc($assoc, callable $of = null): ?array;

    /**
     * Array that contains array
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public function filterDeepArray($array): ?array;

    /**
     * Array that can be safely serialized
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public function filterPlainArray($array): ?array;

    /**
     * @param mixed $value
     *
     * @return null|mixed
     */
    public function filterArrval($value);

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLink($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterUrl($value): ?string;

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfo                   $invokableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public function filterCallable($callable, InvokableInfo &$invokableInfo = null);

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfo          $invokableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableString($callableString, InvokableInfo &$invokableInfo = null);

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringFunction($callableString, InvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringStatic($callableString, InvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArray($callableArray, InvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayStatic($callableArray, InvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayPublic($callableArray, InvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param \Closure|mixed     $closure
     * @param null|InvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterClosure($closure, InvokableInfo &$invokableInfo = null): ?\Closure;

    /**
     * @param array|mixed $methodArray
     *
     * @return null|array
     */
    public function filterMethodArray($methodArray): ?array;

    /**
     * @param array|mixed        $methodArray
     * @param null|InvokableInfo $invokableInfo
     *
     * @return null|array
     */
    public function filterMethodArrayReflection($methodArray, InvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param string|mixed       $handler
     * @param null|InvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterHandler($handler, InvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param string|mixed $className
     *
     * @return null|string
     */
    public function filterClassName($className): ?string;

    /**
     * @param string|mixed $classFullname
     *
     * @return null|string
     */
    public function filterClassFullname($classFullname): ?string;

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterThrowable($value);

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterError($value);

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterException($value);

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterRuntimeException($value);

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterLogicException($value);

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterStdClass($value);

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterFileInfo($value): ?\SplFileInfo;

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return null|\SplFileObject
     */
    public function filterFileObject($value): ?\SplFileObject;

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return null|\ReflectionClass
     */
    public function filterReflectionClass($value): ?\ReflectionClass;

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return null|\ReflectionFunction
     */
    public function filterReflectionFunction($value): ?\ReflectionFunction;

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return null|\ReflectionMethod
     */
    public function filterReflectionMethod($value): ?\ReflectionMethod;

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return null|\ReflectionProperty
     */
    public function filterReflectionProperty($value): ?\ReflectionProperty;

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return null|\ReflectionParameter
     */
    public function filterReflectionParameter($value): ?\ReflectionParameter;

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return null|\ReflectionType
     */
    public function filterReflectionType($value): ?\ReflectionType;

    /**
     * @param mixed $reflectionType
     *
     * @return null|\ReflectionUnionType
     */
    public function filterReflectionUnionType($reflectionType);

    /**
     * @param mixed $reflectionType
     *
     * @return null|\ReflectionNamedType
     */
    public function filterReflectionNamedType($reflectionType);

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResource($h);

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterOpenedResource($h);

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterClosedResource($h);

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterReadableResource($h);

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterWritableResource($h);

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurl($ch);

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
     * @param string $filter
     * @param mixed  ...$arguments
     *
     * @return \Closure
     */
    public function bind(string $filter, ...$arguments): \Closure;

    /**
     * @param string $filter
     *
     * @return null|\Closure
     */
    public function findCustomFilter(string $filter): ?\Closure;
}
