<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Bcmath as _Bcmath;

class Bcmath
{
    /**
     * @return _Bcmath
     */
    public static function getInstance() : _Bcmath
    {
        return new _Bcmath();
    }


    /**
     * @param string $n
     * @param int    $p
     *
     * @return null|string
     */
    public static function bcround(string $n, $p = 0)
    {
        return static::getInstance()->bcround($n, $p);
    }

    /**
     * @param string $n
     *
     * @return string
     */
    public static function bcceil(string $n)
    {
        return static::getInstance()->bcceil($n);
    }

    /**
     * @param string $n
     *
     * @return string
     */
    public static function bcfloor(string $n)
    {
        return static::getInstance()->bcfloor($n);
    }

    /**
     * @param string $n
     *
     * @return bool
     */
    public static function bcnegative(string $n)
    {
        return static::getInstance()->bcnegative($n);
    }

    /**
     * @param string $n
     *
     * @return bool
     */
    public static function bcabs(string $n)
    {
        return static::getInstance()->bcabs($n);
    }
}
