<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Format;

abstract class GeneratedFormatFacade
{
    /**
     * конвертирует цифру размера в читабельный формат (1024 => 1Mb)
     *
     * @param int|float|string $size
     *
     * @return string
     */
    public static function fileSize($size): string
    {
        return static::getInstance()->fileSize($size);
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
     * @return Format
     */
    abstract public static function getInstance(): Format;
}
