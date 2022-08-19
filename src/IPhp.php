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

use Gzhegow\Support\Domain\Php\ValueObject\PhpInvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;

interface IPhp
{
    /**
     * @return PhpInvokableInfo
     */
    public function newInvokableInfo(): PhpInvokableInfo;

    /**
     * @param mixed &$value
     *
     * @return bool
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public function isBlank(&$value): bool;

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
     * @param \Closure              $factory
     * @param string|callable       $returnType
     * @param null|PhpInvokableInfo $invokableInfo
     *
     * @return null|\Closure
     */
    public function filterClosureFactory($factory, $returnType, PhpInvokableInfo &$invokableInfo = null): ?\Closure;

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
     * возвращает идентификатор значения любой переменной в виде строки для дальнейшего сравнения
     * идентификаторы могут быть позже использованы другими обьектами
     * поэтому его актуальность до тех пор, пока конкретный обьект существует в памяти
     *
     * @param mixed $value
     *
     * @return string
     */
    public function uniqhash($value): string;

    /**
     * @param object $object
     *
     * @return array
     */
    public function objKeys(object $object): array;

    /**
     * @param object $object
     *
     * @return array
     */
    public function objVars(object $object): array;

    /**
     * @param object $object
     *
     * @return array
     */
    public function objKeysPublic(object $object): array;

    /**
     * @param object $object
     *
     * @return array
     */
    public function objVarsPublic(object $object): array;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargs(...$arguments): array;

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function kwargsPreserveKeys(...$arguments): array;

    /**
     * @param int|float $min
     * @param int|float ...$max
     *
     * @return XPhp
     */
    public function sleep($min, ...$max);

    /**
     * bind
     * копирует тело функции и присваивает аргументы на их места в переданном порядке
     * bind('is_array', [], 1, 2) -> Closure of (function is_array($var = []))
     *
     * @param callable $func
     * @param mixed    ...$arguments
     *
     * @return \Closure
     */
    public function bind(callable $func, ...$arguments): \Closure;

    /**
     * call
     * шорткат для call_user_func с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function call(callable $func, ...$arguments);

    /**
     * apply
     * шорткат для call_user_func_array с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function apply(callable $func, array $arguments);

    /**
     * выполняет функцию как шаг array_filter
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return bool|array
     */
    public function callFilter(?callable $func, $arg, ...$arguments): bool;

    /**
     * выполняет функцию как шаг array_map
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return mixed
     */
    public function callMap(?callable $func, $arg, ...$arguments);

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
    public function callReduce(?callable $func, $arg, $carry = null, ...$arguments);

    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return null|\ReflectionType
     */
    public function reflectionPropertyGetType(\ReflectionProperty $reflectionProperty);

    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return null|bool
     */
    public function reflectionPropertyHasDefaultValue(\ReflectionProperty $reflectionProperty): ?bool;

    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и отфильтровать их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $coalesce
     *
     * @return null|mixed
     */
    public function overload(?array &$args, $num, callable $coalesce = null);

    /**
     * Выполняет func_get_arg($num) позволяя задать вероятные позиции аргумента и проверить их
     *
     * @param null|array    $args
     * @param int|int[]     $num
     * @param null|callable $if
     *
     * @return null|mixed
     */
    public function overloadIf(?array &$args, $num, callable $if = null);

    /**
     * @param int|null $limit
     *
     * @return string
     */
    public function obGetFlush(int $limit = null): string;

    /**
     * @param int|null $limit
     *
     * @return void
     */
    public function obEndFlush(int $limit = null);
}
