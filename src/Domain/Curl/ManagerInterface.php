<?php

namespace Gzhegow\Support\Domain\Curl;


/**
 * ManagerInterface
 */
interface ManagerInterface
{
    /**
     * @param array ...$curlOptArrays
     *
     * @return array
     */
    public function mergeOptions(array ...$curlOptArrays) : array;


    /**
     * @param int|string $curlInfoCode
     *
     * @return null|int
     */
    public function curlInfoCodeVal($curlInfoCode) : ?int;

    /**
     * @param int|string $curlOptCode
     *
     * @return null|int
     */
    public function curlOptCodeVal($curlOptCode) : ?int;


    /**
     * @param int|string $curlInfoCode
     *
     * @return int
     */
    public function theCurlInfoCodeVal($curlInfoCode) : int;

    /**
     * @param int|string $curlOptCode
     *
     * @return int
     */
    public function theCurlOptCodeVal($curlOptCode) : int;


    /**
     * @param array $curlOptArray
     *
     * @return array
     */
    public function formatOptions(array $curlOptArray) : array;
}
