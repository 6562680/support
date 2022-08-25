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
use Gzhegow\Support\XFormat;

class Format
{
    /**
     * Форматирует размер в байтах в читаемый формат
     *
     * @param int $bytesize
     *
     * @return string
     */
    public static function byteText(int $bytesize): string
    {
        return static::getInstance()->byteText($bytesize);
    }

    /**
     * Форматирует читаемый формат в размер в байтах
     *
     * @param string $bytetext
     *
     * @return int|float
     */
    public static function byteSize(string $bytetext)
    {
        return static::getInstance()->byteSize($bytetext);
    }

    /**
     * Вычищает из JSON комментарии и лишние пустые строки
     *
     * @param string $json
     *
     * @return string
     */
    public static function jsonClear(string $json): string
    {
        return static::getInstance()->jsonClear($json);
    }

    /**
     * Экранирует специальные символы SQL
     *
     * @param string      $value
     * @param null|string $escape
     *
     * @return string
     */
    public static function sqlEscape(string $value, string $escape = null): string
    {
        return static::getInstance()->sqlEscape($value, $escape);
    }

    /**
     * @return IFormat
     */
    public static function getInstance(): IFormat
    {
        return SupportFactory::getInstance()->getFormat();
    }
}
