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
     * @param object $object
     *
     * @return array
     */
    public static function getPublicVars(object $object): array
    {
        return static::getInstance()->getPublicVars($object);
    }

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
     * @param string $name
     * @param null   $value
     *
     * @return null|string
     */
    public static function const(string $name, $value = null): ?string
    {
        return static::getInstance()->const($name, $value);
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
     * @param mixed ...$enumlists
     *
     * @return array
     */
    public static function enumvals(...$enumlists): array
    {
        return static::getInstance()->enumvals(...$enumlists);
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
     * @param null|\Throwable $e
     * @param null|int        $limit
     *
     * @return array
     */
    public static function throwableMessages(\Throwable $e, int $limit = -1)
    {
        return static::getInstance()->throwableMessages($e, $limit);
    }

    /**
     * @return Php
     */
    abstract public static function getInstance(): Php;
}
