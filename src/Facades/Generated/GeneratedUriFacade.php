<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Uri;

abstract class GeneratedUriFacade
{
    /**
     * Compares links, allows to create `active` buttons if urls match
     *
     * @param null|string $link
     *
     * @param null|string $needle
     * @param null|array  $needleQuery
     * @param null|string $needleRef
     *
     * @param null|bool   $strictPath
     * @param null|bool   $strictQuery
     * @param null|bool   $strictRef
     *
     * @return bool
     */
    public static function isLinkMatch(
        string $link,
        string $needle = null,
        array $needleQuery = null,
        string $needleRef = null,
        bool $strictPath = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ): bool {
        return static::getInstance()->isLinkMatch($link, $needle, $needleQuery, $needleRef, $strictPath, $strictQuery, $strictRef);
    }

    /**
     * Compares urls, allows to create `active` buttons if urls match
     *
     * @param null|string $url
     *
     * @param null|string $needle
     * @param null|array  $needleQuery
     * @param null|string $needleRef
     *
     * @param null|bool   $strictPath
     * @param null|bool   $strictQuery
     * @param null|bool   $strictRef
     *
     * @return bool
     */
    public static function isUrlMatch(
        string $url,
        string $needle = null,
        array $needleQuery = null,
        string $needleRef = null,
        bool $strictPath = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ): bool {
        return static::getInstance()->isUrlMatch($url, $needle, $needleQuery, $needleRef, $strictPath, $strictQuery, $strictRef);
    }

    /**
     * @param mixed ...$batches
     *
     * @return array
     */
    public static function query(...$batches): array
    {
        return static::getInstance()->query(...$batches);
    }

    /**
     * @param string $uri
     *
     * @return array
     */
    public static function linkinfo(string $uri): array
    {
        return static::getInstance()->linkinfo($uri);
    }

    /**
     * @param string|null $link
     * @param null|array  $query
     * @param string|null $fragment
     *
     * @return string
     */
    public static function url(string $link = null, array $query = null, string $fragment = null): string
    {
        return static::getInstance()->url($link, $query, $fragment);
    }

    /**
     * @param string|null $link
     * @param null|array  $query
     * @param string|null $fragment
     *
     * @return string
     */
    public static function link(string $link = null, array $query = null, string $fragment = null): string
    {
        return static::getInstance()->link($link, $query, $fragment);
    }

    /**
     * @return Uri
     */
    abstract public static function getInstance(): Uri;
}
