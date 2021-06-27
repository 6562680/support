<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Profiler;

interface ProfilerInterface
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
     * @return Profiler
     */
    public function flush();
}
