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
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\XUri;

class Uri
{
    /**
     * @param string    $regex
     * @param null|bool $absolute
     *
     * @return bool
     */
    public static function isUrlCurrent(string $regex, bool $absolute = null): bool
    {
        return static::getInstance()->isUrlCurrent($regex, $absolute);
    }

    /**
     * @param string $url
     * @param string $needle
     *
     * @return bool
     */
    public static function isUrlMatch(string $url, string $needle): bool
    {
        return static::getInstance()->isUrlMatch($url, $needle);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterLink($value): ?string
    {
        return static::getInstance()->filterLink($value);
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public static function filterUrl($value): ?string
    {
        return static::getInstance()->filterUrl($value);
    }

    /**
     * @param string|null       $url
     * @param bool|string|array $q
     * @param bool|string|null  $ref
     *
     * @return string
     */
    public static function link(string $url = null, $q = null, $ref = null): string
    {
        return static::getInstance()->link($url, $q, $ref);
    }

    /**
     * @param string|null       $url
     * @param bool|string|array $q
     * @param bool|string|null  $ref
     *
     * @return string
     */
    public static function url(string $url = null, $q = null, $ref = null): string
    {
        return static::getInstance()->url($url, $q, $ref);
    }

    /**
     * @param null|string $url
     *
     * @return array
     */
    public static function parseUrl(string $url = null): array
    {
        return static::getInstance()->parseUrl($url);
    }

    /**
     * @param string|array ...$queries
     *
     * @return array
     */
    public static function parseQuery(...$queries): array
    {
        return static::getInstance()->parseQuery(...$queries);
    }

    /**
     * @param array $parseUrlResult
     *
     * @return string
     */
    public static function buildLink(array $parseUrlResult): string
    {
        return static::getInstance()->buildLink($parseUrlResult);
    }

    /**
     * @param array $parseUrlResult
     *
     * @return string
     */
    public static function buildUrl(array $parseUrlResult): string
    {
        return static::getInstance()->buildUrl($parseUrlResult);
    }

    /**
     * @param array $parseQueryResult
     *
     * @return string
     */
    public static function buildQuery(array $parseQueryResult): ?string
    {
        return static::getInstance()->buildQuery($parseQueryResult);
    }

    /**
     * @return IUri
     */
    public static function getInstance(): IUri
    {
        return SupportFactory::getInstance()->getUri();
    }
}
