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

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\IProf;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZProf;

class Prof
{
    /**
     * @param null|string $comment
     *
     * @return float
     */
    public static function tick(?string $comment = ''): float
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
     * @return ZProf
     */
    public static function flush()
    {
        return static::getInstance()->flush();
    }

    /**
     * @return IProf
     */
    public static function getInstance(): IProf
    {
        return SupportFactory::getInstance()->getProf();
    }
}
