<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Net;

interface NetInterface
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
