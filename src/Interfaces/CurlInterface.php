<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\Curl;
use Gzhegow\Support\Domain\Curl\CurlBlueprint;
use Gzhegow\Support\Domain\Curl\CurlFormatter;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface CurlInterface
{
    /**
     * @return void
     */
    public function reset();

    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return Curl
     */
    public function clone(?CurlBlueprint $blueprint);

    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return Curl
     */
    public function with(?CurlBlueprint $blueprint);

    /**
     * @param CurlBlueprint $blueprint
     *
     * @return Curl
     */
    public function withBlueprint(CurlBlueprint $blueprint);

    /**
     * @param array $curlOptArray
     *
     * @return CurlBlueprint
     */
    public function newBlueprint(array $curlOptArray = []): CurlBlueprint;

    /**
     * @return CurlFormatter
     */
    public function newFormatter(): CurlFormatter;

    /**
     * @param array $curlOptArray
     *
     * @return CurlBlueprint
     */
    public function cloneBlueprint(array $curlOptArray = []): CurlBlueprint;

    /**
     * @return CurlBlueprint
     */
    public function getBlueprint(): CurlBlueprint;

    /**
     * @param resource $ch
     *
     * @return boolean
     */
    public function isCurl($ch): bool;

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     * @noinspection PhpStrictComparisonWithOperandsOfDifferentTypesInspection
     */
    public function filterCurl($ch);

    /**
     * @param resource $ch
     *
     * @return null|resource
     */
    public function assertCurl($ch);

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
     * @param null|string|array          $message
     * @param mixed                      ...$arguments
     *
     * @return resource[]|\CurlHandle[]
     */
    public function curls($curls, $uniq = null, $message = null, ...$arguments): array;

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|string|array          $message
     * @param mixed                      ...$arguments
     *
     * @return resource[]|\CurlHandle[]
     */
    public function theCurls($curls, $uniq = null, $message = null, ...$arguments): array;

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     *
     * @return resource[]|\CurlHandle[]
     */
    public function curlsSkip($curls, $uniq = null): array;

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     *
     * @return resource[]|\CurlHandle[]
     */
    public function theCurlsSkip($curls, $uniq = null): array;
}
