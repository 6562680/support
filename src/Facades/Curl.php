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

use Gzhegow\Support\Domain\Curl\CurlBlueprint;
use Gzhegow\Support\Domain\Curl\CurloptManager;
use Gzhegow\Support\Domain\Curl\CurloptManagerInterface;
use Gzhegow\Support\ICurl;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZCurl;

class Curl
{
    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return ZCurl
     */
    public static function with(?CurlBlueprint $blueprint)
    {
        return static::getInstance()->with($blueprint);
    }

    /**
     * @param CurlBlueprint $blueprint
     *
     * @return ZCurl
     */
    public static function withBlueprint(CurlBlueprint $blueprint)
    {
        return static::getInstance()->withBlueprint($blueprint);
    }

    /**
     * @return ZCurl
     */
    public static function reset()
    {
        return static::getInstance()->reset();
    }

    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return ZCurl
     */
    public static function clone(?CurlBlueprint $blueprint)
    {
        return static::getInstance()->clone($blueprint);
    }

    /**
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public static function newBlueprint(array $curloptArray = null): CurlBlueprint
    {
        return static::getInstance()->newBlueprint($curloptArray);
    }

    /**
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public static function cloneBlueprint(array $curloptArray = null): CurlBlueprint
    {
        return static::getInstance()->cloneBlueprint($curloptArray);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource
     */
    public static function get(string $url, $data = null, array $headers = null)
    {
        return static::getInstance()->get($url, $data, $headers);
    }

    /**
     * @return CurlBlueprint
     */
    public static function getBlueprint(): CurlBlueprint
    {
        return static::getInstance()->getBlueprint();
    }

    /**
     * @param null|bool $verbose
     *
     * @return array
     */
    public static function getCurloptArray(bool $verbose = null): array
    {
        return static::getInstance()->getCurloptArray($verbose);
    }

    /**
     * @return array
     */
    public static function getCurloptArrayDefault(): array
    {
        return static::getInstance()->getCurloptArrayDefault();
    }

    /**
     * @param null|CurloptManagerInterface $curloptManager
     *
     * @return CurloptManagerInterface
     */
    public static function curloptManager(CurloptManagerInterface $curloptManager = null): CurloptManagerInterface
    {
        return static::getInstance()->curloptManager($curloptManager);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public static function head(string $url, array $headers = null)
    {
        return static::getInstance()->head($url, $headers);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public static function options(string $url, array $headers = null)
    {
        return static::getInstance()->options($url, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public static function post(string $url, $data = null, array $headers = null)
    {
        return static::getInstance()->post($url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public static function patch(string $url, $data = null, array $headers = null)
    {
        return static::getInstance()->patch($url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public static function put(string $url, $data = null, array $headers = null)
    {
        return static::getInstance()->put($url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public static function delete(string $url, array $headers = null)
    {
        return static::getInstance()->delete($url, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public static function purge(string $url, $data = null, array $headers = null)
    {
        return static::getInstance()->purge($url, $data, $headers);
    }

    /**
     * @param string     $method
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public static function request(string $method, string $url, $data = null, array $headers = null)
    {
        return static::getInstance()->request($method, $url, $data, $headers);
    }

    /**
     * @param resource $ch
     *
     * @return null|array
     */
    public static function curlinfo($ch): ?array
    {
        return static::getInstance()->curlinfo($ch);
    }

    /**
     * @param resource   $ch
     * @param int|string $curlopt
     *
     * @return null|mixed|array
     */
    public static function curlinfoOpt($ch, $curlopt)
    {
        return static::getInstance()->curlinfoOpt($ch, $curlopt);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     *
     * @return string[]
     */
    public static function execMulti($curls): array
    {
        return static::getInstance()->execMulti($curls);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function aCurls($curls, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->aCurls($curls, $uniq, $recursive);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function theCurls($curls, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->theCurls($curls, $uniq, $recursive);
    }

    /**
     * @return ICurl
     */
    public static function getInstance(): ICurl
    {
        return SupportFactory::getInstance()->getCurl();
    }
}
