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

use Gzhegow\Support\Domain\Debug\DebugMessage;
use Gzhegow\Support\Domain\Math\ValueObject\MathBcval;
use Gzhegow\Support\Domain\Php\ValueObject\PhpInvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Generated\GeneratedFilter;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\SupportFactory;
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
use Gzhegow\Support\XFilter;

class Filter
{
    /**
     * @param null|string|array $text
     * @param array             ...$placeholders
     *
     * @return null|array
     */
    public static function getMessageOr($text = null, ...$placeholders): ?array
    {
        return static::getInstance()->getMessageOr($text, ...$placeholders);
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
     * @param null|string|array|\Throwable $assert
     * @param mixed                        ...$placeholders
     *
     * @return XFilter
     */
    public static function assert($assert, ...$placeholders)
    {
        return static::getInstance()->assert($assert, ...$placeholders);
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isArray($array, callable $of = null): bool
    {
        return static::getInstance()->isArray($array, $of);
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isList($list, callable $of = null): bool
    {
        return static::getInstance()->isList($list, $of);
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isDict($dict, callable $of = null): bool
    {
        return static::getInstance()->isDict($dict, $of);
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isAssoc($assoc, callable $of = null): bool
    {
        return static::getInstance()->isAssoc($assoc, $of);
    }

    /**
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return bool
     */
    public static function isArrayDeep($array, int $depth = null): bool
    {
        return static::getInstance()->isArrayDeep($array, $depth);
    }

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return bool
     */
    public static function isArrayPlain($array): bool
    {
        return static::getInstance()->isArrayPlain($array);
    }

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isArrval($value): bool
    {
        return static::getInstance()->isArrval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public static function isArrayKey($value): bool
    {
        return static::getInstance()->isArrayKey($value);
    }

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public static function isDateTimeInterface($date): bool
    {
        return static::getInstance()->isDateTimeInterface($date);
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return bool
     */
    public static function isDateTimeImmutable($date): bool
    {
        return static::getInstance()->isDateTimeImmutable($date);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return bool
     */
    public static function isDateTime($date): bool
    {
        return static::getInstance()->isDateTime($date);
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return bool
     */
    public static function isDateTimeZone($timezone): bool
    {
        return static::getInstance()->isDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return bool
     */
    public static function isDateInterval($interval): bool
    {
        return static::getInstance()->isDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public static function isIDate($date): bool
    {
        return static::getInstance()->isIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public static function isDate($date): bool
    {
        return static::getInstance()->isDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return bool
     */
    public static function isTimezone($timezone): bool
    {
        return static::getInstance()->isTimezone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return bool
     */
    public static function isInterval($interval): bool
    {
        return static::getInstance()->isInterval($interval);
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

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return bool
     */
    public static function isCurlFresh($ch): bool
    {
        return static::getInstance()->isCurlFresh($ch);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isFilename($value): bool
    {
        return static::getInstance()->isFilename($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPath($value): bool
    {
        return static::getInstance()->isPath($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPathFileExists($value): bool
    {
        return static::getInstance()->isPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPathDir($value): bool
    {
        return static::getInstance()->isPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPathLink($value): bool
    {
        return static::getInstance()->isPathLink($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isPathFile($value): bool
    {
        return static::getInstance()->isPathFile($value);
    }

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return bool
     */
    public static function isPathImage($value, $mimetypes = null): bool
    {
        return static::getInstance()->isPathImage($value, $mimetypes);
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
    public static function isResourceOpened($h): bool
    {
        return static::getInstance()->isResourceOpened($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public static function isResourceClosed($h): bool
    {
        return static::getInstance()->isResourceClosed($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public static function isResourceReadable($h): bool
    {
        return static::getInstance()->isResourceReadable($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public static function isResourceWritable($h): bool
    {
        return static::getInstance()->isResourceWritable($h);
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return bool
     */
    public static function isFileInfo($value): bool
    {
        return static::getInstance()->isFileInfo($value);
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return bool
     */
    public static function isFileObject($value): bool
    {
        return static::getInstance()->isFileObject($value);
    }

    /**
     * @param string|mixed $className
     *
     * @return bool
     */
    public static function isClassName($className): bool
    {
        return static::getInstance()->isClassName($className);
    }

    /**
     * @param string|mixed $classFullname
     *
     * @return bool
     */
    public static function isClassFullname($classFullname): bool
    {
        return static::getInstance()->isClassFullname($classFullname);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isClassOneOf($value, $classes): bool
    {
        return static::getInstance()->isClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isSubclassOneOf($value, $classes): bool
    {
        return static::getInstance()->isSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return bool
     */
    public static function isInstanceOneOf($object, $classes): bool
    {
        return static::getInstance()->isInstanceOneOf($object, $classes);
    }

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return bool
     */
    public static function isContract($object, $contract): bool
    {
        return static::getInstance()->isContract($object, $contract);
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return bool
     */
    public static function isReflectionClass($value): bool
    {
        return static::getInstance()->isReflectionClass($value);
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return bool
     */
    public static function isReflectionFunction($value): bool
    {
        return static::getInstance()->isReflectionFunction($value);
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return bool
     */
    public static function isReflectionMethod($value): bool
    {
        return static::getInstance()->isReflectionMethod($value);
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return bool
     */
    public static function isReflectionProperty($value): bool
    {
        return static::getInstance()->isReflectionProperty($value);
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return bool
     */
    public static function isReflectionParameter($value): bool
    {
        return static::getInstance()->isReflectionParameter($value);
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return bool
     */
    public static function isReflectionType($value): bool
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
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isAlgorism($value): bool
    {
        return static::getInstance()->isAlgorism($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isAlgorismval($value): bool
    {
        return static::getInstance()->isAlgorismval($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public static function isBcGt0($value): bool
    {
        return static::getInstance()->isBcGt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public static function isBcGte0($value): bool
    {
        return static::getInstance()->isBcGte0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public static function isBcLt0($value): bool
    {
        return static::getInstance()->isBcLt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public static function isBcLte0($value): bool
    {
        return static::getInstance()->isBcLte0($value);
    }

    /**
     * @param string $ip
     *
     * @return bool
     */
    public static function isIp(string $ip): bool
    {
        return static::getInstance()->isIp($ip);
    }

    /**
     * @param string $mask
     *
     * @return bool
     */
    public static function isMask(string $mask): bool
    {
        return static::getInstance()->isMask($mask);
    }

    /**
     * @param int|mixed $value
     *
     * @return bool
     */
    public static function isInt($value): bool
    {
        return static::getInstance()->isInt($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public static function isFloat($value): bool
    {
        return static::getInstance()->isFloat($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public static function isNan($value): bool
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
    public static function isIntval($value): bool
    {
        return static::getInstance()->isIntval($value);
    }

    /**
     * @param float|string|mixed $value
     *
     * @return bool
     */
    public static function isFloatval($value): bool
    {
        return static::getInstance()->isFloatval($value);
    }

    /**
     * @param int|float|mixed $value
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
    public static function isNumGt0($value): bool
    {
        return static::getInstance()->isNumGt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNumGte0($value): bool
    {
        return static::getInstance()->isNumGte0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNumLt0($value): bool
    {
        return static::getInstance()->isNumLt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public static function isNumLte0($value): bool
    {
        return static::getInstance()->isNumLte0($value);
    }

    /**
     * @param string|mixed $phpKeyword
     *
     * @return bool
     */
    public static function isPhpKeyword($phpKeyword): bool
    {
        return static::getInstance()->isPhpKeyword($phpKeyword);
    }

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public static function isBool($value): bool
    {
        return static::getInstance()->isBool($value);
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return bool
     */
    public static function isCallable($callable, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return bool
     */
    public static function isCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableOnly($callable, $invokableInfo);
    }

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableFactory($factory, $returnType, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return bool
     */
    public static function isCallableString($callableString, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableStringFunction($callableString, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isClosure($closure, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isClosure($closure, $invokableInfo);
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return bool
     */
    public static function isMethodArray($methodArray): bool
    {
        return static::getInstance()->isMethodArray($methodArray);
    }

    /**
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public static function isHandler($handler, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return static::getInstance()->isHandler($handler, $invokableInfo);
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
    public static function isError($value): bool
    {
        return static::getInstance()->isError($value);
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
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isStringUtf8($value): bool
    {
        return static::getInstance()->isStringUtf8($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isString($value): bool
    {
        return static::getInstance()->isString($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isLetter($value): bool
    {
        return static::getInstance()->isLetter($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isWord($value): bool
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
    public static function isLetterOrInt($value): bool
    {
        return static::getInstance()->isLetterOrInt($value);
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
    public static function isLetterOrNum($value): bool
    {
        return static::getInstance()->isLetterOrNum($value);
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
    public static function isStrval($value): bool
    {
        return static::getInstance()->isStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isLetterval($value): bool
    {
        return static::getInstance()->isLetterval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isWordval($value): bool
    {
        return static::getInstance()->isWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isTrimval($value): bool
    {
        return static::getInstance()->isTrimval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isLink($value): bool
    {
        return static::getInstance()->isLink($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public static function isUrl($value): bool
    {
        return static::getInstance()->isUrl($value);
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
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return null|array
     */
    public static function filterArrayDeep($array, int $depth = null): ?array
    {
        return static::getInstance()->filterArrayDeep($array, $depth);
    }

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public static function filterArrayPlain($array): ?array
    {
        return static::getInstance()->filterArrayPlain($array);
    }

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return null|mixed
     */
    public static function filterArrval($value)
    {
        return static::getInstance()->filterArrval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public static function filterArrayKey($value)
    {
        return static::getInstance()->filterArrayKey($value);
    }

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return null|\DateTimeInterface
     */
    public static function filterDateTimeInterface($date): ?\DateTimeInterface
    {
        return static::getInstance()->filterDateTimeInterface($date);
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return null|\DateTimeImmutable
     */
    public static function filterDateTimeImmutable($date): ?\DateTimeImmutable
    {
        return static::getInstance()->filterDateTimeImmutable($date);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return null|\DateTime
     */
    public static function filterDateTime($date): ?\DateTime
    {
        return static::getInstance()->filterDateTime($date);
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return null|\DateTimeZone
     */
    public static function filterDateTimeZone($timezone): ?\DateTimeZone
    {
        return static::getInstance()->filterDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return null|\DateInterval
     */
    public static function filterDateInterval($interval): ?\DateInterval
    {
        return static::getInstance()->filterDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTimeImmutable
     */
    public static function filterIDate($date)
    {
        return static::getInstance()->filterIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTime
     */
    public static function filterDate($date)
    {
        return static::getInstance()->filterDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return null|string|\DateTimeZone
     */
    public static function filterTimezone($timezone)
    {
        return static::getInstance()->filterTimezone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return null|string|\DateInterval
     */
    public static function filterInterval($interval)
    {
        return static::getInstance()->filterInterval($interval);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public static function filterCurl($ch)
    {
        return static::getInstance()->filterCurl($ch);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public static function filterCurlFresh($ch)
    {
        return static::getInstance()->filterCurlFresh($ch);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterFilename($value): ?string
    {
        return static::getInstance()->filterFilename($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPath($value): ?string
    {
        return static::getInstance()->filterPath($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPathFileExists($value): ?string
    {
        return static::getInstance()->filterPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPathDir($value): ?string
    {
        return static::getInstance()->filterPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPathLink($value): ?string
    {
        return static::getInstance()->filterPathLink($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public static function filterPathFile($value): ?string
    {
        return static::getInstance()->filterPathFile($value);
    }

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return null|string
     */
    public static function filterPathImage($value, $mimetypes = null): ?string
    {
        return static::getInstance()->filterPathImage($value, $mimetypes);
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
    public static function filterResourceOpened($h)
    {
        return static::getInstance()->filterResourceOpened($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResourceClosed($h)
    {
        return static::getInstance()->filterResourceClosed($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResourceReadable($h)
    {
        return static::getInstance()->filterResourceReadable($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public static function filterResourceWritable($h)
    {
        return static::getInstance()->filterResourceWritable($h);
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
     * @param string|mixed $className
     *
     * @return null|string
     */
    public static function filterClassName($className): ?string
    {
        return static::getInstance()->filterClassName($className);
    }

    /**
     * @param string|mixed $classFullname
     *
     * @return null|string
     */
    public static function filterClassFullname($classFullname): ?string
    {
        return static::getInstance()->filterClassFullname($classFullname);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public static function filterClassOneOf($value, $classes)
    {
        return static::getInstance()->filterClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public static function filterSubclassOneOf($value, $classes)
    {
        return static::getInstance()->filterSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public static function filterInstanceOneOf($object, $classes): ?object
    {
        return static::getInstance()->filterInstanceOneOf($object, $classes);
    }

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return null|object
     */
    public static function filterContract($object, $contract): ?object
    {
        return static::getInstance()->filterContract($object, $contract);
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
     * @param mixed $reflectionType
     *
     * @return null|\ReflectionUnionType
     */
    public static function filterReflectionUnionType($reflectionType)
    {
        return static::getInstance()->filterReflectionUnionType($reflectionType);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return null|\ReflectionNamedType
     */
    public static function filterReflectionNamedType($reflectionType)
    {
        return static::getInstance()->filterReflectionNamedType($reflectionType);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterAlgorism($value): ?string
    {
        return static::getInstance()->filterAlgorism($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterAlgorismval($value)
    {
        return static::getInstance()->filterAlgorismval($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public static function filterBcGt0($value)
    {
        return static::getInstance()->filterBcGt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public static function filterBcGte0($value)
    {
        return static::getInstance()->filterBcGte0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public static function filterBcLt0($value)
    {
        return static::getInstance()->filterBcLt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public static function filterBcLte0($value)
    {
        return static::getInstance()->filterBcLte0($value);
    }

    /**
     * @param string $ip
     *
     * @return null|string
     */
    public static function filterIp(string $ip): ?string
    {
        return static::getInstance()->filterIp($ip);
    }

    /**
     * @param string $mask
     *
     * @return null|array
     */
    public static function filterMask(string $mask): ?array
    {
        return static::getInstance()->filterMask($mask);
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
    public static function filterNum($value)
    {
        return static::getInstance()->filterNum($value);
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
     * @param int|float|mixed $value
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
    public static function filterNumericval($value)
    {
        return static::getInstance()->filterNumericval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumGt0($value)
    {
        return static::getInstance()->filterNumGt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumGte0($value)
    {
        return static::getInstance()->filterNumGte0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumLt0($value)
    {
        return static::getInstance()->filterNumLt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumLte0($value)
    {
        return static::getInstance()->filterNumLte0($value);
    }

    /**
     * @param string|mixed $phpKeyword
     *
     * @return null|string
     */
    public static function filterPhpKeyword($phpKeyword): ?string
    {
        return static::getInstance()->filterPhpKeyword($phpKeyword);
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
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public static function filterCallable($callable, PhpInvokableInfo &$invokableInfo = null)
    {
        return static::getInstance()->filterCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return null|string|array|callable
     */
    public static function filterCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null)
    {
        return static::getInstance()->filterCallableOnly($callable, $invokableInfo);
    }

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public static function filterCallableFactory(
        $factory,
        $returnType,
        PhpInvokableInfo &$invokableInfo = null
    ): ?\Closure {
        return static::getInstance()->filterCallableFactory($factory, $returnType, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return null|string|array|callable
     */
    public static function filterCallableString($callableString, PhpInvokableInfo &$invokableInfo = null)
    {
        return static::getInstance()->filterCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public static function filterCallableStringFunction(
        $callableString,
        PhpInvokableInfo &$invokableInfo = null
    ): ?string {
        return static::getInstance()->filterCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public static function filterCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        return static::getInstance()->filterCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public static function filterCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->filterCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public static function filterClosure($closure, PhpInvokableInfo &$invokableInfo = null): ?\Closure
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
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array
     */
    public static function filterMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->filterMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public static function filterHandler($handler, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        return static::getInstance()->filterHandler($handler, $invokableInfo);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public static function filterThrowable($value)
    {
        return static::getInstance()->filterThrowable($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public static function filterError($value)
    {
        return static::getInstance()->filterError($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public static function filterException($value)
    {
        return static::getInstance()->filterException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public static function filterRuntimeException($value)
    {
        return static::getInstance()->filterRuntimeException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public static function filterLogicException($value)
    {
        return static::getInstance()->filterLogicException($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterStringUtf8($value): ?string
    {
        return static::getInstance()->filterStringUtf8($value);
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
    public static function filterLetter($value): ?string
    {
        return static::getInstance()->filterLetter($value);
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
    public static function filterLetterOrInt($value)
    {
        return static::getInstance()->filterLetterOrInt($value);
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
    public static function filterStringOrNum($value)
    {
        return static::getInstance()->filterStringOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterLetterOrNum($value)
    {
        return static::getInstance()->filterLetterOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterWordOrNum($value)
    {
        return static::getInstance()->filterWordOrNum($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterStrval($value)
    {
        return static::getInstance()->filterStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterLetterval($value)
    {
        return static::getInstance()->filterLetterval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterWordval($value)
    {
        return static::getInstance()->filterWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public static function filterTrimval($value)
    {
        return static::getInstance()->filterTrimval($value);
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
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return array
     */
    public static function assertArrayDeep($array, int $depth = null): ?array
    {
        return static::getInstance()->assertArrayDeep($array, $depth);
    }

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return array
     */
    public static function assertArrayPlain($array): ?array
    {
        return static::getInstance()->assertArrayPlain($array);
    }

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function assertArrval($value)
    {
        return static::getInstance()->assertArrval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public static function assertArrayKey($value)
    {
        return static::getInstance()->assertArrayKey($value);
    }

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return \DateTimeInterface
     */
    public static function assertDateTimeInterface($date): ?\DateTimeInterface
    {
        return static::getInstance()->assertDateTimeInterface($date);
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return \DateTimeImmutable
     */
    public static function assertDateTimeImmutable($date): ?\DateTimeImmutable
    {
        return static::getInstance()->assertDateTimeImmutable($date);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return \DateTime
     */
    public static function assertDateTime($date): ?\DateTime
    {
        return static::getInstance()->assertDateTime($date);
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return \DateTimeZone
     */
    public static function assertDateTimeZone($timezone): ?\DateTimeZone
    {
        return static::getInstance()->assertDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return \DateInterval
     */
    public static function assertDateInterval($interval): ?\DateInterval
    {
        return static::getInstance()->assertDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTimeImmutable
     */
    public static function assertIDate($date)
    {
        return static::getInstance()->assertIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTime
     */
    public static function assertDate($date)
    {
        return static::getInstance()->assertDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return string|\DateTimeZone
     */
    public static function assertTimezone($timezone)
    {
        return static::getInstance()->assertTimezone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return string|\DateInterval
     */
    public static function assertInterval($interval)
    {
        return static::getInstance()->assertInterval($interval);
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
     * @param resource|\CurlHandle $ch
     *
     * @return resource|\CurlHandle
     */
    public static function assertCurlFresh($ch)
    {
        return static::getInstance()->assertCurlFresh($ch);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertFilename($value): ?string
    {
        return static::getInstance()->assertFilename($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPath($value): ?string
    {
        return static::getInstance()->assertPath($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathFileExists($value): ?string
    {
        return static::getInstance()->assertPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathDir($value): ?string
    {
        return static::getInstance()->assertPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathLink($value): ?string
    {
        return static::getInstance()->assertPathLink($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function assertPathFile($value): ?string
    {
        return static::getInstance()->assertPathFile($value);
    }

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return string
     */
    public static function assertPathImage($value, $mimetypes = null): ?string
    {
        return static::getInstance()->assertPathImage($value, $mimetypes);
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
    public static function assertResourceOpened($h)
    {
        return static::getInstance()->assertResourceOpened($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public static function assertResourceClosed($h)
    {
        return static::getInstance()->assertResourceClosed($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public static function assertResourceReadable($h)
    {
        return static::getInstance()->assertResourceReadable($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public static function assertResourceWritable($h)
    {
        return static::getInstance()->assertResourceWritable($h);
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
     * @param string|mixed $className
     *
     * @return string
     */
    public static function assertClassName($className): ?string
    {
        return static::getInstance()->assertClassName($className);
    }

    /**
     * @param string|mixed $classFullname
     *
     * @return string
     */
    public static function assertClassFullname($classFullname): ?string
    {
        return static::getInstance()->assertClassFullname($classFullname);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return string|object
     */
    public static function assertClassOneOf($value, $classes)
    {
        return static::getInstance()->assertClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return string|object
     */
    public static function assertSubclassOneOf($value, $classes)
    {
        return static::getInstance()->assertSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return object
     */
    public static function assertInstanceOneOf($object, $classes): ?object
    {
        return static::getInstance()->assertInstanceOneOf($object, $classes);
    }

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return object
     */
    public static function assertContract($object, $contract): ?object
    {
        return static::getInstance()->assertContract($object, $contract);
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
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertAlgorism($value): ?string
    {
        return static::getInstance()->assertAlgorism($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public static function assertAlgorismval($value)
    {
        return static::getInstance()->assertAlgorismval($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public static function assertBcGt0($value)
    {
        return static::getInstance()->assertBcGt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public static function assertBcGte0($value)
    {
        return static::getInstance()->assertBcGte0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public static function assertBcLt0($value)
    {
        return static::getInstance()->assertBcLt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public static function assertBcLte0($value)
    {
        return static::getInstance()->assertBcLte0($value);
    }

    /**
     * @param string $ip
     *
     * @return string
     */
    public static function assertIp(string $ip): ?string
    {
        return static::getInstance()->assertIp($ip);
    }

    /**
     * @param string $mask
     *
     * @return array
     */
    public static function assertMask(string $mask): ?array
    {
        return static::getInstance()->assertMask($mask);
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
     * @param int|float|mixed $value
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
    public static function assertNumGt0($value)
    {
        return static::getInstance()->assertNumGt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function assertNumGte0($value)
    {
        return static::getInstance()->assertNumGte0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function assertNumLt0($value)
    {
        return static::getInstance()->assertNumLt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public static function assertNumLte0($value)
    {
        return static::getInstance()->assertNumLte0($value);
    }

    /**
     * @param string|mixed $phpKeyword
     *
     * @return string
     */
    public static function assertPhpKeyword($phpKeyword): ?string
    {
        return static::getInstance()->assertPhpKeyword($phpKeyword);
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
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return string|array|\Closure|callable
     */
    public static function assertCallable($callable, PhpInvokableInfo &$invokableInfo = null)
    {
        return static::getInstance()->assertCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return string|array|callable
     */
    public static function assertCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null)
    {
        return static::getInstance()->assertCallableOnly($callable, $invokableInfo);
    }

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public static function assertCallableFactory(
        $factory,
        $returnType,
        PhpInvokableInfo &$invokableInfo = null
    ): ?\Closure {
        return static::getInstance()->assertCallableFactory($factory, $returnType, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return string|array|callable
     */
    public static function assertCallableString($callableString, PhpInvokableInfo &$invokableInfo = null)
    {
        return static::getInstance()->assertCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public static function assertCallableStringFunction(
        $callableString,
        PhpInvokableInfo &$invokableInfo = null
    ): ?string {
        return static::getInstance()->assertCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public static function assertCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        return static::getInstance()->assertCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public static function assertCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->assertCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public static function assertClosure($closure, PhpInvokableInfo &$invokableInfo = null): ?\Closure
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
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array
     */
    public static function assertMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return static::getInstance()->assertMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public static function assertHandler($handler, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        return static::getInstance()->assertHandler($handler, $invokableInfo);
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
     * @param string|mixed $value
     *
     * @return string
     */
    public static function assertStringUtf8($value): ?string
    {
        return static::getInstance()->assertStringUtf8($value);
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
    public static function assertLetter($value): ?string
    {
        return static::getInstance()->assertLetter($value);
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
    public static function assertLetterOrInt($value)
    {
        return static::getInstance()->assertLetterOrInt($value);
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
    public static function assertLetterOrNum($value)
    {
        return static::getInstance()->assertLetterOrNum($value);
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
     * @return int|float|string|object
     */
    public static function assertStrval($value)
    {
        return static::getInstance()->assertStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public static function assertLetterval($value)
    {
        return static::getInstance()->assertLetterval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public static function assertWordval($value)
    {
        return static::getInstance()->assertWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public static function assertTrimval($value)
    {
        return static::getInstance()->assertTrimval($value);
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
     * @return IFilter
     */
    public static function getInstance(): IFilter
    {
        return SupportFactory::getInstance()->getFilter();
    }
}
