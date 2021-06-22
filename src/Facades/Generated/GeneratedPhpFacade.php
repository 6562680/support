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
use Gzhegow\Support\Exceptions\Runtime\UnexpectedValueException;
use Gzhegow\Support\Php;

abstract class GeneratedPhpFacade
{
    /**
     * @param mixed &$value
     *
     * @return bool
     */
    public static function isBlank(&$value): bool
    {
        return static::getInstance()->isBlank($value);
    }

    /**
     * @param mixed &$value
     *
     * @return bool
     */
    public static function isNotBlank(&$value): bool
    {
        return static::getInstance()->isNotBlank($value);
    }

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
     * @param \Closure        $factory
     * @param string|callable $returnType
     *
     * @return null|\Closure
     */
    public static function filterFactory(\Closure $factory, $returnType): ?\Closure
    {
        return static::getInstance()->filterFactory($factory, $returnType);
    }

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public static function assertBlank(&$value)
    {
        return static::getInstance()->assertBlank($value);
    }

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public static function assertNotBlank(&$value)
    {
        return static::getInstance()->assertNotBlank($value);
    }

    /**
     * @param mixed &$value
     *
     * @return mixed
     */
    public static function assertIsset(&$value)
    {
        return static::getInstance()->assertIsset($value);
    }

    /**
     * @param string $key
     * @param array  $array
     *
     * @return mixed
     */
    public static function assertKeyExists(string $key, array $array)
    {
        return static::getInstance()->assertKeyExists($key, $array);
    }

    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return \Closure
     */
    public static function assertFactory(\Closure $func, $returnType): \Closure
    {
        return static::getInstance()->assertFactory($func, $returnType);
    }

    /**
     * возвращает строчный идентификатор значения любой переменной в виде строки для дальнейшего сравнения
     * идентификаторы могут быть позже использованы другими обьектами
     * поэтому его актуальность до тех пор, пока конкретный обьект существует
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function hash($value): string
    {
        return static::getInstance()->hash($value);
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
     * Превращает примитивы и массивы любой вложенности в одноуровневый список
     *
     * @param mixed ...$items
     *
     * @return array
     */
    public static function listval(...$items): array
    {
        return static::getInstance()->listval(...$items);
    }

    /**
     * Превращает каждый аргумент из примитивов и массивов любой вложенности в список списков
     *
     * @param mixed ...$lists
     *
     * @return array
     */
    public static function listvals(...$lists): array
    {
        return static::getInstance()->listvals(...$lists);
    }

    /**
     * Превращает enum-список любой вложенности (значения могут быть в ключах или в полях) в список уникальных значений
     *
     * @param mixed ...$items
     *
     * @return array
     */
    public static function enumval(...$items): array
    {
        return static::getInstance()->enumval(...$items);
    }

    /**
     * Превращает каждый аргумент с помощью enumval
     *
     * @param mixed ...$enums
     *
     * @return array
     */
    public static function enumvals(...$enums): array
    {
        return static::getInstance()->enumvals(...$enums);
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
    public static function kwargsDistinct(...$arguments): array
    {
        return static::getInstance()->kwargsDistinct(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function theKwargs(...$arguments): array
    {
        return static::getInstance()->theKwargs(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwargsFlatten(...$arguments): array
    {
        return static::getInstance()->kwargsFlatten(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwargsFlattenDistinct(...$arguments): array
    {
        return static::getInstance()->kwargsFlattenDistinct(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function theKwargsFlatten(...$arguments): array
    {
        return static::getInstance()->theKwargsFlatten(...$arguments);
    }

    /**
     * Превращает примитивы и массивы любой вложенности в одноуровневый список
     *
     * @param mixed ...$items
     *
     * @return array
     */
    public static function collect(...$items): array
    {
        return static::getInstance()->collect(...$items);
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public static function distinct(array $values): array
    {
        return static::getInstance()->distinct($values);
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public static function unique(...$values): array
    {
        return static::getInstance()->unique(...$values);
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public static function uniqueFlatten(...$values): array
    {
        return static::getInstance()->uniqueFlatten(...$values);
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public static function duplicates(...$values): array
    {
        return static::getInstance()->duplicates(...$values);
    }

    /**
     * @param mixed ...$values
     *
     * @return array
     */
    public static function duplicatesFlatten(...$values): array
    {
        return static::getInstance()->duplicatesFlatten(...$values);
    }

    /**
     * @param int|float|int[]|float[] $sleeps
     *
     * @return Php
     */
    public static function sleep(...$sleeps)
    {
        return static::getInstance()->sleep(...$sleeps);
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
     * @return Php
     */
    abstract public static function getInstance(): Php;
}
