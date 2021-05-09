<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Uri as _Uri;

class Uri
{
    /**
     * @return _Uri
     */
    public static function getInstance() : _Uri
    {
        return new _Uri(
            Arr::getInstance(),
            Filter::getInstance(),
            Php::getInstance(),
            Str::getInstance()
        );
    }


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
    public static function isLinkMatch(string $link,
        string $needle = null,
        array $needleQuery = null,
        string $needleRef = null,

        bool $strictPath = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ) : bool
    {
        return static::getInstance()->isLinkMatch($link,
            $needle,
            $needleQuery,
            $needleRef,

            $strictPath,
            $strictQuery,
            $strictRef
        );
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
    public static function isUrlMatch(string $url,
        string $needle = null,
        array $needleQuery = null,
        string $needleRef = null,

        bool $strictPath = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ) : bool
    {
        return static::getInstance()->isUrlMatch($url,
            $needle,
            $needleQuery,
            $needleRef,

            $strictPath,
            $strictQuery,
            $strictRef
        );
    }

    /**
     * @param string|null $query
     *
     * @return array
     */
    public static function query(string $query = null) : array
    {
        return static::getInstance()->query($query);
    }

    /**
     * @param string $url
     *
     * @return array
     */
    public static function linkinfo(string $url) : array
    {
        return static::getInstance()->linkinfo($url);
    }

    /**
     * @param string|null $url
     * @param array       $q
     * @param string|null $ref
     *
     * @return string
     */
    public static function url(string $url = null, array $q = [], string $ref = null) : string
    {
        return static::getInstance()->url($url, $q, $ref);
    }

    /**
     * @param string|null $url
     * @param array       $q
     * @param string|null $ref
     *
     * @return string
     */
    public static function link(string $url = null, array $q = [], string $ref = null) : string
    {
        return static::getInstance()->link($url, $q, $ref);
    }
}
