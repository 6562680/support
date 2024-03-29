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
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\ICurl;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\Curl\CurloptManagerLoadTrait;
use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\XCurl;

class Curl
{
    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return XCurl
     */
    public static function withBlueprint(?CurlBlueprint $blueprint)
    {
        return static::getInstance()->withBlueprint($blueprint);
    }

    /**
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public static function newCurlBlueprint(array $curloptArray = null): CurlBlueprint
    {
        return static::getInstance()->newCurlBlueprint($curloptArray);
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
    public static function getCurlBlueprint(): CurlBlueprint
    {
        return static::getInstance()->getCurlBlueprint();
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public static function filterCurl($ch)
    {
        return static::getInstance()->filterCurl($ch);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public static function filterCurlFresh($ch)
    {
        return static::getInstance()->filterCurlFresh($ch);
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
     * @param resource|\CurlHandle       $retryCurl
     *
     * @return \Generator<array<int,resource|\CurlHandle>>
     */
    public static function walkMulti($curls, &$retryCurl): \Generator
    {
        yield from static::getInstance()->walkMulti($curls, $retryCurl);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function curls($curls, bool $uniq = null, bool $recursive = null): array
    {
        return static::getInstance()->curls($curls, $uniq, $recursive);
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
