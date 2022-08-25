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

interface IFormat
{
    /**
     * Форматирует размер в байтах в читаемый формат
     *
     * @param int $bytesize
     *
     * @return string
     */
    public function byteText(int $bytesize): string;

    /**
     * Форматирует читаемый формат в размер в байтах
     *
     * @param string $bytetext
     *
     * @return int|float
     */
    public function byteSize(string $bytetext);

    /**
     * Вычищает из JSON комментарии и лишние пустые строки
     *
     * @param string $json
     *
     * @return string
     */
    public function jsonClear(string $json): string;

    /**
     * Экранирует специальные символы SQL
     *
     * @param string      $value
     * @param null|string $escape
     *
     * @return string
     */
    public function sqlEscape(string $value, string $escape = null): string;
}
