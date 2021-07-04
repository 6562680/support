<?php

namespace Gzhegow\Support\Domain\Curl;


/**
 * CurlFormatter
 */
interface CurlFormatterInterface
{
    /**
     * @param array ...$curlOptArrays
     *
     * @return array
     */
    public function mergeOptions(array ...$curlOptArrays) : array;


    /**
     * @param string $method
     *
     * @return null|string
     */
    public function detectHttpMethod($method) : ?string;

    /**
     * @param int|string $info
     *
     * @return null|int
     */
    public function detectInfoCode($info) : ?int;

    /**
     * @param int|string $opt
     *
     * @return null|int
     */
    public function detectOptCode($opt) : ?int;


    /**
     * @param array $curlOptArray
     *
     * @return array
     */
    public function formatOptions(array $curlOptArray) : array;
}
