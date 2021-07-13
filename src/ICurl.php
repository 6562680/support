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

use Gzhegow\Support\Domain\Curl\Blueprint;
use Gzhegow\Support\Domain\Curl\Manager;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface ICurl
{
    /**
     * @return ZCurl
     */
    public function reset();

    /**
     * @param null|Blueprint $blueprint
     *
     * @return ZCurl
     */
    public function clone(?Blueprint $blueprint);

    /**
     * @param null|Blueprint $blueprint
     *
     * @return ZCurl
     */
    public function with(?Blueprint $blueprint);

    /**
     * @param Blueprint $blueprint
     *
     * @return ZCurl
     */
    public function withBlueprint(Blueprint $blueprint);

    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    public function newBlueprint(array $curlOptArray = []): Blueprint;

    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    public function cloneBlueprint(array $curlOptArray = []): Blueprint;

    /**
     * @return Blueprint
     */
    public function getBlueprint(): Blueprint;

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function get(string $url, $data = null, array $headers = []);

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function head(string $url, array $headers = []);

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function options(string $url, array $headers = []);

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function post(string $url, $data = null, array $headers = []);

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function patch(string $url, $data = null, array $headers = []);

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function put(string $url, $data = null, array $headers = []);

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function delete(string $url, array $headers = []);

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function purge(string $url, $data = null, array $headers = []);

    /**
     * @param string $method
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function request(string $method, string $url, $data = null, array $headers = []);

    /**
     * @return Manager
     */
    public function formatter(): Manager;

    /**
     * @param resource $ch
     *
     * @return null|array
     */
    public function curlInfo($ch): ?array;

    /**
     * @param resource   $ch
     * @param int|string $opt
     *
     * @return null|mixed|array
     */
    public function curlInfoOpt($ch, $opt);

    /**
     * @param resource   $curl
     * @param int|string $opt
     *
     * @return null|string|string[]
     */
    public function info($curl, $opt = null);

    /**
     * @param int|string|array           $limits
     * @param int|float|string|array     $sleeps
     * @param resource|\CurlHandle|array $curls
     *
     * @return array
     */
    public function batch($limits, $sleeps, $curls): array;

    /**
     * @param int|string|array           $limits
     * @param int|float|string|array     $sleeps
     * @param resource|\CurlHandle|array $curls
     *
     * @return \Generator
     */
    public function batchwalk($limits, $sleeps, $curls): \Generator;

    /**
     * @param resource|\CurlHandle|array $curls
     *
     * @return array
     */
    public function multi($curls): array;

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public function curls($curls, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public function theCurls($curls, bool $uniq = null, bool $recursive = null): array;
}
