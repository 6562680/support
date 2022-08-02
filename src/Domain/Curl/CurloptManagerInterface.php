<?php

namespace Gzhegow\Support\Domain\Curl;


/**
 * CurlBlueprint
 */
interface CurloptManagerInterface
{
    /**
     * @param array ...$curloptArrays
     *
     * @return array
     */
    public function mergeCurloptArrays(array ...$curloptArrays) : array;

    /**
     * @param array $curloptArray
     *
     * @return array
     */
    public function formatCurloptArray(array $curloptArray) : array;


    /**
     * @param int|string $curlinfoCode
     *
     * @return null|int
     */
    public function curlinfoCodeVal($curlinfoCode) : ?int;

    /**
     * @param int|string $curloptCode
     *
     * @return null|int
     */
    public function curloptCodeVal($curloptCode) : ?int;

    /**
     * @param int|string $curlinfoCode
     *
     * @return null|int
     */
    public function theCurlinfoCodeVal($curlinfoCode) : int;

    /**
     * @param int|string $curloptCode
     *
     * @return null|int
     */
    public function theCurloptCodeVal($curloptCode) : int;
}