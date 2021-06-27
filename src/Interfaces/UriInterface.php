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
use Gzhegow\Support\Uri;

interface UriInterface
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
    public function isLinkMatch(
        string $link,
        string $needle = null,
        array $needleQuery = null,
        string $needleRef = null,
        bool $strictPath = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ): bool;

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
    public function isUrlMatch(
        string $url,
        string $needle = null,
        array $needleQuery = null,
        string $needleRef = null,
        bool $strictPath = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ): bool;

    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public function query(...$items): array;

    /**
     * @param string $uri
     *
     * @return array
     */
    public function linkinfo(string $uri): array;

    /**
     * @param string|null $link
     * @param null|array  $query
     * @param string|null $fragment
     *
     * @return string
     */
    public function url(string $link = null, array $query = null, string $fragment = null): string;

    /**
     * @param string|null $link
     * @param null|array  $query
     * @param string|null $fragment
     *
     * @return string
     */
    public function link(string $link = null, array $query = null, string $fragment = null): string;
}
