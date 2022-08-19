<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XNet
 */
class XNet implements INet
{
    use StrLoadTrait;


    const METHOD_CONNECT = 'CONNECT';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_GET     = 'GET';
    const METHOD_HEAD    = 'HEAD';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_POST    = 'POST';
    const METHOD_PURGE   = 'PURGE';
    const METHOD_PUT     = 'PUT';
    const METHOD_TRACE   = 'TRACE';

    const THE_METHOD_LIST = [
        self::METHOD_HEAD    => true,
        self::METHOD_OPTIONS => true,
        self::METHOD_GET     => true,
        self::METHOD_POST    => true,
        self::METHOD_PATCH   => true,
        self::METHOD_PUT     => true,
        self::METHOD_DELETE  => true,
        self::METHOD_PURGE   => true,
        self::METHOD_CONNECT => true,
        self::METHOD_TRACE   => true,
    ];


    /**
     * @param string $ip
     * @param string $mask
     *
     * @return bool
     */
    public function isInSubnet(string $ip, string $mask) : bool
    {
        if (null === $this->filterIp($ip)) return false;
        if (null === ( $maskArray = $this->filterMask($mask) )) return true;

        [ $subnet_ip, $cidr ] = $maskArray;

        $bitmask = -1 << 32 - $cidr;

        return ( ip2long($ip) & $bitmask ) === ( ip2long($subnet_ip) & $bitmask );
    }


    /**
     * @param string $ip
     *
     * @return null|string
     */
    public function filterIp(string $ip) : ?string
    {
        if ('' === $ip) return null;

        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     * @param string $mask
     *
     * @return null|array
     */
    public function filterMask(string $mask) : ?array
    {
        if ('' === $mask) return null;

        [ $subnet_ip, $cidr ] = explode('/', $mask) + [ null, 32 ];

        $cidr = (int) $cidr;
        if ($cidr < 0) return null;
        if ($cidr > 32) return null;

        return [ $subnet_ip, $cidr ];
    }


    /**
     * @param string $httpMethod
     *
     * @return null|string
     */
    public function httpMethodVal($httpMethod) : ?string
    {
        $val = null;

        if (! is_string($httpMethod)) {
            return null;
        }

        if ('' === $httpMethod) {
            return null;
        }

        if (isset(static::THE_METHOD_LIST[ $httpMethodUpper = strtoupper($httpMethod) ])) {
            $val = $httpMethodUpper;
        }

        return $val;
    }

    /**
     * @param string $httpMethod
     *
     * @return string
     */
    public function theHttpMethodVal($httpMethod) : string
    {
        if (null === ( $val = $this->httpMethodVal($httpMethod) )) {
            throw new InvalidArgumentException(
                [ 'Invalid HttpMethod passed: %s', $httpMethod ]
            );
        }

        return $val;
    }


    /**
     * @param string|array $httpMethods
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function httpMethodVals($httpMethods, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $httpMethods = is_array($httpMethods)
            ? $httpMethods
            : [ $httpMethods ];

        if ($recursive) {
            array_walk_recursive($httpMethods, function ($item) use (&$result) {
                if (null !== ( $val = $this->httpMethodVal($item) )) {
                    $result[] = $val;
                }
            });

        } else {
            foreach ( $httpMethods as $item ) {
                if (null !== ( $val = $this->httpMethodVal($item) )) {
                    $result[] = $val;
                }
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }

    /**
     * @param string|array $httpMethods
     * @param null|bool    $uniq
     * @param null|bool    $recursive
     *
     * @return string[]
     */
    public function theHttpMethodVals($httpMethods, bool $uniq = null, bool $recursive = null) : array
    {
        $result = [];

        $httpMethods = is_array($httpMethods)
            ? $httpMethods
            : [ $httpMethods ];

        if ($recursive) {
            array_walk_recursive($httpMethods, function ($item) use (&$result) {
                $result[] = $this->theHttpMethodVal($item);
            });

        } else {
            foreach ( $httpMethods as $item ) {
                $result[] = $this->theHttpMethodVal($item);
            }
        }

        if ($uniq) {
            $arr = [];
            foreach ( $result as $i ) {
                $arr[ $i ] = true;
            }
            $result = array_keys($arr);
        }

        return $result;
    }


    /**
     * @param string $header
     *
     * @return null|string
     */
    public function header(string $header) : ?string
    {
        if ('' === $header) {
            return null;
        }

        $theStr = $this->getStr();

        $server_key = $theStr->prepend(
            strtoupper($theStr->snakeCase($header)),
            'HTTP_'
        );

        $result = null
            ?? $_SERVER[ $server_key ]
            ?? $this->headers()[ $header ]
            ?? null;

        return $result;
    }

    /**
     * @return array
     */
    public function headers() : array
    {
        $theStr = $this->getStr();

        $result = [];

        foreach ( $_SERVER as $key => $val ) {
            if (! $header = $theStr->starts($key, 'HTTP_')) continue;

            $result[ $theStr->pascal($header, null, '-') ] = $val;
        }

        return $result;
    }


    /**
     * @return string
     */
    public function ip() : string
    {
        return null
            ?? $_SERVER[ 'HTTP_CLIENT_IP' ]
            ?? $_SERVER[ 'HTTP_X_FORWARDED_FOR' ]
            ?? $_SERVER[ 'REMOTE_ADDR' ]
            ?? '127.0.0.1';
    }

    /**
     * @return null|string
     */
    public function useragent() : ?string
    {
        return $_SERVER[ 'HTTP_USER_AGENT' ] ?? null;
    }


    /**
     * @return INet
     */
    public static function getInstance() : INet
    {
        return SupportFactory::getInstance()->getNet();
    }
}