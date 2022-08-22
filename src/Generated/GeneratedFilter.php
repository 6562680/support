<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Generated;

use Gzhegow\Support\Domain\Math\ValueObject\MathBcval;
use Gzhegow\Support\Domain\Php\ValueObject\PhpInvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\IFilter;
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

abstract class GeneratedFilter implements IFilter
{
    use DebugLoadTrait;
    use ArrLoadTrait;
    use CalendarLoadTrait;
    use CurlLoadTrait;
    use FsLoadTrait;
    use LoaderLoadTrait;
    use MathLoadTrait;
    use NetLoadTrait;
    use NumLoadTrait;
    use PhpLoadTrait;
    use StrLoadTrait;
    use UriLoadTrait;

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return bool
     */
    public function isArray($array, callable $of = null): bool
    {
        return null !== $this->getArr()->filterArray($array, $of);
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return bool
     */
    public function isList($list, callable $of = null): bool
    {
        return null !== $this->getArr()->filterList($list, $of);
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public function isDict($dict, callable $of = null): bool
    {
        return null !== $this->getArr()->filterDict($dict, $of);
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public function isAssoc($assoc, callable $of = null): bool
    {
        return null !== $this->getArr()->filterAssoc($assoc, $of);
    }

    /**
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return bool
     */
    public function isArrayDeep($array, int $depth = null): bool
    {
        return null !== $this->getArr()->filterArrayDeep($array, $depth);
    }

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return bool
     */
    public function isArrayPlain($array): bool
    {
        return null !== $this->getArr()->filterArrayPlain($array);
    }

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isArrval($value): bool
    {
        return null !== $this->getArr()->filterArrval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isArrayKey($value): bool
    {
        return null !== $this->getArr()->filterArrayKey($value);
    }

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isDateTimeInterface($date): bool
    {
        return null !== $this->getCalendar()->filterDateTimeInterface($date);
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return bool
     */
    public function isDateTimeImmutable($date): bool
    {
        return null !== $this->getCalendar()->filterDateTimeImmutable($date);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return bool
     */
    public function isDateTime($date): bool
    {
        return null !== $this->getCalendar()->filterDateTime($date);
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return bool
     */
    public function isDateTimeZone($timezone): bool
    {
        return null !== $this->getCalendar()->filterDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return bool
     */
    public function isDateInterval($interval): bool
    {
        return null !== $this->getCalendar()->filterDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isIDate($date): bool
    {
        return null !== $this->getCalendar()->filterIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return bool
     */
    public function isDate($date): bool
    {
        return null !== $this->getCalendar()->filterDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return bool
     */
    public function isTimezone($timezone): bool
    {
        return null !== $this->getCalendar()->filterTimezone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return bool
     */
    public function isInterval($interval): bool
    {
        return null !== $this->getCalendar()->filterInterval($interval);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return bool
     */
    public function isCurl($ch): bool
    {
        return null !== $this->getCurl()->filterCurl($ch);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return bool
     */
    public function isCurlFresh($ch): bool
    {
        return null !== $this->getCurl()->filterCurlFresh($ch);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isFilename($value): bool
    {
        return null !== $this->getFs()->filterFilename($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPath($value): bool
    {
        return null !== $this->getFs()->filterPath($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathFileExists($value): bool
    {
        return null !== $this->getFs()->filterPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathDir($value): bool
    {
        return null !== $this->getFs()->filterPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathLink($value): bool
    {
        return null !== $this->getFs()->filterPathLink($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isPathFile($value): bool
    {
        return null !== $this->getFs()->filterPathFile($value);
    }

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return bool
     */
    public function isPathImage($value, $mimetypes = null): bool
    {
        return null !== $this->getFs()->filterPathImage($value, $mimetypes);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResource($h): bool
    {
        return null !== $this->getFs()->filterResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResourceOpened($h): bool
    {
        return null !== $this->getFs()->filterResourceOpened($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResourceClosed($h): bool
    {
        return null !== $this->getFs()->filterResourceClosed($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResourceReadable($h): bool
    {
        return null !== $this->getFs()->filterResourceReadable($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return bool
     */
    public function isResourceWritable($h): bool
    {
        return null !== $this->getFs()->filterResourceWritable($h);
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return bool
     */
    public function isFileInfo($value): bool
    {
        return null !== $this->getFs()->filterFileInfo($value);
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return bool
     */
    public function isFileObject($value): bool
    {
        return null !== $this->getFs()->filterFileObject($value);
    }

    /**
     * @param string|mixed $className
     *
     * @return bool
     */
    public function isClassName($className): bool
    {
        return null !== $this->getLoader()->filterClassName($className);
    }

    /**
     * @param string|mixed $classFullname
     *
     * @return bool
     */
    public function isClassFullname($classFullname): bool
    {
        return null !== $this->getLoader()->filterClassFullname($classFullname);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isClassOneOf($value, $classes): bool
    {
        return null !== $this->getLoader()->filterClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isSubclassOneOf($value, $classes): bool
    {
        return null !== $this->getLoader()->filterSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isInstanceOneOf($object, $classes): bool
    {
        return null !== $this->getLoader()->filterInstanceOneOf($object, $classes);
    }

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return bool
     */
    public function isContract($object, $contract): bool
    {
        return null !== $this->getLoader()->filterContract($object, $contract);
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return bool
     */
    public function isReflectionClass($value): bool
    {
        return null !== $this->getLoader()->filterReflectionClass($value);
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return bool
     */
    public function isReflectionFunction($value): bool
    {
        return null !== $this->getLoader()->filterReflectionFunction($value);
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return bool
     */
    public function isReflectionMethod($value): bool
    {
        return null !== $this->getLoader()->filterReflectionMethod($value);
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return bool
     */
    public function isReflectionProperty($value): bool
    {
        return null !== $this->getLoader()->filterReflectionProperty($value);
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return bool
     */
    public function isReflectionParameter($value): bool
    {
        return null !== $this->getLoader()->filterReflectionParameter($value);
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return bool
     */
    public function isReflectionType($value): bool
    {
        return null !== $this->getLoader()->filterReflectionType($value);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return bool
     */
    public function isReflectionUnionType($reflectionType): bool
    {
        return null !== $this->getLoader()->filterReflectionUnionType($reflectionType);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return bool
     */
    public function isReflectionNamedType($reflectionType): bool
    {
        return null !== $this->getLoader()->filterReflectionNamedType($reflectionType);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isAlgorism($value): bool
    {
        return null !== $this->getMath()->filterAlgorism($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isAlgorismval($value): bool
    {
        return null !== $this->getMath()->filterAlgorismval($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public function isBcGt0($value): bool
    {
        return null !== $this->getMath()->filterBcGt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public function isBcGte0($value): bool
    {
        return null !== $this->getMath()->filterBcGte0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public function isBcLt0($value): bool
    {
        return null !== $this->getMath()->filterBcLt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return bool
     */
    public function isBcLte0($value): bool
    {
        return null !== $this->getMath()->filterBcLte0($value);
    }

    /**
     * @param string $ip
     *
     * @return bool
     */
    public function isIp(string $ip): bool
    {
        return null !== $this->getNet()->filterIp($ip);
    }

    /**
     * @param string $mask
     *
     * @return bool
     */
    public function isMask(string $mask): bool
    {
        return null !== $this->getNet()->filterMask($mask);
    }

    /**
     * @param int|mixed $value
     *
     * @return bool
     */
    public function isInt($value): bool
    {
        return null !== $this->getNum()->filterInt($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public function isFloat($value): bool
    {
        return null !== $this->getNum()->filterFloat($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return bool
     */
    public function isNan($value): bool
    {
        return null !== $this->getNum()->filterNan($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return bool
     */
    public function isNum($value): bool
    {
        return null !== $this->getNum()->filterNum($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isIntval($value): bool
    {
        return null !== $this->getNum()->filterIntval($value);
    }

    /**
     * @param float|string|mixed $value
     *
     * @return bool
     */
    public function isFloatval($value): bool
    {
        return null !== $this->getNum()->filterFloatval($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return bool
     */
    public function isNumval($value): bool
    {
        return null !== $this->getNum()->filterNumval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumericval($value): bool
    {
        return null !== $this->getNum()->filterNumericval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumGt0($value): bool
    {
        return null !== $this->getNum()->filterNumGt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumGte0($value): bool
    {
        return null !== $this->getNum()->filterNumGte0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumLt0($value): bool
    {
        return null !== $this->getNum()->filterNumLt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isNumLte0($value): bool
    {
        return null !== $this->getNum()->filterNumLte0($value);
    }

    /**
     * @param string|mixed $phpKeyword
     *
     * @return bool
     */
    public function isPhpKeyword($phpKeyword): bool
    {
        return null !== $this->getPhp()->filterPhpKeyword($phpKeyword);
    }

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public function isBool($value): bool
    {
        return null !== $this->getPhp()->filterBool($value);
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return bool
     */
    public function isCallable($callable, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return bool
     */
    public function isCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallableOnly($callable, $invokableInfo);
    }

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallableFactory($factory, $returnType, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return bool
     */
    public function isCallableString($callableString, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringFunction($callableString, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isClosure($closure, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterClosure($closure, $invokableInfo);
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return bool
     */
    public function isMethodArray($methodArray): bool
    {
        return null !== $this->getPhp()->filterMethodArray($methodArray);
    }

    /**
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return bool
     */
    public function isHandler($handler, PhpInvokableInfo &$invokableInfo = null): bool
    {
        return null !== $this->getPhp()->filterHandler($handler, $invokableInfo);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isThrowable($value): bool
    {
        return null !== $this->getPhp()->filterThrowable($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isError($value): bool
    {
        return null !== $this->getPhp()->filterError($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isException($value): bool
    {
        return null !== $this->getPhp()->filterException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isRuntimeException($value): bool
    {
        return null !== $this->getPhp()->filterRuntimeException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return bool
     */
    public function isLogicException($value): bool
    {
        return null !== $this->getPhp()->filterLogicException($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isStringUtf8($value): bool
    {
        return null !== $this->getStr()->filterStringUtf8($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isString($value): bool
    {
        return null !== $this->getStr()->filterString($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isLetter($value): bool
    {
        return null !== $this->getStr()->filterLetter($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isWord($value): bool
    {
        return null !== $this->getStr()->filterWord($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isStringOrInt($value): bool
    {
        return null !== $this->getStr()->filterStringOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isLetterOrInt($value): bool
    {
        return null !== $this->getStr()->filterLetterOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return bool
     */
    public function isWordOrInt($value): bool
    {
        return null !== $this->getStr()->filterWordOrInt($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isStringOrNum($value): bool
    {
        return null !== $this->getStr()->filterStringOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isLetterOrNum($value): bool
    {
        return null !== $this->getStr()->filterLetterOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return bool
     */
    public function isWordOrNum($value): bool
    {
        return null !== $this->getStr()->filterWordOrNum($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isStrval($value): bool
    {
        return null !== $this->getStr()->filterStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isLetterval($value): bool
    {
        return null !== $this->getStr()->filterLetterval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isWordval($value): bool
    {
        return null !== $this->getStr()->filterWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isTrimval($value): bool
    {
        return null !== $this->getStr()->filterTrimval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isLink($value): bool
    {
        return null !== $this->getUri()->filterLink($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isUrl($value): bool
    {
        return null !== $this->getUri()->filterUrl($value);
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterArray($array, callable $of = null): ?array
    {
        return $this->getArr()->filterArray($array, $of);
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterList($list, callable $of = null): ?array
    {
        return $this->getArr()->filterList($list, $of);
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterDict($dict, callable $of = null): ?array
    {
        return $this->getArr()->filterDict($dict, $of);
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterAssoc($assoc, callable $of = null): ?array
    {
        return $this->getArr()->filterAssoc($assoc, $of);
    }

    /**
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return null|array
     */
    public function filterArrayDeep($array, int $depth = null): ?array
    {
        return $this->getArr()->filterArrayDeep($array, $depth);
    }

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return null|array
     */
    public function filterArrayPlain($array): ?array
    {
        return $this->getArr()->filterArrayPlain($array);
    }

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return null|mixed
     */
    public function filterArrval($value)
    {
        return $this->getArr()->filterArrval($value);
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterArrayKey($value)
    {
        return $this->getArr()->filterArrayKey($value);
    }

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return null|\DateTimeInterface
     */
    public function filterDateTimeInterface($date): ?\DateTimeInterface
    {
        return $this->getCalendar()->filterDateTimeInterface($date);
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return null|\DateTimeImmutable
     */
    public function filterDateTimeImmutable($date): ?\DateTimeImmutable
    {
        return $this->getCalendar()->filterDateTimeImmutable($date);
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return null|\DateTime
     */
    public function filterDateTime($date): ?\DateTime
    {
        return $this->getCalendar()->filterDateTime($date);
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return null|\DateTimeZone
     */
    public function filterDateTimeZone($timezone): ?\DateTimeZone
    {
        return $this->getCalendar()->filterDateTimeZone($timezone);
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return null|\DateInterval
     */
    public function filterDateInterval($interval): ?\DateInterval
    {
        return $this->getCalendar()->filterDateInterval($interval);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTimeImmutable
     */
    public function filterIDate($date)
    {
        return $this->getCalendar()->filterIDate($date);
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return null|int|float|string|\DateTime
     */
    public function filterDate($date)
    {
        return $this->getCalendar()->filterDate($date);
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return null|string|\DateTimeZone
     */
    public function filterTimezone($timezone)
    {
        return $this->getCalendar()->filterTimezone($timezone);
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return null|string|\DateInterval
     */
    public function filterInterval($interval)
    {
        return $this->getCalendar()->filterInterval($interval);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurl($ch)
    {
        return $this->getCurl()->filterCurl($ch);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurlFresh($ch)
    {
        return $this->getCurl()->filterCurlFresh($ch);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterFilename($value): ?string
    {
        return $this->getFs()->filterFilename($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPath($value): ?string
    {
        return $this->getFs()->filterPath($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFileExists($value): ?string
    {
        return $this->getFs()->filterPathFileExists($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathDir($value): ?string
    {
        return $this->getFs()->filterPathDir($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathLink($value): ?string
    {
        return $this->getFs()->filterPathLink($value);
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function filterPathFile($value): ?string
    {
        return $this->getFs()->filterPathFile($value);
    }

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return null|string
     */
    public function filterPathImage($value, $mimetypes = null): ?string
    {
        return $this->getFs()->filterPathImage($value, $mimetypes);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResource($h)
    {
        return $this->getFs()->filterResource($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResourceOpened($h)
    {
        return $this->getFs()->filterResourceOpened($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResourceClosed($h)
    {
        return $this->getFs()->filterResourceClosed($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResourceReadable($h)
    {
        return $this->getFs()->filterResourceReadable($h);
    }

    /**
     * @param resource|mixed $h
     *
     * @return null|resource
     */
    public function filterResourceWritable($h)
    {
        return $this->getFs()->filterResourceWritable($h);
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterFileInfo($value): ?\SplFileInfo
    {
        return $this->getFs()->filterFileInfo($value);
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return null|\SplFileObject
     */
    public function filterFileObject($value): ?\SplFileObject
    {
        return $this->getFs()->filterFileObject($value);
    }

    /**
     * @param string|mixed $className
     *
     * @return null|string
     */
    public function filterClassName($className): ?string
    {
        return $this->getLoader()->filterClassName($className);
    }

    /**
     * @param string|mixed $classFullname
     *
     * @return null|string
     */
    public function filterClassFullname($classFullname): ?string
    {
        return $this->getLoader()->filterClassFullname($classFullname);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterClassOneOf($value, $classes)
    {
        return $this->getLoader()->filterClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterSubclassOneOf($value, $classes)
    {
        return $this->getLoader()->filterSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public function filterInstanceOneOf($object, $classes): ?object
    {
        return $this->getLoader()->filterInstanceOneOf($object, $classes);
    }

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return null|object
     */
    public function filterContract($object, $contract): ?object
    {
        return $this->getLoader()->filterContract($object, $contract);
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return null|\ReflectionClass
     */
    public function filterReflectionClass($value): ?\ReflectionClass
    {
        return $this->getLoader()->filterReflectionClass($value);
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return null|\ReflectionFunction
     */
    public function filterReflectionFunction($value): ?\ReflectionFunction
    {
        return $this->getLoader()->filterReflectionFunction($value);
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return null|\ReflectionMethod
     */
    public function filterReflectionMethod($value): ?\ReflectionMethod
    {
        return $this->getLoader()->filterReflectionMethod($value);
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return null|\ReflectionProperty
     */
    public function filterReflectionProperty($value): ?\ReflectionProperty
    {
        return $this->getLoader()->filterReflectionProperty($value);
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return null|\ReflectionParameter
     */
    public function filterReflectionParameter($value): ?\ReflectionParameter
    {
        return $this->getLoader()->filterReflectionParameter($value);
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return null|\ReflectionType
     */
    public function filterReflectionType($value): ?\ReflectionType
    {
        return $this->getLoader()->filterReflectionType($value);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return null|\ReflectionUnionType
     */
    public function filterReflectionUnionType($reflectionType)
    {
        return $this->getLoader()->filterReflectionUnionType($reflectionType);
    }

    /**
     * @param mixed $reflectionType
     *
     * @return null|\ReflectionNamedType
     */
    public function filterReflectionNamedType($reflectionType)
    {
        return $this->getLoader()->filterReflectionNamedType($reflectionType);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterAlgorism($value): ?string
    {
        return $this->getMath()->filterAlgorism($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterAlgorismval($value)
    {
        return $this->getMath()->filterAlgorismval($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcGt0($value)
    {
        return $this->getMath()->filterBcGt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcGte0($value)
    {
        return $this->getMath()->filterBcGte0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcLt0($value)
    {
        return $this->getMath()->filterBcLt0($value);
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return null|int|float|string|MathBcval
     */
    public function filterBcLte0($value)
    {
        return $this->getMath()->filterBcLte0($value);
    }

    /**
     * @param string $ip
     *
     * @return null|string
     */
    public function filterIp(string $ip): ?string
    {
        return $this->getNet()->filterIp($ip);
    }

    /**
     * @param string $mask
     *
     * @return null|array
     */
    public function filterMask(string $mask): ?array
    {
        return $this->getNet()->filterMask($mask);
    }

    /**
     * @param int|mixed $value
     *
     * @return null|int
     */
    public function filterInt($value): ?int
    {
        return $this->getNum()->filterInt($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function filterFloat($value): ?float
    {
        return $this->getNum()->filterFloat($value);
    }

    /**
     * @param float|mixed $value
     *
     * @return null|float
     */
    public function filterNan($value): ?float
    {
        return $this->getNum()->filterNan($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float
     */
    public function filterNum($value)
    {
        return $this->getNum()->filterNum($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|string
     */
    public function filterIntval($value): ?int
    {
        return $this->getNum()->filterIntval($value);
    }

    /**
     * @param float|string|mixed $value
     *
     * @return null|float|string
     */
    public function filterFloatval($value): ?float
    {
        return $this->getNum()->filterFloatval($value);
    }

    /**
     * @param int|float|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumval($value)
    {
        return $this->getNum()->filterNumval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterNumericval($value)
    {
        return $this->getNum()->filterNumericval($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumGt0($value)
    {
        return $this->getNum()->filterNumGt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumGte0($value)
    {
        return $this->getNum()->filterNumGte0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumLt0($value)
    {
        return $this->getNum()->filterNumLt0($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float
     */
    public function filterNumLte0($value)
    {
        return $this->getNum()->filterNumLte0($value);
    }

    /**
     * @param string|mixed $phpKeyword
     *
     * @return null|string
     */
    public function filterPhpKeyword($phpKeyword): ?string
    {
        return $this->getPhp()->filterPhpKeyword($phpKeyword);
    }

    /**
     * @param bool|mixed $value
     *
     * @return null|bool
     */
    public function filterBool($value): ?bool
    {
        return $this->getPhp()->filterBool($value);
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return null|string|array|\Closure|callable
     */
    public function filterCallable($callable, PhpInvokableInfo &$invokableInfo = null)
    {
        return $this->getPhp()->filterCallable($callable, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null)
    {
        return $this->getPhp()->filterCallableOnly($callable, $invokableInfo);
    }

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterCallableFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null): ?\Closure
    {
        return $this->getPhp()->filterCallableFactory($factory, $returnType, $invokableInfo);
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return null|string|array|callable
     */
    public function filterCallableString($callableString, PhpInvokableInfo &$invokableInfo = null)
    {
        return $this->getPhp()->filterCallableString($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringFunction($callableString, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        return $this->getPhp()->filterCallableStringFunction($callableString, $invokableInfo);
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        return $this->getPhp()->filterCallableStringStatic($callableString, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return $this->getPhp()->filterCallableArray($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return $this->getPhp()->filterCallableArrayStatic($callableArray, $invokableInfo);
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array|callable
     */
    public function filterCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return $this->getPhp()->filterCallableArrayPublic($callableArray, $invokableInfo);
    }

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterClosure($closure, PhpInvokableInfo &$invokableInfo = null): ?\Closure
    {
        return $this->getPhp()->filterClosure($closure, $invokableInfo);
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return null|array
     */
    public function filterMethodArray($methodArray): ?array
    {
        return $this->getPhp()->filterMethodArray($methodArray);
    }

    /**
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|array
     */
    public function filterMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        return $this->getPhp()->filterMethodArrayReflection($methodArray, $invokableInfo);
    }

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|string|callable
     */
    public function filterHandler($handler, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        return $this->getPhp()->filterHandler($handler, $invokableInfo);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterThrowable($value)
    {
        return $this->getPhp()->filterThrowable($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterError($value)
    {
        return $this->getPhp()->filterError($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterException($value)
    {
        return $this->getPhp()->filterException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterRuntimeException($value)
    {
        return $this->getPhp()->filterRuntimeException($value);
    }

    /**
     * @param object|mixed $value
     *
     * @return null|object
     */
    public function filterLogicException($value)
    {
        return $this->getPhp()->filterLogicException($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterStringUtf8($value): ?string
    {
        return $this->getStr()->filterStringUtf8($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterString($value): ?string
    {
        return $this->getStr()->filterString($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLetter($value): ?string
    {
        return $this->getStr()->filterLetter($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterWord($value): ?string
    {
        return $this->getStr()->filterWord($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrInt($value)
    {
        return $this->getStr()->filterStringOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterLetterOrInt($value)
    {
        return $this->getStr()->filterLetterOrInt($value);
    }

    /**
     * @param int|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrInt($value)
    {
        return $this->getStr()->filterWordOrInt($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrNum($value)
    {
        return $this->getStr()->filterStringOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterLetterOrNum($value)
    {
        return $this->getStr()->filterLetterOrNum($value);
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return null|int|float|string
     */
    public function filterWordOrNum($value)
    {
        return $this->getStr()->filterWordOrNum($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterStrval($value)
    {
        return $this->getStr()->filterStrval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterLetterval($value)
    {
        return $this->getStr()->filterLetterval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterWordval($value)
    {
        return $this->getStr()->filterWordval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|int|float|string|object
     */
    public function filterTrimval($value)
    {
        return $this->getStr()->filterTrimval($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLink($value): ?string
    {
        return $this->getUri()->filterLink($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterUrl($value): ?string
    {
        return $this->getUri()->filterUrl($value);
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return array
     */
    public function assertArray($array, callable $of = null): ?array
    {
        if (null === ( $var = $this->getArr()->filterArray($array, $of) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Array` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return array
     */
    public function assertList($list, callable $of = null): ?array
    {
        if (null === ( $var = $this->getArr()->filterList($list, $of) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `List` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return array
     */
    public function assertDict($dict, callable $of = null): ?array
    {
        if (null === ( $var = $this->getArr()->filterDict($dict, $of) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Dict` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return array
     */
    public function assertAssoc($assoc, callable $of = null): ?array
    {
        if (null === ( $var = $this->getArr()->filterAssoc($assoc, $of) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Assoc` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * проверяет, содержит ли массив вложенные массивы
     *
     * @param array|mixed $array
     * @param null|int    $depth
     *
     * @return array
     */
    public function assertArrayDeep($array, int $depth = null): ?array
    {
        if (null === ( $var = $this->getArr()->filterArrayDeep($array, $depth) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ArrayDeep` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * проверяет, можно ли массив безопасно сериализовать
     *
     * @param array|mixed $array
     *
     * @return array
     */
    public function assertArrayPlain($array): ?array
    {
        if (null === ( $var = $this->getArr()->filterArrayPlain($array) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ArrayPlain` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * проверяет, может ли переменная быть приведена к массиву
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function assertArrval($value)
    {
        if (null === ( $var = $this->getArr()->filterArrval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Arrval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertArrayKey($value)
    {
        if (null === ( $var = $this->getArr()->filterArrayKey($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ArrayKey` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \DateTimeInterface|mixed $date
     *
     * @return \DateTimeInterface
     */
    public function assertDateTimeInterface($date): ?\DateTimeInterface
    {
        if (null === ( $var = $this->getCalendar()->filterDateTimeInterface($date) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `DateTimeInterface` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \DateTimeImmutable|mixed $date
     *
     * @return \DateTimeImmutable
     */
    public function assertDateTimeImmutable($date): ?\DateTimeImmutable
    {
        if (null === ( $var = $this->getCalendar()->filterDateTimeImmutable($date) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `DateTimeImmutable` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \DateTime|mixed $date
     *
     * @return \DateTime
     */
    public function assertDateTime($date): ?\DateTime
    {
        if (null === ( $var = $this->getCalendar()->filterDateTime($date) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `DateTime` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \DateTimeZone|mixed $timezone
     *
     * @return \DateTimeZone
     */
    public function assertDateTimeZone($timezone): ?\DateTimeZone
    {
        if (null === ( $var = $this->getCalendar()->filterDateTimeZone($timezone) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `DateTimeZone` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \DateInterval|mixed $interval
     *
     * @return \DateInterval
     */
    public function assertDateInterval($interval): ?\DateInterval
    {
        if (null === ( $var = $this->getCalendar()->filterDateInterval($interval) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `DateInterval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTimeImmutable
     */
    public function assertIDate($date)
    {
        if (null === ( $var = $this->getCalendar()->filterIDate($date) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `IDate` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|\DateTimeInterface|mixed $date
     *
     * @return int|float|string|\DateTime
     */
    public function assertDate($date)
    {
        if (null === ( $var = $this->getCalendar()->filterDate($date) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Date` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return string|\DateTimeZone
     */
    public function assertTimezone($timezone)
    {
        if (null === ( $var = $this->getCalendar()->filterTimezone($timezone) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Timezone` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|\DateInterval $interval
     *
     * @return string|\DateInterval
     */
    public function assertInterval($interval)
    {
        if (null === ( $var = $this->getCalendar()->filterInterval($interval) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Interval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return resource|\CurlHandle
     */
    public function assertCurl($ch)
    {
        if (null === ( $var = $this->getCurl()->filterCurl($ch) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Curl` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return resource|\CurlHandle
     */
    public function assertCurlFresh($ch)
    {
        if (null === ( $var = $this->getCurl()->filterCurlFresh($ch) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CurlFresh` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertFilename($value): ?string
    {
        if (null === ( $var = $this->getFs()->filterFilename($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Filename` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPath($value): ?string
    {
        if (null === ( $var = $this->getFs()->filterPath($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Path` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathFileExists($value): ?string
    {
        if (null === ( $var = $this->getFs()->filterPathFileExists($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `PathFileExists` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathDir($value): ?string
    {
        if (null === ( $var = $this->getFs()->filterPathDir($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `PathDir` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathLink($value): ?string
    {
        if (null === ( $var = $this->getFs()->filterPathLink($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `PathLink` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function assertPathFile($value): ?string
    {
        if (null === ( $var = $this->getFs()->filterPathFile($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `PathFile` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $value
     * @param array  $mimetypes
     *
     * @return string
     */
    public function assertPathImage($value, $mimetypes = null): ?string
    {
        if (null === ( $var = $this->getFs()->filterPathImage($value, $mimetypes) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `PathImage` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResource($h)
    {
        if (null === ( $var = $this->getFs()->filterResource($h) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Resource` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResourceOpened($h)
    {
        if (null === ( $var = $this->getFs()->filterResourceOpened($h) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ResourceOpened` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResourceClosed($h)
    {
        if (null === ( $var = $this->getFs()->filterResourceClosed($h) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ResourceClosed` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResourceReadable($h)
    {
        if (null === ( $var = $this->getFs()->filterResourceReadable($h) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ResourceReadable` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResourceWritable($h)
    {
        if (null === ( $var = $this->getFs()->filterResourceWritable($h) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ResourceWritable` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return \SplFileInfo
     */
    public function assertFileInfo($value): ?\SplFileInfo
    {
        if (null === ( $var = $this->getFs()->filterFileInfo($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `FileInfo` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return \SplFileObject
     */
    public function assertFileObject($value): ?\SplFileObject
    {
        if (null === ( $var = $this->getFs()->filterFileObject($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `FileObject` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $className
     *
     * @return string
     */
    public function assertClassName($className): ?string
    {
        if (null === ( $var = $this->getLoader()->filterClassName($className) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ClassName` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $classFullname
     *
     * @return string
     */
    public function assertClassFullname($classFullname): ?string
    {
        if (null === ( $var = $this->getLoader()->filterClassFullname($classFullname) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ClassFullname` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return string|object
     */
    public function assertClassOneOf($value, $classes)
    {
        if (null === ( $var = $this->getLoader()->filterClassOneOf($value, $classes) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ClassOneOf` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return string|object
     */
    public function assertSubclassOneOf($value, $classes)
    {
        if (null === ( $var = $this->getLoader()->filterSubclassOneOf($value, $classes) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `SubclassOneOf` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return object
     */
    public function assertInstanceOneOf($object, $classes): ?object
    {
        if (null === ( $var = $this->getLoader()->filterInstanceOneOf($object, $classes) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `InstanceOneOf` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return object
     */
    public function assertContract($object, $contract): ?object
    {
        if (null === ( $var = $this->getLoader()->filterContract($object, $contract) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Contract` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return \ReflectionClass
     */
    public function assertReflectionClass($value): ?\ReflectionClass
    {
        if (null === ( $var = $this->getLoader()->filterReflectionClass($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ReflectionClass` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return \ReflectionFunction
     */
    public function assertReflectionFunction($value): ?\ReflectionFunction
    {
        if (null === ( $var = $this->getLoader()->filterReflectionFunction($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ReflectionFunction` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return \ReflectionMethod
     */
    public function assertReflectionMethod($value): ?\ReflectionMethod
    {
        if (null === ( $var = $this->getLoader()->filterReflectionMethod($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ReflectionMethod` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return \ReflectionProperty
     */
    public function assertReflectionProperty($value): ?\ReflectionProperty
    {
        if (null === ( $var = $this->getLoader()->filterReflectionProperty($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ReflectionProperty` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return \ReflectionParameter
     */
    public function assertReflectionParameter($value): ?\ReflectionParameter
    {
        if (null === ( $var = $this->getLoader()->filterReflectionParameter($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ReflectionParameter` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return \ReflectionType
     */
    public function assertReflectionType($value): ?\ReflectionType
    {
        if (null === ( $var = $this->getLoader()->filterReflectionType($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ReflectionType` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param mixed $reflectionType
     *
     * @return \ReflectionUnionType
     */
    public function assertReflectionUnionType($reflectionType)
    {
        if (null === ( $var = $this->getLoader()->filterReflectionUnionType($reflectionType) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ReflectionUnionType` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param mixed $reflectionType
     *
     * @return \ReflectionNamedType
     */
    public function assertReflectionNamedType($reflectionType)
    {
        if (null === ( $var = $this->getLoader()->filterReflectionNamedType($reflectionType) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `ReflectionNamedType` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertAlgorism($value): ?string
    {
        if (null === ( $var = $this->getMath()->filterAlgorism($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Algorism` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertAlgorismval($value)
    {
        if (null === ( $var = $this->getMath()->filterAlgorismval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Algorismval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public function assertBcGt0($value)
    {
        if (null === ( $var = $this->getMath()->filterBcGt0($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `BcGt0` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public function assertBcGte0($value)
    {
        if (null === ( $var = $this->getMath()->filterBcGte0($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `BcGte0` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public function assertBcLt0($value)
    {
        if (null === ( $var = $this->getMath()->filterBcLt0($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `BcLt0` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|MathBcval|mixed $value
     *
     * @return int|float|string|MathBcval
     */
    public function assertBcLte0($value)
    {
        if (null === ( $var = $this->getMath()->filterBcLte0($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `BcLte0` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $ip
     *
     * @return string
     */
    public function assertIp(string $ip): ?string
    {
        if (null === ( $var = $this->getNet()->filterIp($ip) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Ip` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string $mask
     *
     * @return array
     */
    public function assertMask(string $mask): ?array
    {
        if (null === ( $var = $this->getNet()->filterMask($mask) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Mask` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function assertInt($value): ?int
    {
        if (null === ( $var = $this->getNum()->filterInt($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Int` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function assertFloat($value): ?float
    {
        if (null === ( $var = $this->getNum()->filterFloat($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Float` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function assertNan($value): ?float
    {
        if (null === ( $var = $this->getNum()->filterNan($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Nan` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function assertNum($value)
    {
        if (null === ( $var = $this->getNum()->filterNum($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Num` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertIntval($value): ?int
    {
        if (null === ( $var = $this->getNum()->filterIntval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Intval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param float|string|mixed $value
     *
     * @return float|string
     */
    public function assertFloatval($value): ?float
    {
        if (null === ( $var = $this->getNum()->filterFloatval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Floatval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float|string
     */
    public function assertNumval($value)
    {
        if (null === ( $var = $this->getNum()->filterNumval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Numval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertNumericval($value)
    {
        if (null === ( $var = $this->getNum()->filterNumericval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Numericval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNumGt0($value)
    {
        if (null === ( $var = $this->getNum()->filterNumGt0($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `NumGt0` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNumGte0($value)
    {
        if (null === ( $var = $this->getNum()->filterNumGte0($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `NumGte0` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNumLt0($value)
    {
        if (null === ( $var = $this->getNum()->filterNumLt0($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `NumLt0` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float
     */
    public function assertNumLte0($value)
    {
        if (null === ( $var = $this->getNum()->filterNumLte0($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `NumLte0` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $phpKeyword
     *
     * @return string
     */
    public function assertPhpKeyword($phpKeyword): ?string
    {
        if (null === ( $var = $this->getPhp()->filterPhpKeyword($phpKeyword) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `PhpKeyword` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public function assertBool($value): ?bool
    {
        if (null === ( $var = $this->getPhp()->filterBool($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Bool` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|PhpInvokableInfo                $invokableInfo
     *
     * @return string|array|\Closure|callable
     */
    public function assertCallable($callable, PhpInvokableInfo &$invokableInfo = null)
    {
        if (null === ( $var = $this->getPhp()->filterCallable($callable, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Callable` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|array|callable|mixed $callable
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return string|array|callable
     */
    public function assertCallableOnly($callable, PhpInvokableInfo &$invokableInfo = null)
    {
        if (null === ( $var = $this->getPhp()->filterCallableOnly($callable, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CallableOnly` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public function assertCallableFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null): ?\Closure
    {
        if (null === ( $var = $this->getPhp()->filterCallableFactory($factory, $returnType, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CallableFactory` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|PhpInvokableInfo       $invokableInfo
     *
     * @return string|array|callable
     */
    public function assertCallableString($callableString, PhpInvokableInfo &$invokableInfo = null)
    {
        if (null === ( $var = $this->getPhp()->filterCallableString($callableString, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CallableString` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringFunction($callableString, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        if (null === ( $var = $this->getPhp()->filterCallableStringFunction($callableString, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CallableStringFunction` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringStatic($callableString, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        if (null === ( $var = $this->getPhp()->filterCallableStringStatic($callableString, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CallableStringStatic` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArray($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        if (null === ( $var = $this->getPhp()->filterCallableArray($callableArray, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CallableArray` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayStatic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        if (null === ( $var = $this->getPhp()->filterCallableArrayStatic($callableArray, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CallableArrayStatic` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param array|callable|mixed  $callableArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayPublic($callableArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        if (null === ( $var = $this->getPhp()->filterCallableArrayPublic($callableArray, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `CallableArrayPublic` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param \Closure|mixed        $closure
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public function assertClosure($closure, PhpInvokableInfo &$invokableInfo = null): ?\Closure
    {
        if (null === ( $var = $this->getPhp()->filterClosure($closure, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Closure` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return array
     */
    public function assertMethodArray($methodArray): ?array
    {
        if (null === ( $var = $this->getPhp()->filterMethodArray($methodArray) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `MethodArray` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param array|mixed           $methodArray
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return array
     */
    public function assertMethodArrayReflection($methodArray, PhpInvokableInfo &$invokableInfo = null): ?array
    {
        if (null === ( $var = $this->getPhp()->filterMethodArrayReflection($methodArray, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `MethodArrayReflection` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed          $handler
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertHandler($handler, PhpInvokableInfo &$invokableInfo = null): ?string
    {
        if (null === ( $var = $this->getPhp()->filterHandler($handler, $invokableInfo) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Handler` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertThrowable($value)
    {
        if (null === ( $var = $this->getPhp()->filterThrowable($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Throwable` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertError($value)
    {
        if (null === ( $var = $this->getPhp()->filterError($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Error` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertException($value)
    {
        if (null === ( $var = $this->getPhp()->filterException($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Exception` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertRuntimeException($value)
    {
        if (null === ( $var = $this->getPhp()->filterRuntimeException($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `RuntimeException` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertLogicException($value)
    {
        if (null === ( $var = $this->getPhp()->filterLogicException($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `LogicException` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertStringUtf8($value): ?string
    {
        if (null === ( $var = $this->getStr()->filterStringUtf8($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `StringUtf8` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertString($value): ?string
    {
        if (null === ( $var = $this->getStr()->filterString($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `String` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertLetter($value): ?string
    {
        if (null === ( $var = $this->getStr()->filterLetter($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Letter` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertWord($value): ?string
    {
        if (null === ( $var = $this->getStr()->filterWord($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Word` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrInt($value)
    {
        if (null === ( $var = $this->getStr()->filterStringOrInt($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `StringOrInt` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertLetterOrInt($value)
    {
        if (null === ( $var = $this->getStr()->filterLetterOrInt($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `LetterOrInt` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrInt($value)
    {
        if (null === ( $var = $this->getStr()->filterWordOrInt($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `WordOrInt` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrNum($value)
    {
        if (null === ( $var = $this->getStr()->filterStringOrNum($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `StringOrNum` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertLetterOrNum($value)
    {
        if (null === ( $var = $this->getStr()->filterLetterOrNum($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `LetterOrNum` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrNum($value)
    {
        if (null === ( $var = $this->getStr()->filterWordOrNum($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `WordOrNum` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertStrval($value)
    {
        if (null === ( $var = $this->getStr()->filterStrval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Strval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertLetterval($value)
    {
        if (null === ( $var = $this->getStr()->filterLetterval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Letterval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertWordval($value)
    {
        if (null === ( $var = $this->getStr()->filterWordval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Wordval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return int|float|string|object
     */
    public function assertTrimval($value)
    {
        if (null === ( $var = $this->getStr()->filterTrimval($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Trimval` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertLink($value): ?string
    {
        if (null === ( $var = $this->getUri()->filterLink($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Link` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertUrl($value): ?string
    {
        if (null === ( $var = $this->getUri()->filterUrl($value) )) {
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getMessageOr(
                    'Invalid `Url` passed: %s', ...func_get_args()
                ))
            );
        }

        return $var;
    }
}
