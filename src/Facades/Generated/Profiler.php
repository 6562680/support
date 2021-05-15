<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Profiler as _Profiler;

abstract class Profiler
{
    /**
     * @param null|string $comment
     *
     * @return float
     */
    public static function tick(string $comment = null) : float
    {
        return static::getInstance()->tick($comment);
    }

    /**
     * @param null|int $decimals
     *
     * @return array
     */
    public static function report(int $decimals = null) : array
    {
        return static::getInstance()->report($decimals);
    }

    /**
     * @return _Profiler
     */
    public static function flush()
    {
        return static::getInstance()->flush();
    }


    /**
     * @return _Profiler
     */
    abstract public static function getInstance() : _Profiler;
}
