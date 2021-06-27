<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Format;

interface FormatInterface
{
    /**
     * конвертирует цифру размера в читабельный формат (1024 => 1Mb)
     *
     * @param int|float|string $size
     *
     * @return string
     */
    public function fileSize($size): string;

    /**
     * Формирует условие для SQL LIKE %val% запроса, экранируя проценты и подчеркивания
     *
     * @param string      $value
     * @param null|string $escape
     *
     * @return string
     */
    public function sqlLike(string $value, string $escape = null): string;
}
