<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Func;

abstract class GeneratedFuncFacade
{
    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return bool
     */
    public static function isFactory(\Closure $func, string $returnType): bool
    {
        return static::getInstance()->isFactory($func, $returnType);
    }

    /**
     * проверяет возвращаемый тип у замыкания
     *
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return null|\Closure
     */
    public static function filterFactory(\Closure $func, string $returnType): ?\Closure
    {
        return static::getInstance()->filterFactory($func, $returnType);
    }

    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return \Closure
     */
    public static function assertFactory(\Closure $func, string $returnType): \Closure
    {
        return static::getInstance()->assertFactory($func, $returnType);
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
    public static function filter(?callable $func, $arg, ...$arguments): bool
    {
        return static::getInstance()->filter($func, $arg, ...$arguments);
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
    public static function map(?callable $func, $arg, ...$arguments)
    {
        return static::getInstance()->map($func, $arg, ...$arguments);
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
    public static function reduce(?callable $func, $arg, $carry = null, ...$arguments)
    {
        return static::getInstance()->reduce($func, $arg, $carry, ...$arguments);
    }

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
    public static function bind(callable $func, ...$arguments): \Closure
    {
        return static::getInstance()->bind($func, ...$arguments);
    }

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
    public static function call(callable $func, ...$arguments)
    {
        return static::getInstance()->call($func, ...$arguments);
    }

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
    public static function apply(callable $func, array $arguments)
    {
        return static::getInstance()->apply($func, $arguments);
    }

    /**
     * @return Func
     */
    abstract public static function getInstance(): Func;
}
