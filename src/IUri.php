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

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;

interface IUri
{
    /**
     * @param string    $regex
     * @param null|bool $absolute
     *
     * @return bool
     */
    public function isUrlCurrent(string $regex, bool $absolute = null): bool;

    /**
     * @param string $url
     * @param string $needle
     *
     * @return bool
     */
    public function isUrlMatch(string $url, string $needle): bool;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLink($value): ?string;

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterUrl($value): ?string;

    /**
     * @param string|null       $url
     * @param bool|string|array $q
     * @param bool|string|null  $ref
     *
     * @return string
     */
    public function link(string $url = null, $q = null, $ref = null): string;

    /**
     * @param string|null       $url
     * @param bool|string|array $q
     * @param bool|string|null  $ref
     *
     * @return string
     */
    public function url(string $url = null, $q = null, $ref = null): string;

    /**
     * @param null|string $url
     *
     * @return array
     */
    public function parseUrl(string $url = null): array;

    /**
     * @param string|array ...$queries
     *
     * @return array
     */
    public function parseQuery(...$queries): array;

    /**
     * @param array $parseUrlResult
     *
     * @return string
     */
    public function buildLink(array $parseUrlResult): string;

    /**
     * @param array $parseUrlResult
     *
     * @return string
     */
    public function buildUrl(array $parseUrlResult): string;

    /**
     * @param array $parseQueryResult
     *
     * @return string
     */
    public function buildQuery(array $parseQueryResult): ?string;
}
