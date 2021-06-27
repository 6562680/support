<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Interfaces\CurlInterface;
use Gzhegow\Support\Domain\Curl\CurlBlueprint;
use Gzhegow\Support\Domain\Curl\CurlFormatter;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Curl
 */
class Curl implements CurlInterface
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
     * @var CurlFormatter
     */
    protected $formatter;

    /**
     * @var CurlBlueprint
     */
    protected $blueprint;


    /**
     * Constructor
     *
     * @param Arr    $arr
     * @param Filter $filter
     * @param Php    $php
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

        $this->reset();
    }


    /**
     * @return void
     */
    public function reset()
    {
        $this->formatter = $this->newFormatter();
        $this->blueprint = $this->newBlueprint([
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);
    }


    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return static
     */
    public function clone(?CurlBlueprint $blueprint)
    {
        $instance = clone $this;

        if (isset($blueprint)) $instance->withBlueprint($blueprint);

        return $instance;
    }


    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return static
     */
    public function with(?CurlBlueprint $blueprint)
    {
        $this->reset();

        if (isset($blueprint)) $this->withBlueprint($blueprint);

        return $this;
    }


    /**
     * @param CurlBlueprint $blueprint
     *
     * @return static
     */
    public function withBlueprint(CurlBlueprint $blueprint)
    {
        $this->blueprint = $blueprint;

        return $this;
    }


    /**
     * @param array $curlOptArray
     *
     * @return CurlBlueprint
     */
    public function newBlueprint(array $curlOptArray = []) : CurlBlueprint
    {
        return new CurlBlueprint(
            $this->arr,
            $this->filter,

            $this->formatter,

            $curlOptArray
        );
    }

    /**
     * @return CurlFormatter
     */
    public function newFormatter() : CurlFormatter
    {
        return new CurlFormatter(
            $this->filter,
            $this->php,
        );
    }


    /**
     * @param array $curlOptArray
     *
     * @return CurlBlueprint
     */
    public function cloneBlueprint(array $curlOptArray = []) : CurlBlueprint
    {
        $clone = clone $this->blueprint;

        $clone->setOptArray($curlOptArray);

        return $clone;
    }


    /**
     * @return CurlBlueprint
     */
    public function getBlueprint() : CurlBlueprint
    {
        return $this->blueprint;
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
     * @noinspection PhpStrictComparisonWithOperandsOfDifferentTypesInspection
     */
    public function filterCurl($ch) // : ?resource|\CurlHandle
    {
        if (is_a($ch, 'CurlHandle')) {
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
                [ 'Ch should be cURL Handle: %s', $ch ]
            );
        }

        return $ch;
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
        return $this->blueprint->get($url, $data, $headers);
    }


    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function head(string $url, array $headers = [])
    {
        return $this->blueprint->head($url, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function options(string $url, array $headers = [])
    {
        return $this->blueprint->options($url, $headers);
    }


    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function post(string $url, $data = null, array $headers = [])
    {
        return $this->blueprint->post($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function patch(string $url, $data = null, array $headers = [])
    {
        return $this->blueprint->patch($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function put(string $url, $data = null, array $headers = [])
    {
        return $this->blueprint->put($url, $data, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function delete(string $url, array $headers = [])
    {
        return $this->blueprint->delete($url, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function purge(string $url, $data = null, array $headers = [])
    {
        return $this->blueprint->purge($url, $data, $headers);
    }


    /**
     * @param string $method
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function request(string $method, string $url, $data = null, array $headers = [])
    {
        return $this->blueprint->request($method, $url, $data, $headers);
    }


    /**
     * @param resource $ch
     *
     * @return null|array
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
     * @return null|mixed|array
     */
    public function curlInfoOpt($ch, $opt)
    {
        if (! $this->isCurl($ch)) {
            return null;
        }

        $result = ( null !== ( $infoCode = $this->formatter->detectInfoCode($opt) ) )
            ? curl_getinfo($ch, $infoCode)
            : curl_getinfo($ch)[ $infoCode ];

        return $result ?: null;
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
     * @param int|string|array           $limits
     * @param int|float|string|array     $sleeps
     * @param resource|\CurlHandle|array $curls
     *
     * @return array
     */
    public function batch($limits, $sleeps, $curls) : array
    {
        $results = [];
        $urls = [];
        $hh = [];

        foreach ( $this->batchwalk($limits, $sleeps, $curls) as $result ) {
            [ $resultsCurrent, $urlsCurrent, $hhCurrent ] = $result;

            $results += $resultsCurrent;
            $urls += $urlsCurrent;
            $hh += $hhCurrent;
        }

        return [ $results, $urls, $hh ];
    }

    /**
     * @param int|string|array           $limits
     * @param int|float|string|array     $sleeps
     * @param resource|\CurlHandle|array $curls
     *
     * @return \Generator
     */
    public function batchwalk($limits, $sleeps, $curls) : \Generator
    {
        $limits = is_array($limits)
            ? $limits
            : [ $limits ];

        foreach ( $limits as $limit ) {
            if (null === $this->filter->filterIntval($limit)) {
                throw new InvalidArgumentException(
                    [ 'Each limit should be int: %s', $limit ]
                );
            }
        }

        $curls = $this->theCurls($curls);

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
     * @param resource|\CurlHandle|array $curls
     *
     * @return array
     */
    public function multi($curls) : array
    {
        $curls = $this->theCurls($curls);

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
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|string|array          $message
     * @param mixed                      ...$arguments
     *
     * @return resource[]|\CurlHandle[]
     */
    public function curls($curls, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = [];

        $curls = is_array($curls)
            ? $curls
            : [ $curls ];

        if ($hasMessage = ( null !== $message )) {
            $this->filter->assert($message, ...$arguments);
        }

        foreach ( $curls as $idx => $curl ) {
            if (null === $this->filterCurl($curl)) {
                throw new InvalidArgumentException($this->filter->assert()->flushMessage($curl)
                    ?? [ 'Each item should be curl handle: %s', $curl ],
                );
            }

            $result[ $idx ] = $curl;
        }

        if ($hasMessage) {
            $this->filter->assert()->flushMessage();
        }

        if ($uniq ?? false) {
            $distinct = $this->php->distinct($result);

            foreach ( $result as $idx => $val ) {
                if (! isset($distinct[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }
        }

        return $result;
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|string|array          $message
     * @param mixed                      ...$arguments
     *
     * @return resource[]|\CurlHandle[]
     */
    public function theCurls($curls, $uniq = null, $message = null, ...$arguments) : array
    {
        $result = $this->curls($curls, $uniq, $message, ...$arguments);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one curl handle should be provided: %s', $curls ],
            );
        }

        return $result;
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     *
     * @return resource[]|\CurlHandle[]
     */
    public function curlsSkip($curls, $uniq = null) : array
    {
        $result = [];

        $curls = is_array($curls)
            ? $curls
            : [ $curls ];

        foreach ( $curls as $idx => $curl ) {
            if (null !== $this->filterCurl($curl)) {
                $result[ $idx ] = $curl;
            }
        }

        if ($uniq ?? false) {
            $distinct = $this->php->distinct($result);

            foreach ( $result as $idx => $val ) {
                if (! isset($distinct[ $idx ])) {
                    unset($result[ $idx ]);
                }
            }
        }

        return $result;
    }

    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     *
     * @return resource[]|\CurlHandle[]
     */
    public function theCurlsSkip($curls, $uniq = null) : array
    {
        $result = $this->curlsSkip($curls, $uniq);

        if (! count($result)) {
            throw new InvalidArgumentException(
                [ 'At least one curl handle should be provided: %s', $curls ],
            );
        }

        return $result;
    }
}
