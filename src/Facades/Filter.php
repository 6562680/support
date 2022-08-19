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

use Gzhegow\Support\Domain\Debug\DebugMessage;
use Gzhegow\Support\Generated\GeneratedFilter;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\DebugLoadTrait;
use Gzhegow\Support\XFilter;

class Filter
{
    /**
     * @param null|string|array $text
     * @param array             ...$placeholders
     *
     * @return null|array
     */
    public static function getMessageOr($text = null, ...$placeholders): ?array
    {
        return static::getInstance()->getMessageOr($text, ...$placeholders);
    }

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    public static function getThrowableOr(\Throwable $throwable = null)
    {
        return static::getInstance()->getThrowableOr($throwable);
    }

    /**
     * @param null|string|array|\Throwable $assert
     * @param mixed                        ...$placeholders
     *
     * @return XFilter
     */
    public static function assert($assert, ...$placeholders)
    {
        return static::getInstance()->assert($assert, ...$placeholders);
    }

    /**
     * @return IFilter
     */
    public static function getInstance(): IFilter
    {
        return SupportFactory::getInstance()->getFilter();
    }
}
