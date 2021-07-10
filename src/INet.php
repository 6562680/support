<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface INet
{
    /**
     * @param string $ip
     *
     * @return bool
     */
    public function isIp(string $ip): bool;

    /**
     * @param string $mask
     * @param null   $subnet_ip
     * @param null   $cidr
     *
     * @return bool
     */
    public function isMask(string $mask, &$subnet_ip = null, &$cidr = null): bool;

    /**
     * @param string $ip
     * @param string $mask
     *
     * @return bool
     */
    public function isInSubnet(string $ip, string $mask): bool;

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
