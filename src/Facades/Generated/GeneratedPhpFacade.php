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
     * @param mixed $value
     *
     * @return bool
     */
    public static function isEmpty($value): bool
    {
        return static::getInstance()->isEmpty($value);
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
     * @param mixed $value
     *
     * @return null|int
     */
    public static function intval($value): ?int
    {
        return static::getInstance()->intval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function floatval($value): ?float
    {
        return static::getInstance()->floatval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public static function numval($value)
    {
        return static::getInstance()->numval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function strval($value): ?string
    {
        return static::getInstance()->strval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function theStrval($value): ?string
    {
        return static::getInstance()->theStrval($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public static function arrval($value): ?array
    {
        return static::getInstance()->arrval($value);
    }

    /**
     * @param mixed $classOrObject
     *
     * @return null|string
     */
    public static function classval($classOrObject): ?string
    {
        return static::getInstance()->classval($classOrObject);
    }

    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public static function listval(...$items): array
    {
        return static::getInstance()->listval(...$items);
    }

    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public static function listvalFlatten(...$items): array
    {
        return static::getInstance()->listvalFlatten(...$items);
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
    public static function kwparams(...$arguments): array
    {
        return static::getInstance()->kwparams(...$arguments);
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
     * @param int|float|int[]|float[] $sleeps
     *
     * @return Php
     */
    public static function sleep($sleeps)
    {
        return static::getInstance()->sleep($sleeps);
    }

    /**
     * @return Php
     */
    abstract public static function getInstance(): Php;
}
