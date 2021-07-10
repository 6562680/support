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

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\IUri;
use Gzhegow\Support\ZUri;

class Uri
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
     * @param null|bool   $strict
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
        bool $strict = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ): bool {
        return static::getInstance()->isLinkMatch($link, $needle, $needleQuery, $needleRef, $strict, $strictQuery, $strictRef);
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
     * @param null|bool   $strict
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
        bool $strict = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ): bool {
        return static::getInstance()->isUrlMatch($url, $needle, $needleQuery, $needleRef, $strict, $strictQuery, $strictRef);
    }

    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public static function query(...$items): array
    {
        return static::getInstance()->query(...$items);
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
     * @return IUri
     */
    public static function getInstance()
    {
        return static::getInstance()->getInstance();
    }
}
