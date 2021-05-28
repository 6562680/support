<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Curl\Blueprint;
use Gzhegow\Support\Domain\Curl\Formatter;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Curl
 */
class Curl
{
    /**
     * @var Arr
     */
    protected $arr;
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Php
     */
    protected $php;


    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @var Blueprint
     */
    protected $blueprintRoot;


    /**
     * Constructor
     *
     * @param Arr    $arr
     * @param Php    $php
     * @param Filter $filter
     */
    public function __construct(
        Arr $arr,
        Filter $filter,
        Php $php
    )
    {
        $this->arr = $arr;
        $this->filter = $filter;
        $this->php = $php;

        $this->formatter = $this->newFormatter();

        $this->blueprintRoot = $this->newBlueprint([
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);
    }


    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    protected function newBlueprint(array $curlOptArray = []) : Blueprint
    {
        return new Blueprint(
            $this->arr,
            $this->filter,

            $this->formatter,

            $curlOptArray
        );
    }

    /**
     * @return Formatter
     */
    protected function newFormatter() : Formatter
    {
        return new Formatter(
            $this->filter,
            $this->php,
        );
    }


    /**
     * @param bool $verbose
     *
     * @return array
     */
    public function getOptArray(bool $verbose = false) : array
    {
        return $this->blueprintRoot->getOptArray($verbose);
    }


    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function get(string $url, $data = null, array $headers = [])
    {
        return $this->blueprintRoot->get($url, $data, $headers);
    }


    /**
     * @param resource $ch
     *
     * @return boolean
     */
    public function isCurl($ch) : bool
    {
        return null !== $this->filterCurl($ch);
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurl($ch) // : ?resource|\CurlHandle
    {
        if (is_object($ch) && class_exists('CurlHandle') && is_a($ch, 'CurlHandle')) {
            return $ch;

        } elseif (null !== $this->filter->filterOpenedResource($ch)) {
            if (false === @curl_error($ch)) {
                return null;
            }

            return $ch;
        }

        return null;
    }

    /**
     * @param resource $ch
     *
     * @return null|resource
     */
    public function assertCurl($ch) // : ?resource
    {
        if (null === $this->filterCurl($ch)) {
            throw new InvalidArgumentException(
                [ 'Ch should be cURL Resource: %s', $ch ]
            );
        }

        return $ch;
    }


    /**
     * @param string $opt
     * @param mixed  $value
     *
     * @return static
     */
    public function setOpt(string $opt, $value)
    {
        $this->blueprintRoot->setOpt($opt, $value);

        return $this;
    }

    /**
     * @param array $opts
     *
     * @return static
     */
    public function setOptArray(array $opts)
    {
        $this->blueprintRoot->setOptArray($opts);

        return $this;
    }


    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource
     */
    public function head(string $url, array $headers = [])
    {
        return $this->blueprintRoot->head($url, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource
     */
    public function options(string $url, array $headers = [])
    {
        return $this->blueprintRoot->options($url, $headers);
    }


    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function post(string $url, $data = null, array $headers = [])
    {
        return $this->blueprintRoot->post($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function patch(string $url, $data = null, array $headers = [])
    {
        return $this->blueprintRoot->patch($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function put(string $url, $data = null, array $headers = [])
    {
        return $this->blueprintRoot->put($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource
     */
    public function delete(string $url, array $headers = [])
    {
        return $this->blueprintRoot->delete($url, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function purge(string $url, $data = null, array $headers = [])
    {
        return $this->blueprintRoot->purge($url, $data, $headers);
    }


    /**
     * @param string $method
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function request(string $method, string $url, $data = null, array $headers = [])
    {
        return $this->blueprintRoot->request($method, $url, $data, $headers);
    }


    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    public function blueprint(array $curlOptArray = []) : Blueprint
    {
        $clone = clone $this->blueprintRoot;

        $clone->setOptArray($curlOptArray);

        return $clone;
    }


    /**
     * @param resource $ch
     *
     * @return null|int[]|string[]
     */
    public function curlInfo($ch) : ?array
    {
        if (! $this->isCurl($ch)) {
            return null;
        }

        $result = curl_getinfo($ch);

        return $result ?: null;
    }

    /**
     * @param resource   $ch
     * @param int|string $opt
     *
     * @return null|int|string|int[]|string[]
     */
    public function curlInfoOpt($ch, $opt)
    {
        if (! $this->isCurl($ch)) {
            return null;
        }

        $result = ( null !== $this->formatter->detectInfoCode($opt) )
            ? curl_getinfo($ch, $opt)
            : curl_getinfo($ch)[ $opt ];

        return $result ?: null;
    }


    /**
     * @return static
     */
    public function clearOptArray()
    {
        $this->blueprintRoot->clearOptArray();

        return $this;
    }

    /**
     * @return static
     */
    public function resetOptArray()
    {
        $this->blueprintRoot->resetOptArray();

        return $this;
    }


    /**
     * @param resource   $curl
     * @param int|string $opt
     *
     * @return null|string|string[]
     */
    public function info($curl, $opt = null)
    {
        $result = $opt
            ? $this->curlInfoOpt($curl, $opt)
            : $this->curlInfo($curl);

        return $result;
    }


    /**
     * @param int|int[]|string|string[]               $limit
     * @param int|float|int[]|float[]|string|string[] $sleep
     * @param resource|resource[]|array               $curls
     *
     * @return array
     */
    public function batch($limit, $sleep, ...$curls) : array
    {
        $results = [];
        $urls = [];
        $hh = [];

        foreach ( $this->batchwalk($limit, $sleep, ...$curls) as $result ) {
            [ $resultsCurrent, $urlsCurrent, $hhCurrent ] = $result;

            $results += $resultsCurrent;
            $urls += $urlsCurrent;
            $hh += $hhCurrent;
        }

        return [ $results, $urls, $hh ];
    }

    /**
     * @param int|int[]                 $limits
     * @param int|float|int[]|float[]   $sleeps
     * @param resource|resource[]|array $curls
     *
     * @return \Generator
     */
    public function batchwalk($limits, $sleeps, ...$curls) : \Generator
    {
        $limits = is_array($limits)
            ? $limits
            : [ $limits ];

        foreach ( $limits as $limit ) {
            if (null === $this->php->intval($limit)) {
                throw new InvalidArgumentException(
                    [ 'Each limit should be intable: %s', $limit ]
                );
            }
        }

        [ 1 => $curls ] = $this->php->kwargsFlattenDistinct(...$curls);

        foreach ( $curls as $ch ) {
            if (! $this->isCurl($ch)) {
                throw new InvalidArgumentException(
                    [ 'Each argument should be opened CURL resource: %s', $ch ]
                );
            }
        }

        $limitMin = max(1, min($limits));
        $limitMax = max(1, max($limits));

        do {
            $limitCurrent = rand($limitMin, $limitMax);

            $i = 0;
            $curlsCurrent = [];
            while ( null !== ( $key = key($curls) ) ) {
                $curlsCurrent[ $key ] = $curls[ $key ];

                unset($curls[ $key ]);

                if (++$i === $limitCurrent) {
                    break;
                }
            }

            [ $responsesCurrent, $urlsCurrent, $hhCurrent ] = $this->multi($curlsCurrent);

            yield [ $responsesCurrent, $urlsCurrent, $hhCurrent ];

            if ($curls) {
                $this->php->sleep($sleeps);
            }
        } while ( $curls );
    }


    /**
     * @param resource|resource[]|array $curls
     *
     * @return array
     */
    public function multi(...$curls) : array
    {
        [ 1 => $curls ] = $this->php->kwargsFlattenDistinct(...$curls);

        foreach ( $curls as $ch ) {
            if (! $this->isCurl($ch)) {
                throw new InvalidArgumentException('Each argument should be opened CURL resource');
            }
        }

        $master = curl_multi_init();

        $hh = [];
        $urls = [];
        foreach ( $curls as $index => $ch ) {
            $hh[ $index ] = $ch;
            $urls[ $index ] = $this->info($ch, CURLINFO_EFFECTIVE_URL);

            // add handler to multi
            curl_multi_add_handle($master, $ch);
        }

        // start requests
        do {
            $mrc = curl_multi_exec($master, $running);

            if ($running) {
                curl_multi_select($master);
            }
        } while ( $running && $mrc == CURLM_OK );

        // parse responses
        $results = [];
        foreach ( $hh as $index => $ch ) {
            $results[ $index ] = curl_multi_getcontent($ch);

            curl_multi_remove_handle($master, $ch);
        }

        // close loop
        curl_multi_close($master);

        // result
        return [ $results, $urls, $hh ];
    }


    /**
     * @param resource|resource[]|array $chh
     * @param null|bool                 $uniq
     *
     * @return string[]
     */
    public function curls($chh, bool $uniq = null) : array
    {
        $result = [];

        $chh = is_array($chh)
            ? $chh
            : [ $chh ];

        array_walk_recursive($chh, function ($string) use (&$result) {
            if (null === $this->filterCurl($string)) {
                throw new InvalidArgumentException(
                    [ 'Each item should be stringable: %s', $string ],
                );
            }

            $result[] = strval($string);
        });

        if ($uniq ?? false) {
            $result = array_values(array_unique($result));
        }

        return $result;
    }

    /**
     * @param string|string[]|array $chh
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function theCurls($chh, bool $uniq = null) : array
    {
        $result = $this->curls($chh, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one string should be provided: %s', $chh ],
            );
        }

        return $result;
    }

    /**
     * @param string|string[]|array $chh
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function curlsskip($chh, bool $uniq = null) : array
    {
        $result = [];

        $chh = is_array($chh)
            ? $chh
            : [ $chh ];

        array_walk_recursive($chh, function ($string) use (&$result) {
            if (null !== $this->filterCurl($string)) {
                $result[] = strval($string);
            }
        });

        if ($uniq ?? false) {
            $result = array_values(array_unique($result));
        }

        return $result;
    }

    /**
     * @param string|string[]|array $chh
     * @param null|bool             $uniq
     *
     * @return string[]
     */
    public function theCurlsskip($chh, bool $uniq = null) : array
    {
        $result = $this->curlsskip($chh, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one string should be provided: %s', $chh ],
            );
        }

        return $result;
    }
}
