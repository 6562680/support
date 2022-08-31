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

use Gzhegow\Support\Domain\Debug\DebugMessage;
use Gzhegow\Support\Domain\Math\ValueObject\MathBcval;
use Gzhegow\Support\Domain\Php\ValueObject\PhpInvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Generated\GeneratedFilter;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\CalendarLoadTrait;
use Gzhegow\Support\Traits\Load\CurlLoadTrait;
use Gzhegow\Support\Traits\Load\DebugLoadTrait;
use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\LoaderLoadTrait;
use Gzhegow\Support\Traits\Load\MathLoadTrait;
use Gzhegow\Support\Traits\Load\NetLoadTrait;
use Gzhegow\Support\Traits\Load\NumLoadTrait;
use Gzhegow\Support\Traits\Load\PhpLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Traits\Load\UriLoadTrait;

interface IFilter
{
    /**
     * @param null|string|array $text
     * @param array             ...$placeholders
     *
     * @return null|array
     */
    public function getMessageOr($text = null, ...$placeholders): ?array;

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public function getThrowableOr(\Throwable $throwable = null);

    /**
     * @param null|string|array|\Throwable $assert
     * @param mixed                        ...$placeholders
     *
     * @return XFilter
     */
    public function assert($assert, ...$placeholders);

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return bool
     */
    public function isArray($array, callable $of = null): bool;

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return bool
     */
    public function isList($list, callable $of = null): bool;

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public function isDict($dict, callable $of = null): bool;

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public function isAssoc($assoc, callable $of = null): bool;

    /**
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return bool
     */
    public function isArrayDeep($array, int $depth = null): bool;

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return bool
     */
    public function isArrayPlain($array): bool;

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isArrval($value): bool;

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isArrayKey($value): bool;

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isDateTimeInterface($date): bool;

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return bool
     */
    public function isDateTimeImmutable($date): bool;

    /**
     * @param \DateTime|mixed $date
     *
     * @return bool
     */
    public function isDateTime($date): bool;

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return bool
     */
    public function isDateTimeZone($timezone): bool;

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return bool
     */
    public function isDateInterval($interval): bool;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isIDate($date): bool;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isDate($date): bool;

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return bool
     */
    public function isTimezone($timezone): bool;

