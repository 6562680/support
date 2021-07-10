<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Curl\Manager;
use Gzhegow\Support\Domain\Curl\Blueprint;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Curl
 */
class Curl implements ICurl
{
    /**
     * @var IArr
     */
    protected $arr;
    /**
     * @var IFilter
     */
    protected $filter;
    /**
     * @var INet
     */
    protected $net;
    /**
     * @var IPhp
     */
    protected $php;


    /**
     * @var Manager
     */
    protected $formatter;

    /**
     * @var Blueprint
     */
    protected $blueprint;


    /**
     * Constructor
     *
     * @param IArr    $arr
     * @param IFilter $filter
     * @param INet    $net
     * @param IPhp    $php
     */
    public function __construct(
        IArr $arr,
        IFilter $filter,
        INet $net,
        IPhp $php
    )
    {
        $this->arr = $arr;
        $this->filter = $filter;
        $this->net = $net;
        $this->php = $php;

        $this->reset();
    }


    /**
     * @return static
     */
    public function reset()
    {
        $this->formatter = $this->formatter();
        $this->blueprint = $this->newBlueprint([
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT        => 5,
        ]);

        return $this;
    }


    /**
     * @param null|Blueprint $blueprint
     *
     * @return static
     */
    public function clone(?Blueprint $blueprint)
    {
        $instance = clone $this;

        if (isset($blueprint)) $instance->withBlueprint($blueprint);

        return $instance;
    }


    /**
     * @param null|Blueprint $blueprint
     *
     * @return static
     */
    public function with(?Blueprint $blueprint)
    {
        $this->reset();

        if (isset($blueprint)) $this->withBlueprint($blueprint);

        return $this;
    }


    /**
     * @param Blueprint $blueprint
     *
     * @return static
     */
    public function withBlueprint(Blueprint $blueprint)
    {
        $this->blueprint = $blueprint;

        return $this;
    }


    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    public function newBlueprint(array $curlOptArray = []) : Blueprint
    {
        return new Blueprint(
            $this->arr,
            $this->filter,
            $this->net,

            $this->formatter,

            $curlOptArray
        );
    }

    /**
     * @param array $curlOptArray
     *
     * @return Blueprint
     */
    public function cloneBlueprint(array $curlOptArray = []) : Blueprint
    {
        $clone = clone $this->blueprint;

        $clone->setOptArray($curlOptArray);

        return $clone;
    }


    /**
     * @return Blueprint
     */
    public function getBlueprint() : Blueprint
    {
        return $this->blueprint;
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
     * @return Manager
     */
    public function formatter() : Manager
    {
        if (! isset($this->formatter)) {
            $this->formatter = new Manager(
                $this->filter,
                $this->php,
            );
        }

        return $this->formatter;
    }


    /**
     * @param resource $ch
     *
     * @return null|array
     */
    public function curlInfo($ch) : ?array
    {
        if (null === $this->filter->filterCurl($ch)) {
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
        if (null === $this->filter->filterCurl($ch)) {
            return null;
        }

        $result = ( null !== ( $infoCode = $this->formatter->curlInfoCodeVal($opt) ) )
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
     *
     * @return resource[]|\CurlHandle[]
     */
    public function curls($curls, $uniq = null) : array
    {
        $result = [];

        $curls = is_array($curls)
            ? $curls
            : [ $curls ];

        array_walk_recursive($curls, function ($curl) use (&$result) {
            if (null !== $this->filter->filterCurl($curl)) {
                $result[ (int) $curl ] = $curl;
            }
        });

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
    public function theCurls($curls, $uniq = null) : array
    {
        $result = [];

        $curls = is_array($curls)
            ? $curls
            : [ $curls ];

        array_walk_recursive($curls, function ($curl) use (&$result) {
            $this->filter
                ->assert([ 'Each item should be curl handle: %s', $curl ])
                ->assertCurl($curl);

            $result[ (int) $curl ] = $curl;
        });

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
     * @return ICurl
     */
    public static function me()
    {
        return SupportFactory::getInstance()->getCurl();
    }
}
