<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Net;

abstract class GeneratedNetFacade
{
    /**
     * @param string $ip
     *
     * @return bool
     */
    public static function isIp(string $ip): bool
    {
        return static::getInstance()->isIp($ip);
    }

    /**
     * @param string $mask
     * @param null   $subnet_ip
     * @param null   $cidr
     *
     * @return bool
     */
    public static function isMask(string $mask, &$subnet_ip = null, &$cidr = null): bool
    {
        return static::getInstance()->isMask($mask, $subnet_ip, $cidr);
    }

    /**
     * @param string $ip
     * @param string $mask
     *
     * @return bool
     */
    public static function isInSubnet(string $ip, string $mask): bool
    {
        return static::getInstance()->isInSubnet($ip, $mask);
    }

    /**
     * @param string $header
     *
     * @return null|string
     */
    public static function header(string $header): ?string
    {
        return static::getInstance()->header($header);
    }

    /**
     * @return array
     */
    public static function headers(): array
    {
        return static::getInstance()->headers();
    }

    /**
     * @return string
     */
    public static function ip(): string
    {
        return static::getInstance()->ip();
    }

    /**
     * @return null|string
     */
    public static function useragent(): ?string
    {
        return static::getInstance()->useragent();
    }

    /**
     * @return Net
     */
    abstract public static function getInstance(): Net;
}
