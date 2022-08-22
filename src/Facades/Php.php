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

use Gzhegow\Support\Domain\Php\ValueObject\PhpInvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;
use Gzhegow\Support\IPhp;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\XPhp;

class Php
{
    /**
     * @return PhpInvokableInfo
     */
    public static function newInvokableInfo(): PhpInvokableInfo
    {
        return static::getInstance()->newInvokableInfo();
    }

    /**
     * @param mixed &$value
     *
     * @return bool
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public static function isBlank(&$value): bool
    {
        return static::getInstance()->isBlank($value);
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
     * возвращает идентификатор значения любой переменной в виде строки для дальнейшего сравнения
     * идентификаторы могут быть позже использованы другими обьектами
     * поэтому его актуальность до тех пор, пока конкретный обьект существует в памяти
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function uniqhash($value): string
    {
        return static::getInstance()->uniqhash($value);
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public static function objKeys(object $object): array
    {
        return static::getInstance()->objKeys($object);
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public static function objVars(object $object): array
    {
        return static::getInstance()->objVars($object);
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public static function objKeysPublic(object $object): array
    {
        return static::getInstance()->objKeysPublic($object);
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public static function objVarsPublic(object $object): array
    {
        return static::getInstance()->objVarsPublic($object);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwargs(...$arguments): array
    {
        return static::getInstance()->kwargs(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwargsPreserveKeys(...$arguments): array
    {
        return static::getInstance()->kwargsPreserveKeys(...$arguments);
    }

    /**
     * @param int|float $min
     * @param int|float ...$max
     *
     * @return XPhp
     */
    public static function sleep($min, ...$max)
    {
        return static::getInstance()->sleep($min, ...$max);
    }

    /**
     * bind
     * копирует тело функции и присваивает аргументы на их места в переданном порядке
     * bind('is_array', [], 1, 2) -> Closure of (function is_array($var = []))
     *
     * @param null|object $newthis
     * @param callable    $func
     * @param mixed       ...$arguments
     *
     * @return \Closure
     */
    public static function bind(?object $newthis, callable $func, ...$arguments): \Closure
    {
        return static::getInstance()->bind($newthis, $func, ...$arguments);
    }

    /**
     * call
     * шорткат для call_user_func с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param null|object $newthis
     * @param callable    $func
     * @param array       $arguments
     *
     * @return mixed
     */
    public static function call(?object $newthis, callable $func, ...$arguments)
    {
        return static::getInstance()->call($newthis, $func, ...$arguments);
    }

    /**
     * apply
     * шорткат для call_user_func_array с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param null|object $newthis
     * @param callable    $func
     * @param array       $arguments
     *
     * @return mixed
     */
    public static function apply(?object $newthis, callable $func, array $arguments)
    {
        return static::getInstance()->apply($newthis, $func, $arguments);
    }

    /**
     * выполняет функцию как шаг array_filter
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return bool|array
     */
    public static function callFilter(?callable $func, $arg, ...$arguments): bool
    {
        return static::getInstance()->callFilter($func, $arg, ...$arguments);
    }

    /**
     * выполняет функцию как шаг array_map
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return mixed
     */
    public static function callMap(?callable $func, $arg, ...$arguments)
    {
        return static::getInstance()->callMap($func, $arg, ...$arguments);
    }

    /**
     * выполняет функцию как шаг array_reduce
     *
     * @param null|callable $func
     * @param               $arg
     * @param null          $carry
     * @param array         $arguments
     *
     * @return mixed
     */
    public static function callReduce(?callable $func, $arg, $carry = null, ...$arguments)
    {
        return static::getInstance()->callReduce($func, $arg, $carry, ...$arguments);
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return null|\ReflectionType
     */
    public static function reflectionPropertyGetType(\ReflectionProperty $reflectionProperty)
    {
        return static::getInstance()->reflectionPropertyGetType($reflectionProperty);
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return null|bool
     */
    public static function reflectionPropertyHasDefaultValue(\ReflectionProperty $reflectionProperty): ?bool
    {
        return static::getInstance()->reflectionPropertyHasDefaultValue($reflectionProperty);
    }

    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и отфильтровать их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $coalesce
     *
     * @return null|mixed
     */
    public static function overload(?array &$args, $num, callable $coalesce = null)
    {
        return static::getInstance()->overload($args, $num, $coalesce);
    }

    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и проверить их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $if
     *
     * @return null|mixed
     */
    public static function overloadIf(?array &$args, $num, callable $if = null)
    {
        return static::getInstance()->overloadIf($args, $num, $if);
    }

    /**
     * @param int|null $limit
     *
     * @return string
     */
    public static function obGetFlush(int $limit = null): string
    {
        return static::getInstance()->obGetFlush($limit);
    }

    /**
     * @param int|null $limit
     *
     * @return void
     */
    public static function obEndFlush(int $limit = null)
    {
        return static::getInstance()->obEndFlush($limit);
    }

    /**
     * @return IPhp
     */
    public static function getInstance(): IPhp
    {
        return SupportFactory::getInstance()->getPhp();
    }
}
