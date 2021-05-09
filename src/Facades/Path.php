<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Path as _Path;

class Path
{
    /**
     * @return _Path
     */
    public static function getInstance() : _Path
    {
        return new _Path(
            Filter::getInstance(),
            Php::getInstance()
        );
    }


    /**
     * @param string $pathname
     * @param string $separator
     *
     * @return string
     */
    public static function optimize(string $pathname, string $separator = '/') : string
    {
        return static::getInstance()->optimize($pathname, $separator);
    }

    /**
     * @param string $pathname
     *
     * @return string
     */
    public static function normalize(string $pathname) : string
    {
        return static::getInstance()->normalize($pathname);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function realpath(string $path) : string
    {
        return static::getInstance()->realpath($path);
    }

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public static function basepath(string $path, string $base = null) : string
    {
        return static::getInstance()->basepath($path, $base);
    }

    /**
     * @param array $parts
     *
     * @return string
     */
    public static function join(...$parts) : string
    {
        return static::getInstance()->join(...$parts);
    }

    /**
     * @param array $parts
     *
     * @return string
     */
    public static function joinUnsafe(...$parts) : string
    {
        return static::getInstance()->joinUnsafe(...$parts);
    }
}
