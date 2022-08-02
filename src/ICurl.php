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

use Gzhegow\Support\Domain\Curl\CurlBlueprint;
use Gzhegow\Support\Domain\Curl\CurloptManager;
use Gzhegow\Support\Domain\Curl\CurloptManagerInterface;

interface ICurl
{
    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return ZCurl
     */
    public function with(?CurlBlueprint $blueprint);

    /**
     * @param CurlBlueprint $blueprint
     *
     * @return ZCurl
     */
    public function withBlueprint(CurlBlueprint $blueprint);

    /**
     * @return ZCurl
     */
    public function reset();

    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return ZCurl
     */
    public function clone(?CurlBlueprint $blueprint);

    /**
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public function newBlueprint(array $curloptArray = null): CurlBlueprint;

    /**
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public function cloneBlueprint(array $curloptArray = null): CurlBlueprint;

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource
     */
    public function get(string $url, $data = null, array $headers = null);

    /**
     * @return CurlBlueprint
     */
    public function getBlueprint(): CurlBlueprint;

    /**
     * @param null|bool $verbose
     *
     * @return array
     */
    public function getCurloptArray(bool $verbose = null): array;

    /**
     * @return array
     */
    public function getCurloptArrayDefault(): array;

    /**
     * @param null|CurloptManagerInterface $curloptManager
     *
     * @return CurloptManagerInterface
     */
    public function curloptManager(CurloptManagerInterface $curloptManager = null): CurloptManagerInterface;

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function head(string $url, array $headers = null);

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function options(string $url, array $headers = null);

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function post(string $url, $data = null, array $headers = null);

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function patch(string $url, $data = null, array $headers = null);

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function put(string $url, $data = null, array $headers = null);

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function delete(string $url, array $headers = null);

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function purge(string $url, $data = null, array $headers = null);

    /**
     * @param string     $method
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function request(string $method, string $url, $data = null, array $headers = null);

    /**
     * @param resource $ch
     *
     * @return null|array
     */
    public function curlinfo($ch): ?array;

    /**
     * @param resource   $ch
     * @param int|string $curlopt
     *
     * @return null|mixed|array
     */
    public function curlinfoOpt($ch, $curlopt);

    /**
     * @param resource|\CurlHandle|array $curls
     *
     * @return string[]
     */
    public function execMulti($curls): array;

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public function aCurls($curls, bool $uniq = null, bool $recursive = null): array;

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public function theCurls($curls, bool $uniq = null, bool $recursive = null): array;
}
