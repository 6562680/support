<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Domain\Curl\CurlBlueprint;
use Gzhegow\Support\Traits\Load\Curl\CurloptManagerLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XCurl
 */
class XCurl implements ICurl
{
    use ArrLoadTrait;
    use FsLoadTrait;

    use CurloptManagerLoadTrait;


    /**
     * @var CurlBlueprint
     */
    protected $blueprint;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->withBlueprint(null);
    }


    /**
     * @param null|CurlBlueprint $blueprint
     *
     * @return static
     */
    public function withBlueprint(?CurlBlueprint $blueprint)
    {
        $this->blueprint = $blueprint ?? $this->loadCurlBlueprint();

        return $this;
    }


    /**
     * @return CurlBlueprint
     */
    protected function loadCurlBlueprint() : CurlBlueprint
    {
        return $this->newCurlBlueprint([
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);
    }


    /**
     * @param null|array $curloptArray
     *
     * @return CurlBlueprint
     */
    public function newCurlBlueprint(array $curloptArray = null) : CurlBlueprint
    {
        return SupportFactory::getInstance()->newCurlCurlBlueprint($curloptArray);
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
    public function getCurlBlueprint() : CurlBlueprint
    {
        return $this->blueprint;
    }


    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurl($ch) // : ?resource|\CurlHandle
    {
        if (! ( false
            || is_a($ch, 'CurlHandle')
            || ( null !== $this->getFs()->filterResource($ch) )
        )) {
            return null;
        }

        if (false === @curl_getinfo($ch)) {
            return null;
        }

        return $ch;
    }

    /**
     * @param resource|\CurlHandle $ch
     *
     * @return null|resource|\CurlHandle
     */
    public function filterCurlFresh($ch) // : ?resource|\CurlHandle
    {
        if (! ( false
            || is_a($ch, 'CurlHandle')
            || ( null !== $this->getFs()->filterResource($ch) )
        )) {
            return null;
        }

        if (0.0 !== @curl_getinfo($ch, CURLINFO_TOTAL_TIME)) {
            return null;
        }

        if (0 !== @curl_errno($ch)) {
            return null;
        }

        return $ch;
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
        if (null === $this->filterCurl($ch)) {
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
        if (null === $this->filterCurl($ch)) {
            return null;
        }

        $curlinfoCode = $this->getCurloptManager()->curlinfoCodeVal($curlopt);
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
    public function curls($curls, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $curls = is_array($curls)
            ? $curls
            : [ $curls ];

        if ($recursive) {
            array_walk_recursive($curls, function ($item, $idx) use (&$result) {
                if (null !== $this->filterCurlFresh($item)) {
                    $result[ $idx ] = $item;
                }
            });

        } else {
            foreach ( $curls as $idx => $item ) {
                if (null !== $this->filterCurlFresh($item)) {
                    $result[ $idx ] = $item;
                }
            }
        }

        if ($uniq) {
            $distinct = $this->getArr()->distinct($result);

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
                if (null === $this->filterCurlFresh($item)) {
                    throw new InvalidArgumentException([
                        'Each item should be opened Curl handle/resource: %s',
                        $item,
                    ]);
                }

                $result[ $idx ] = $item;
            });

        } else {
            foreach ( $curls as $idx => $item ) {
                if (null === $this->filterCurlFresh($item)) {
                    throw new InvalidArgumentException([
                        'Each item should be opened Curl handle/resource: %s',
                        $item,
                    ]);
                }

                $result[ $idx ] = $item;
            }
        }

        if ($uniq) {
            $distinct = $this->getArr()->distinct($result);

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