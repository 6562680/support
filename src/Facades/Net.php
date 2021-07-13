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
use Gzhegow\Support\INet;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZNet;

class Net
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
     * @param string $httpMethod
     *
     * @return null|string
     */
    public static function httpMethodVal($httpMethod): ?string
    {
        return static::getInstance()->httpMethodVal($httpMethod);
    }

    /**
     * @param string $httpMethod
     *
     * @return string
     */
    public static function theHttpMethodVal($httpMethod): string
    {
        return static::getInstance()->theHttpMethodVal($httpMethod);
    }

    /**
     * @param string|array $httpMethods
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function httpMethodVals($httpMethods, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->httpMethodVals($httpMethods, $uniq, $recursive);
    }

    /**
     * @param string|array $httpMethods
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public static function theHttpMethodVals($httpMethods, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theHttpMethodVals($httpMethods, $uniq, $recursive);
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
     * @return INet
     */
    public static function getInstance(): INet
    {
        return SupportFactory::getInstance()->getNet();
    }
}
