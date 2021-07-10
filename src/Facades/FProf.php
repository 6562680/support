<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\IProf;
use Gzhegow\Support\Prof;

class FProf
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
     * @return Prof
     */
    public static function flush()
    {
        return static::getInstance()->flush();
    }

    /**
     * @return IProf
     */
    public static function getInstance()
    {
        return static::getInstance()->getInstance();
    }
}
