<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

interface IProf
{
    /**
     * @param null|string $comment
     *
     * @return float
     */
    public function tick(string $comment = null): float;

    /**
     * @param null|int $decimals
     *
     * @return array
     */
    public function report(int $decimals = null): array;

    /**
     * @return ZProf
     */
    public function flush();
}
