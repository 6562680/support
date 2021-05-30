<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Curl;
use Gzhegow\Support\Domain\Curl\CurlBlueprint;
use Gzhegow\Support\Domain\Curl\CurlFormatter;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

abstract class GeneratedCurlFacade
{
    /**
     * @param array $curlOptArray
     *
     * @return CurlBlueprint
     */
    public static function newBlueprint(array $curlOptArray = []): CurlBlueprint
    {
        return static::getInstance()->newBlueprint($curlOptArray);
    }

    /**
     * @return CurlFormatter
     */
    public static function newFormatter(): CurlFormatter
    {
        return static::getInstance()->newFormatter();
    }

    /**
     * @param array $curlOptArray
     *
     * @return CurlBlueprint
     */
    public static function cloneBlueprint(array $curlOptArray = []): CurlBlueprint
    {
        return static::getInstance()->cloneBlueprint($curlOptArray);
    }

    /**
     * @param CurlBlueprint $blueprint
     *
     * @return Curl
     */
    public static function clone(CurlBlueprint $blueprint)
    {
        return static::getInstance()->clone($blueprint);
    }

    /**
     * @return CurlBlueprint
     */
    public static function getBlueprint(): CurlBlueprint
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
     * @param resource $ch
     *
     * @return boolean
     */
    public static function isCurl($ch): bool
    {
        return static::getInstance()->isCurl($ch);
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
     * @param resource $ch
     *
     * @return null|resource
     */
    public static function assertCurl($ch)
    {
        return static::getInstance()->assertCurl($ch);
    }

    /**
     * @param CurlBlueprint $blueprint
     *
     * @return Curl
     */
    public static function using(CurlBlueprint $blueprint)
    {
        return static::getInstance()->using($blueprint);
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
     * @param null|string|array          $message
     * @param mixed                      ...$arguments
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function curls($curls, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->curls($curls, $uniq, $message, ...$arguments);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|string|array          $message
     * @param mixed                      ...$arguments
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function theCurls($curls, $uniq = null, $message = null, ...$arguments): array
    {
        return static::getInstance()->theCurls($curls, $uniq, $message, ...$arguments);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function curlsSkip($curls, $uniq = null): array
    {
        return static::getInstance()->curlsSkip($curls, $uniq);
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     *
     * @return resource[]|\CurlHandle[]
     */
    public static function theCurlsSkip($curls, $uniq = null): array
    {
        return static::getInstance()->theCurlsSkip($curls, $uniq);
    }

    /**
     * @return Curl
     */
    abstract public static function getInstance(): Curl;
}