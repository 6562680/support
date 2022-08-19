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

use Gzhegow\Support\Exceptions\RuntimeException;

interface IProf
{
    /**
     * @param null|int $decimals
     *
     * @return array
     */
    public function report(int $decimals = null): array;

    /**
     * @return XProf
     */
    public function reset();

    /**
     * @param null|int $decimals
     *
     * @return array
     */
    public function flush(int $decimals = null): array;

    /**
     * @param null|string $comment
     *
     * @return float
     */
    public function tick(?string $comment = ''): float;
}
