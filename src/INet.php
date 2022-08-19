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
use Gzhegow\Support\Traits\Load\StrLoadTrait;

interface INet
{
    /**
     * @param string $ip
     * @param string $mask
     *
     * @return bool
     */
    public function isInSubnet(string $ip, string $mask): bool;

    /**
     * @param string $ip
     *
     * @return null|string
     */
    public function filterIp(string $ip): ?string;

    /**
     * @param string $mask
     *
     * @return null|array
     */
    public function filterMask(string $mask): ?array;

    /**
     * @param string $httpMethod
     *
     * @return null|string
     */
    public function httpMethodVal($httpMethod): ?string;

    /**
     * @param string $httpMethod
     *
     * @return string
     */
    public function theHttpMethodVal($httpMethod): string;

    /**
     * @param string|array $httpMethods
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function httpMethodVals($httpMethods, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string|array $httpMethods
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theHttpMethodVals($httpMethods, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param string $header
     *
     * @return null|string
     */
    public function header(string $header): ?string;

    /**
     * @return array
     */
    public function headers(): array;

    /**
     * @return string
     */
    public function ip(): string;

    /**
     * @return null|string
     */
    public function useragent(): ?string;
}