    /**
     * @param string|\DateInterval $interval
     *
     * @return bool
     */
    public function isInterval($interval): bool;

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return bool
     */
    public function isCurl($ch): bool;

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return bool
     */
    public function isCurlFresh($ch): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isFilename($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPath($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathFileExists($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathDir($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathLink($value): bool;

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathFile($value): bool;

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return bool
     */
    public function isPathImage($value, $mimetypes = null): bool;

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
    public function isResourceOpened($h): bool;

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResourceClosed($h): bool;

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResourceReadable($h): bool;

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResourceWritable($h): bool;

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return bool
     */
    public function isFileInfo($value): bool;

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return bool
     */
    public function isFileObject($value): bool;

    /**
     * @param string|mixed $className
     *
     * @return bool
     */
    public function isClassName($className): bool;

    /**
     * @param string|mixed $classFullname
     *
     * @return bool
     */
    public function isClassFullname($classFullname): bool;

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isClassOneOf($value, $classes): bool;

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isSubclassOneOf($value, $classes): bool;

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isInstanceOneOf($object, $classes): bool;

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return bool
     */
    public function isContract($object, $contract): bool;

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return bool
     */
    public function isReflectionClass($value): bool;

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return bool
     */
    public function isReflectionFunction($value): bool;

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return bool
     */
    public function isReflectionMethod($value): bool;

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return bool
     */
    public function isReflectionProperty($value): bool;

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return bool
     */
    public function isReflectionParameter($value): bool;

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return bool
     */
    public function isReflectionType($value): bool;

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
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isAlgorism($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isAlgorismval($value): bool;

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public function isBcGt0($value): bool;

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public function isBcGte0($value): bool;

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public function isBcLt0($value): bool;

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public function isBcLte0($value): bool;

    /**
     * @param string $ip
     *
     * @return bool
     */
    public function isIp(string $ip): bool;

    /**
     * @param string $mask
     *
     * @return bool
     */
    public function isMask(string $mask): bool;

    /**
     * @param int|mixed $value
     *
     * @return bool
     */
    public function isInt($value): bool;

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public function isFloat($value): bool;

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public function isNan($value): bool;

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
    public function isIntval($value): bool;

    /**
     * @param float|string|mixed $value
     *
     * @return bool
     */
    public function isFloatval($value): bool;

    /**
     * @param int|float|mixed $value
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
    public function isNumGt0($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumGte0($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumLt0($value): bool;

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumLte0($value): bool;

    /**
     * @param string|mixed $phpKeyword
     *
     * @return bool
     */
    public function isPhpKeyword($phpKeyword): bool;

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public function isBool($value): bool;

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return bool
     */
    public function isCallable($callable, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return bool
     */
    public function isCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return bool
     */
    public function isCallableString($callableString, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringFunction($callableString, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isClosure($closure, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param array|mixed $methodArray
     *
     * @return bool
     */
    public function isMethodArray($methodArray): bool;

    /**
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): bool;

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isHandler($handler, PhpInvokableInfo &$invokableInfo = null): bool;

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
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isStringUtf8($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isString($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isLetter($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isWord($value): bool;

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
    public function isLetterOrInt($value): bool;

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
    public function isLetterOrNum($value): bool;

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
    public function isStrval($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isLetterval($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isWordval($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isTrimval($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isLink($value): bool;

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isUrl($value): bool;

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
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return null|array
     */
    public function filterArrayDeep($array, int $depth = null): ?array;

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public function filterArrayPlain($array): ?array;

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return null|mixed
     */
    public function filterArrval($value);

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterArrayKey($value);

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return null|\DateTimeInterface
     */
    public function filterDateTimeInterface($date): ?\DateTimeInterface;

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return null|\DateTimeImmutable
     */
    public function filterDateTimeImmutable($date): ?\DateTimeImmutable;

    /**
     * @param \DateTime|mixed $date
     *
     * @return null|\DateTime
     */
    public function filterDateTime($date): ?\DateTime;

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return null|\DateTimeZone
     */
    public function filterDateTimeZone($timezone): ?\DateTimeZone;

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return null|\DateInterval
     */
    public function filterDateInterval($interval): ?\DateInterval;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTimeImmutable
     */
    public function filterIDate($date);

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTime
     */
    public function filterDate($date);

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return null|string|\DateTimeZone
     */
    public function filterTimezone($timezone);

    /**
     * @param string|\DateInterval $interval
     *
     * @return null|string|\DateInterval
     */
    public function filterInterval($interval);

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurl($ch);

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurlFresh($ch);

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterFilename($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPath($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFileExists($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathDir($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathLink($value): ?string;

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFile($value): ?string;

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return null|string
     */
    public function filterPathImage($value, $mimetypes = null): ?string;

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
    public function filterResourceOpened($h);

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResourceClosed($h);

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResourceReadable($h);

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResourceWritable($h);

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
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterClassOneOf($value, $classes);

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterSubclassOneOf($value, $classes);

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public function filterInstanceOneOf($object, $classes): ?object;

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return null|object
     */
    public function filterContract($object, $contract): ?object;

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
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterAlgorism($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterAlgorismval($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcGt0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcGte0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcLt0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcLte0($value);

    /**
     * @param string $ip
     *
     * @return null|string
     */
    public function filterIp(string $ip): ?string;

    /**
     * @param string $mask
     *
     * @return null|array
     */
    public function filterMask(string $mask): ?array;

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
     * @param int|float|mixed $value
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
    public function filterNumGt0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumGte0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumLt0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumLte0($value);

    /**
     * @param string|mixed $phpKeyword
     *
     * @return null|string
     */
    public function filterPhpKeyword($phpKeyword): ?string;

    /**
     * @param bool|mixed $value
     *
     * @return null|bool
     */
    public function filterBool($value): ?bool;

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public function filterCallable($callable, PhpInvokableInfo &$invokableInfo = null);

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null);

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterCallableFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null): ?\Closure;

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableString($callableString, PhpInvokableInfo &$invokableInfo = null);

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringFunction($callableString, PhpInvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterClosure($closure, PhpInvokableInfo &$invokableInfo = null): ?\Closure;

    /**
     * @param array|mixed $methodArray
     *
     * @return null|array
     */
    public function filterMethodArray($methodArray): ?array;

    /**
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array
     */
    public function filterMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterHandler($handler, PhpInvokableInfo &$invokableInfo = null): ?string;

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
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterStringUtf8($value): ?string;

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
    public function filterLetterOrInt($value);

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
    public function filterLetterOrNum($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrNum($value);

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterStrval($value);

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterLetterval($value);

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterWordval($value);

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterTrimval($value);

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
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return array
     */
    public function assertArrayDeep($array, int $depth = null): ?array;

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return array
     */
    public function assertArrayPlain($array): ?array;

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function assertArrval($value);

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertArrayKey($value);

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return \DateTimeInterface
     */
    public function assertDateTimeInterface($date): ?\DateTimeInterface;

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return \DateTimeImmutable
     */
    public function assertDateTimeImmutable($date): ?\DateTimeImmutable;

    /**
     * @param \DateTime|mixed $date
     *
     * @return \DateTime
     */
    public function assertDateTime($date): ?\DateTime;

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return \DateTimeZone
     */
    public function assertDateTimeZone($timezone): ?\DateTimeZone;

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return \DateInterval
     */
    public function assertDateInterval($interval): ?\DateInterval;

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTimeImmutable
     */
    public function assertIDate($date);

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTime
     */
    public function assertDate($date);

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return string|\DateTimeZone
     */
    public function assertTimezone($timezone);

    /**
     * @param string|\DateInterval $interval
     *
     * @return string|\DateInterval
     */
    public function assertInterval($interval);

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return resource|\CurlHandle
     */
    public function assertCurl($ch);

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return resource|\CurlHandle
     */
    public function assertCurlFresh($ch);

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertFilename($value): ?string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPath($value): ?string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathFileExists($value): ?string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathDir($value): ?string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathLink($value): ?string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathFile($value): ?string;

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return string
     */
    public function assertPathImage($value, $mimetypes = null): ?string;

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
    public function assertResourceOpened($h);

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResourceClosed($h);

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResourceReadable($h);

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResourceWritable($h);

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
     * @param string|mixed $className
     *
     * @return string
     */
    public function assertClassName($className): ?string;

    /**
     * @param string|mixed $classFullname
     *
     * @return string
     */
    public function assertClassFullname($classFullname): ?string;

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return string|object
     */
    public function assertClassOneOf($value, $classes);

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return string|object
     */
    public function assertSubclassOneOf($value, $classes);

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return object
     */
    public function assertInstanceOneOf($object, $classes): ?object;

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return object
     */
    public function assertContract($object, $contract): ?object;

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
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertAlgorism($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertAlgorismval($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public function assertBcGt0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public function assertBcGte0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public function assertBcLt0($value);

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public function assertBcLte0($value);

    /**
     * @param string $ip
     *
     * @return string
     */
    public function assertIp(string $ip): ?string;

    /**
     * @param string $mask
     *
     * @return array
     */
    public function assertMask(string $mask): ?array;

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
     * @param int|float|mixed $value
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
    public function assertNumGt0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNumGte0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNumLt0($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNumLte0($value);

    /**
     * @param string|mixed $phpKeyword
     *
     * @return string
     */
    public function assertPhpKeyword($phpKeyword): ?string;

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public function assertBool($value): ?bool;

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return string|array|\Closure|callable
     */
    public function assertCallable($callable, PhpInvokableInfo &$invokableInfo = null);

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return string|array|callable
     */
    public function assertCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null);

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public function assertCallableFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null): ?\Closure;

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return string|array|callable
     */
    public function assertCallableString($callableString, PhpInvokableInfo &$invokableInfo = null);

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringFunction($callableString, PhpInvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): ?string;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public function assertClosure($closure, PhpInvokableInfo &$invokableInfo = null): ?\Closure;

    /**
     * @param array|mixed $methodArray
     *
     * @return array
     */
    public function assertMethodArray($methodArray): ?array;

    /**
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array
     */
    public function assertMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): ?array;

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertHandler($handler, PhpInvokableInfo &$invokableInfo = null): ?string;

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
    public function assertError($value);

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
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertStringUtf8($value): ?string;

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
    public function assertLetter($value): ?string;

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
    public function assertLetterOrInt($value);

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
    public function assertLetterOrNum($value);

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrNum($value);

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertStrval($value);

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertLetterval($value);

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertWordval($value);

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertTrimval($value);

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
}
