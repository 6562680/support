<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Php as _Php;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

class Php
{
    /**
     * @return _Php
     */
    public static function getInstance() : _Php
    {
        return new _Php(
            Filter::getInstance(),
            Type::getInstance()
        );
    }


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
     * @param null $data
     *
     * @return array
     */
    public static function arrval($data = null) : array
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
     * @throws InvalidArgumentException
     */
    public static function kwparams(...$arguments) : array
    {
        return static::getInstance()->kwparams(...$arguments);
    }

    /**
     * @param string|object $item
     *
     * @return array
     */
    public static function splitclass($item) : array
    {
        return static::getInstance()->splitclass($item);
    }

    /**
     * @param mixed $item
     *
     * @return string[]
     */
    public static function nsclass($item) : array
    {
        return static::getInstance()->nsclass($item);
    }

    /**
     * @param mixed $item
     *
     * @return string
     */
    public static function class($item) : string
    {
        return static::getInstance()->class($item);
    }

    /**
     * @param             $item
     *
     * @return null|string
     */
    public static function namespace($item) : ?string
    {
        return static::getInstance()->namespace($item);
    }

    /**
     * @param mixed       $item
     * @param string|null $base
     *
     * @return string
     */
    public static function baseclass($item, string $base = null) : string
    {
        return static::getInstance()->baseclass($item, $base);
    }
}
