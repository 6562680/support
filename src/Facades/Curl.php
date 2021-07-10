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

use Gzhegow\Support\Domain\Curl\Blueprint;
use Gzhegow\Support\Domain\Curl\Manager;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\ICurl;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\ZCurl;

class Curl
{
    /**
     * @return ZCurl
     */
    public static function reset()
    {
        return static::getInstance()->reset();
    }

    /**
     * @param null|Blueprint $blueprint
     *
     * @return ZCurl
     */
    public static function clone(?Blueprint $blueprint)
    {
        return static::getInstance()->clone($blueprint);
    }

    /**
     * @param null|Blueprint $blueprint
     *
     * @return ZCurl
     */
    public static function with(?Blueprint $blueprint)
    {
        return static::getInstance()->with($blueprint);
    }

    /**
     * @param Blueprint $blueprint
     *
     * @return ZCurl
     */
    public static function withBlueprint(Blueprint $blueprint)
    {
        return static::getInstance()->withBlueprint($blueprint);
    }

    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    public static function newBlueprint(array $curlOptArray = []): Blueprint
    {
        return static::getInstance()->newBlueprint($curlOptArray);
    }

    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    public static function cloneBlueprint(array $curlOptArray = []): Blueprint
    {
        return static::getInstance()->cloneBlueprint($curlOptArray);
    }

    /**
     * @return Blueprint
     */
    public static function getBlueprint(): Blueprint
    {
        return static::getInstance()->getBlueprint();
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public static function get(string $url, $data = null, array $headers = [])
    {
        return static::getInstance()->get($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public static function head(string $url, array $headers = [])
    {
        return static::getInstance()->head($url, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public static function options(string $url, array $headers = [])
    {
        return static::getInstance()->options($url, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public static function post(string $url, $data = null, array $headers = [])
    {
        return static::getInstance()->post($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public static function patch(string $url, $data = null, array $headers = [])
    {
        return static::getInstance()->patch($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public static function put(string $url, $data = null, array $headers = [])
    {
        return static::getInstance()->put($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public static function delete(string $url, array $headers = [])
    {
        return static::getInstance()->delete($url, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public static function purge(string $url, $data = null, array $headers = [])
    {
        return static::getInstance()->purge($url, $data, $headers);
    }

    /**
     * @param string $method
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public static function request(string $method, string $url, $data = null, array $headers = [])
    {
        return static::getInstance()->request($method, $url, $data, $headers);
    }

    /**
     * @return Manager
     */
    public static function formatter(): Manager
    {
        return static::getInstance()->formatter();
    }

    /**
     * @param resource $ch
     *
     * @return null|array
     */
    public static function curlInfo($ch): ?array
    {
        return static::getInstance()->curlInfo($ch);
    }

    /**
     * @param resource   $ch
     * @param int|string $opt
     *
     * @return null|mixed|array
     */
    public static function curlInfoOpt($ch, $opt)
    {
        return static::getInstance()->curlInfoOpt($ch, $opt);
    }

    /**
     * @param resource   $curl
     * @param int|string $opt
     *
     * @return null|string|string[]
     */
    public static function info($curl, $opt = null)
    {
        return static::getInstance()->info($curl, $opt);
    }

    /**
     * @param int|string|array           $limits
     * @param int|float|string|array     $sleeps
     * @param resource|\CurlHandle|array $curls
     *
     * @return array
     */
    public static function batch($limits, $sleeps, $curls): array
    {
        return static::getInstance()->batch($limits, $sleeps, $curls);
    }

    /**
     * @param int|string|array           $limits
     * @param int|float|string|array     $sleeps
     * @param resource|\CurlHandle|array $curls
     *
     * @return \Generator
     */
    public static function batchwalk($limits, $sleeps, $curls): \Generator
    {
        yield from static::getInstance()->batchwalk($limits, $sleeps, $curls);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     *
     * @return array
     */
    public static function multi($curls): array
    {
        return static::getInstance()->multi($curls);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function curls($curls, $uniq = null): array
    {
        return static::getInstance()->curls($curls, $uniq);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function theCurls($curls, $uniq = null): array
    {
        return static::getInstance()->theCurls($curls, $uniq);
    }

    /**
     * @return ICurl
     */
    public static function getInstance(): ICurl
    {
        return SupportFactory::getInstance()->getCurl();
    }
}
