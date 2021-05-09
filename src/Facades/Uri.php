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
            Filter::getInstance(),
            Php::getInstance(),
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
