<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Profiler;

abstract class GeneratedProfilerFacade
{
    /**
     * @param null|string $comment
     *
     * @return float
     */
    public static function tick(string $comment = null): float
    {
        return static::getInstance()->tick($comment);
    }

    /**
     * @param null|int $decimals
     *
     * @return array
     */
    public static function report(int $decimals = null): array
    {
        return static::getInstance()->report($decimals);
    }

    /**
     * @return Profiler
     */
    public static function flush()
    {
        return static::getInstance()->flush();
    }

    /**
     * @return Profiler
     */
    abstract public static function getInstance(): Profiler;
}
