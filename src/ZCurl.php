<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Curl\CurlBlueprint;
use Gzhegow\Support\Domain\Curl\CurloptManager;
use Gzhegow\Support\Domain\Curl\CurloptManagerInterface;


/**
 * ZCurl
 */
class ZCurl implements ICurl
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
     * @var CurlBlueprint
     */
    protected $blueprint;

    /**
     * @var CurloptManagerInterface
     */
    protected $curloptManager;


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
     * @return static
     */
    public function reset()
    {
        $this->curloptManager = $this->curloptManager();

        $this->blueprint = $this->newBlueprint(
            $this->getCurloptArrayDefault()
        );

        return $this;
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
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public function newBlueprint(array $curloptArray = null) : CurlBlueprint
    {
        $curloptArray = $curloptArray ?? [];

        return new CurlBlueprint(
            $this->arr,
            $this->filter,
            $this->net,

            $this->curloptManager,

            $curloptArray
        );
    }

    /**
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public function cloneBlueprint(array $curloptArray = null) : CurlBlueprint
    {
        $curloptArray = $curloptArray ?? [];

        $clone = clone $this->blueprint;

        $clone->setCurloptArray($curloptArray);

        return $clone;
    }


    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource
     */
    public function get(string $url, $data = null, array $headers = null)
    {
        return $this->blueprint->get($url, $data, $headers);
    }


    /**
     * @return CurlBlueprint
     */
    public function getBlueprint() : CurlBlueprint
    {
        return $this->blueprint;
    }


    /**
     * @param null|bool $verbose
     *
     * @return array
     */
    public function getCurloptArray(bool $verbose = null) : array
    {
        return $this->blueprint->getCurloptArray($verbose);
    }

    /**
     * @return array
     */
    public function getCurloptArrayDefault() : array
    {
        return [
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT        => 5,
        ];
    }


    /**
     * @param null|CurloptManagerInterface $curloptManager
     *
     * @return CurloptManagerInterface
     */
    public function curloptManager(CurloptManagerInterface $curloptManager = null) : CurloptManagerInterface
    {
        $this->curloptManager = $curloptManager ?? $this->curloptManager;

        if (! isset($this->curloptManager)) {
            $this->curloptManager = new CurloptManager(
                $this->filter,
                $this->php,
            );
        }

        return $this->curloptManager;
    }


    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function head(string $url, array $headers = null)
    {
        return $this->blueprint->head($url, $headers);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function options(string $url, array $headers = null)
    {
        return $this->blueprint->options($url, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function post(string $url, $data = null, array $headers = null)
    {
        return $this->blueprint->post($url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function patch(string $url, $data = null, array $headers = null)
    {
        return $this->blueprint->patch($url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function put(string $url, $data = null, array $headers = null)
    {
        return $this->blueprint->put($url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function delete(string $url, array $headers = null)
    {
        return $this->blueprint->delete($url, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function purge(string $url, $data = null, array $headers = null)
    {
        return $this->blueprint->purge($url, $data, $headers);
    }

    /**
     * @param string     $method
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function request(string $method, string $url, $data = null, array $headers = null)
    {
        return $this->blueprint->request($method, $url, $data, $headers);
    }


    /**
     * @param resource $ch
     *
     * @return null|array
     */
    public function curlinfo($ch) : ?array
    {
        if (null === $this->filter->filterCurl($ch)) {
            return null;
        }

        $result = curl_getinfo($ch);

        return $result ?: null;
    }

    /**
     * @param resource   $ch
     * @param int|string $curlopt
     *
     * @return null|mixed|array
     */
    public function curlinfoOpt($ch, $curlopt)
    {
        if (null === $this->filter->filterCurl($ch)) {
            return null;
        }

        $curlinfoCode = $this->curloptManager->curlinfoCodeVal($curlopt);
        $curlinfoKey = $curlopt;

        $result = null
            ?? ( ( null !== $curlinfoCode ) ? curl_getinfo($ch, $curlinfoCode) : null )
            ?? curl_getinfo($ch)[ $curlinfoKey ];

        return $result ?: null;
    }


    /**
     * @param resource|\CurlHandle|array $curls
     *
     * @return string[]
     */
    public function execMulti($curls) : array
    {
        $curls = $this->theCurls($curls);

        $master = curl_multi_init();

        foreach ( $curls as $ch ) {
            curl_multi_add_handle($master, $ch);
        }

        do {
            $mrc = curl_multi_exec($master, $running);

            if ($running) {
                curl_multi_select($master);
            }
        } while ( $running && $mrc == CURLM_OK );

        $results = [];
        foreach ( $curls as $idx => $ch ) {
            $results[ $idx ] = curl_multi_getcontent($ch);

            curl_multi_remove_handle($master, $ch);
        }

        curl_multi_close($master);

        return $results;
    }


    /**
     * @param resource|\CurlHandle|array $curls
     * @param null|bool                  $uniq
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public function aCurls($curls, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $curls = is_array($curls)
            ? $curls
            : [ $curls ];

        if ($recursive) {
            array_walk_recursive($curls, function ($item, $idx) use (&$result) {
                if (null !== $this->filter->filterCurl($item)) {
                    $result[ $idx ] = $item;
                }
            });

        } else {
            foreach ( $curls as $idx => $item ) {
                if (null !== $this->filter->filterCurl($item)) {
                    $result[ $idx ] = $item;
                }
            }
        }

        if ($uniq) {
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
     * @param null|bool                  $recursive
     *
     * @return resource[]|\CurlHandle[]
     */
    public function theCurls($curls, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $curls = is_array($curls)
            ? $curls
            : [ $curls ];

        if ($recursive) {
            array_walk_recursive($curls, function ($item, $idx) use (&$result) {
                $this->filter
                    ->assert([ 'Each item should be Curl handle/resource: %s', $item ])
                    ->assertCurl($item);

                $result[ $idx ] = $item;
            });

        } else {
            foreach ( $curls as $idx => $item ) {
                $this->filter
                    ->assert([ 'Each item should be Curl handle/resource: %s', $item ])
                    ->assertCurl($item);

                $result[ $idx ] = $item;
            }
        }

        if ($uniq) {
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
    public static function getInstance() : ICurl
    {
        return SupportFactory::getInstance()->getCurl();
    }



}