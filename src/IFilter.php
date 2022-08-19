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

use Gzhegow\Support\Domain\Debug\DebugMessage;
use Gzhegow\Support\Generated\GeneratedFilter;
use Gzhegow\Support\Traits\Load\DebugLoadTrait;

interface IFilter
{
    /**
     * @param null|string|array $text
     * @param array             ...$placeholders
     *
     * @return null|array
     */
    public function getMessageOr($text = null, ...$placeholders): ?array;

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public function getThrowableOr(\Throwable $throwable = null);

    /**
     * @param null|string|array|\Throwable $assert
     * @param mixed                        ...$placeholders
     *
     * @return XFilter
     */
    public function assert($assert, ...$placeholders);
}
