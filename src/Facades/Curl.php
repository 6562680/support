<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Curl as _Curl;
use Gzhegow\Support\Domain\Curl\Blueprint;

class Curl
{
    /**
     * @return _Curl
     */
    public static function getInstance() : _Curl
    {
        return new _Curl(
            Arr::getInstance(),
            Filter::getInstance(),
            Php::getInstance(),
            Type::getInstance()
        );
    }


    /**
     * @param bool $verbose
     *
     * @return array
     */
    public static function getOptArray(bool $verbose = false) : array
    {
        return static::getInstance()->getOptArray($verbose);
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
     * @param mixed $ch
     *
     * @return boolean
     */
    public static function isCurl($ch) : bool
    {
        return static::getInstance()->isCurl($ch);
    }

    /**
     * @param mixed $ch
     *
     * @return boolean
     */
    public static function isOpenedCurl($ch) : bool
    {
        return static::getInstance()->isOpenedCurl($ch);
    }

    /**
     * @param mixed $ch
     *
     * @return boolean
     */
    public static function isClosedCurl($ch) : bool
    {
        return static::getInstance()->isClosedCurl($ch);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource
     */
    public static function head(string $url, array $headers = [])
    {
        return static::getInstance()->head($url, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource
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
     * @return resource
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
     * @return resource
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
     * @return resource
     */
    public static function put(string $url, $data = null, array $headers = [])
    {
        return static::getInstance()->put($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource
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
     * @return resource
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
     * @return resource
     */
    public static function request(string $method, string $url, $data = null, array $headers = [])
    {
        return static::getInstance()->request($method, $url, $data, $headers);
    }

    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    public static function blueprint(array $curlOptArray = []) : Blueprint
    {
        return static::getInstance()->blueprint($curlOptArray);
    }

    /**
     * @param resource $ch
     *
     * @return null|mixed[]|mixed[][]
     */
    public static function curlInfo($ch) : ?array
    {
        return static::getInstance()->curlInfo($ch);
    }

    /**
     * @param resource   $ch
     * @param int|string $opt
     *
     * @return null|mixed|mixed[]
     */
    public static function curlInfoOpt($ch, $opt)
    {
        return static::getInstance()->curlInfoOpt($ch, $opt);
    }

    /**
     * @param       $opt
     * @param mixed $value
     *
     * @return _Curl
     */
    public static function setOpt(string $opt, $value)
    {
        return static::getInstance()->setOpt($opt, $value);
    }

    /**
     * @param array $opts
     *
     * @return _Curl
     */
    public static function setOptArray(array $opts)
    {
        return static::getInstance()->setOptArray($opts);
    }

    /**
     * @return _Curl
     */
    public static function clearOptArray()
    {
        return static::getInstance()->clearOptArray();
    }

    /**
     * @return _Curl
     */
    public static function resetOptArray()
    {
        return static::getInstance()->resetOptArray();
    }

    /**
     * @param mixed $curl
     * @param mixed $opt
     *
     * @return null|string|string[]
     */
    public static function info($curl, $opt = null)
    {
        return static::getInstance()->info($curl, $opt);
    }

    /**
     * @param mixed               $limit
     * @param mixed               $sleep
     * @param resource|resource[] $curls
     *
     * @return array
     */
    public static function batch($limit, $sleep, ...$curls) : array
    {
        return static::getInstance()->batch($limit, $sleep, ...$curls);
    }

    /**
     * @param mixed               $limit
     * @param mixed               $sleep
     * @param resource|resource[] $curls
     *
     * @return \Generator
     */
    public static function batchwalk($limit, $sleep, ...$curls) : \Generator
    {
        yield static::getInstance()->batchwalk($limit, $sleep, ...$curls);
    }

    /**
     * @param resource|resource[] $curls
     *
     * @return array
     */
    public static function multi(...$curls) : array
    {
        return static::getInstance()->multi(...$curls);
    }
}