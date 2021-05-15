<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Loader as _Loader;

abstract class Loader
{
    /**
     * @return array
     */
    public static function loadClassMap() : array
    {
        return static::getInstance()->loadClassMap();
    }

    /**
     * @param string|object $classOrObject
     *
     * @return array
     */
    public static function split($classOrObject) : array
    {
        return static::getInstance()->split($classOrObject);
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public static function nsclass($classOrObject) : array
    {
        return static::getInstance()->nsclass($classOrObject);
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string
     */
    public static function class($classOrObject) : string
    {
        return static::getInstance()->class($classOrObject);
    }

    /**
     * @param string|object $classOrObject
     *
     * @return null|string
     */
    public static function namespace($classOrObject) : ?string
    {
        return static::getInstance()->namespace($classOrObject);
    }

    /**
     * @param mixed       $classOrObject
     * @param string|null $base
     *
     * @return string
     */
    public static function baseclass($classOrObject, string $base = null) : ?string
    {
        return static::getInstance()->baseclass($classOrObject, $base);
    }

    /**
     * @param callable $filter
     * @param null|int $limit
     * @param int      $offset
     *
     * @return array
     */
    public static function search(callable $filter, int $limit = null, int $offset = 0) : array
    {
        return static::getInstance()->search($filter, $limit, $offset);
    }


    /**
     * @return _Loader
     */
    abstract public static function getInstance() : _Loader;
}
