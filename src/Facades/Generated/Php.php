<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Php as _Php;

abstract class Php
{
    /**
     * @param object $object
     *
     * @return array
     */
    public static function getPublicVars(object $object) : array
    {
        return static::getInstance()->getPublicVars($object);
    }

    /**
     * hash
     * возвращает строчный идентификатор значения любой переменной на текущий момент в виде строки для дальнейшего сравнения
     * идентификаторы могут быть позже использованы другими обьектами, поэтому его актуальность до тех пор, пока конкретный обьект существует
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function hash($value) : string
    {
        return static::getInstance()->hash($value);
    }

    /**
     * @param string $name
     * @param null   $value
     *
     * @return null|string
     */
    public static function const(string $name, $value = null) : ?string
    {
        return static::getInstance()->const($name, $value);
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    public static function arrval($data) : array
    {
        return static::getInstance()->arrval($data);
    }

    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public static function listval(...$items) : array
    {
        return static::getInstance()->listval(...$items);
    }

    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public static function listvalFlatten(...$items) : array
    {
        return static::getInstance()->listvalFlatten(...$items);
    }

    /**
     * @param callable $if
     * @param mixed    ...$items
     *
     * @return null|array
     */
    public static function listvalIf(callable $if, ...$items) : ?array
    {
        return static::getInstance()->listvalIf($if, ...$items);
    }

    /**
     * @param callable $if
     * @param mixed    ...$items
     *
     * @return null|array
     */
    public static function listvalFlattenIf(callable $if, ...$items) : ?array
    {
        return static::getInstance()->listvalFlattenIf($if, ...$items);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwargs(...$arguments) : array
    {
        return static::getInstance()->kwargs(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwargsDistinct(...$arguments) : array
    {
        return static::getInstance()->kwargsDistinct(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwargsFlatten(...$arguments) : array
    {
        return static::getInstance()->kwargsFlatten(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwargsFlattenDistinct(...$arguments) : array
    {
        return static::getInstance()->kwargsFlattenDistinct(...$arguments);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public static function kwparams(...$arguments) : array
    {
        return static::getInstance()->kwparams(...$arguments);
    }

    /**
     * @param int|float|int[]|float[] $sleeps
     *
     * @return _Php
     */
    public static function sleep($sleeps)
    {
        return static::getInstance()->sleep($sleeps);
    }


    /**
     * @return _Php
     */
    abstract public static function getInstance() : _Php;
}
