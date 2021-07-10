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

use Gzhegow\Support\IFormat;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZFormat;

class Format
{
    /**
     * конвертирует цифру размера в читабельный формат (1024 => 1Mb)
     *
     * @param int|float|string $filesize
     *
     * @return string
     */
    public static function niceSize($filesize): string
    {
        return static::getInstance()->niceSize($filesize);
    }

    /**
     * Формирует условие для SQL LIKE %val% запроса, экранируя проценты и подчеркивания
     *
     * @param string      $value
     * @param null|string $escape
     *
     * @return string
     */
    public static function sqlLike(string $value, string $escape = null): string
    {
        return static::getInstance()->sqlLike($value, $escape);
    }

    /**
     * @return IFormat
     */
    public static function getInstance(): IFormat
    {
        return SupportFactory::getInstance()->getFormat();
    }
}
