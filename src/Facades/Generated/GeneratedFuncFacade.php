<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Func;

abstract class GeneratedFuncFacade
{
    /**
     * filter
     * выполняет функцию как array_filter. Если передать null, преобразует все аргументы к булеву типу
     * отталкивается от аргумента arg, работает над ним если null
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
     * map
     * выполняет функцию как array_map. Если передать null, возвращает исходные аргументы
     * отталкивается от аргумента arg, работает над ним если null
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
