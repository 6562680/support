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
     * @var Type
     */
    protected $type;


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
     * @param Type   $type
     */
    public function __construct(
        Arr $arr,
        Filter $filter,
        Php $php,
        Type $type
    )
    {
        $this->arr = $arr;
        $this->filter = $filter;
        $this->php = $php;
        $this->type = $type;

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
            $this->type,

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
            $this->php,
            $this->type
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
     * @param mixed $ch
     *
     * @return boolean
     */
    public function isCurl($ch) : bool
    {
        return is_resource($ch)
            && ( false !== @curl_error($ch) );
    }

    /**
     * @param mixed $ch
     *
     * @return boolean
     */
    public function isOpenedCurl($ch) : bool
    {
        return $this->isCurl($ch)
            && ! $this->type->isClosedResource($ch);
    }

    /**
     * @param mixed $ch
     *
     * @return boolean
     */
    public function isClosedCurl($ch) : bool
    {
        return $this->isCurl($ch)
            && $this->type->isClosedResource($ch);
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
     * @return null|mixed[]|mixed[][]
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
     * @return null|mixed|mixed[]
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
     * @param       $opt
     * @param mixed $value
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
     * @param mixed $curl
     * @param mixed $opt
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
     * @param mixed               $limit
     * @param mixed               $sleep
     * @param resource|resource[] $curls
     *
     * @return array
     */
    public function batch($limit, $sleep, ...$curls) : array
    {
        [ 1 => $curls ] = $this->php->kwargsFlatten(...$curls);

        foreach ( $curls as $ch ) {
            if (! $this->isOpenedCurl($ch)) {
                throw new InvalidArgumentException('Each argument should be opened CURL resource');
            }
        }

        $results = [];
        $urls = [];
        $hh = [];

        $limit = $limit
            ?: 1;

        foreach ( $this->batchwalk($limit, $sleep, $curls) as $result ) {
            [ $resultsCurrent, $urlsCurrent, $hhCurrent ] = $result;

            $results += $resultsCurrent;
            $urls += $urlsCurrent;
            $hh += $hhCurrent;
        }

        return [ $results, $urls, $hh ];
    }

    /**
     * @param mixed               $limit
     * @param mixed               $sleep
     * @param resource|resource[] $curls
     *
     * @return \Generator
     */
    public function batchwalk($limit, $sleep, ...$curls) : \Generator
    {
        [ 1 => $curls ] = $this->php->kwargsFlatten(...$curls);

        foreach ( $curls as $ch ) {
            if (! $this->isOpenedCurl($ch)) {
                throw new InvalidArgumentException('Each argument should be opened CURL resource');
            }
        }

        [ $minLimit, $maxLimit ] = (array) $limit + [ 1, null ];
        [ $minSleep, $maxSleep ] = (array) $sleep + [ 0, null ];

        if (! is_int($minLimit)) {
            throw new InvalidArgumentException('MinLimit should be numeric', func_get_args());
        }

        if (! is_numeric($minSleep)) {
            throw new InvalidArgumentException('MinLimit should be numeric', func_get_args());
        }

        if (0 > $minLimit) {
            throw new InvalidArgumentException('MinLimit should be positive');
        }

        if (0 > $minSleep) {
            throw new InvalidArgumentException('MinLimit should be positive');
        }

        $maxLimit = $maxLimit ?? $minLimit;
        $maxSleep = $maxSleep ?? $minSleep;

        if (! is_int($maxLimit)) {
            throw new InvalidArgumentException('MinLimit should be numeric', func_get_args());
        }

        if (! is_numeric($maxSleep)) {
            throw new InvalidArgumentException('MinLimit should be numeric', func_get_args());
        }

        if (0 > $maxLimit) {
            throw new InvalidArgumentException('MinLimit should be positive');
        }

        if (0 > $maxSleep) {
            throw new InvalidArgumentException('MinLimit should be positive');
        }

        do {
            $limitCurrent = rand($minLimit, $maxLimit) ?? null;

            // splice
            $i = 0;
            $curlsCurrent = [];
            while ( null !== ( $key = key($curls) ) ) {
                $curlsCurrent[ $key ] = $curls[ $key ];
                unset($curls[ $key ]);

                if (++$i === $limitCurrent) {
                    break;
                }
            }

            // multicurl
            [ $responsesCurrent, $urlsCurrent, $hhCurrent ] = $this->multi($curlsCurrent);

            // return generator to reduce memory usage
            yield [ $responsesCurrent, $urlsCurrent, $hhCurrent ];

            // await before next batch
            if ($curls) {
                $sleepCurrent = $minSleep;

                if ($sleepCurrent !== $maxSleep) {
                    $sleepCurrent = ( $minSleep + lcg_value() * ( abs($maxSleep - $minSleep) ) );

                    // wait microseconds
                    usleep($sleepCurrent * 1000 * 1000);

                } elseif (is_float($sleepCurrent)) {
                    // wait microseconds
                    usleep($sleepCurrent * 1000 * 1000);

                } else {
                    // wait seconds
                    sleep($sleepCurrent);
                }
            }
        } while ( $curls );
    }


    /**
     * @param resource|resource[] $curls
     *
     * @return array
     */
    public function multi(...$curls) : array
    {
        [ 1 => $curls ] = $this->php->kwargsFlatten(...$curls);

        foreach ( $curls as $ch ) {
            if (! $this->isOpenedCurl($ch)) {
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
}
