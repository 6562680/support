<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Interfaces\NetInterface;


/**
 * Net
 */
class Net implements NetInterface
{
    /**
     * @var Str
     */
    protected $str;


    /**
     * Constructor
     *
     * @param Str $str
     */
    public function __construct(Str $str)
    {
        $this->str = $str;
    }


    /**
     * @param string $ip
     *
     * @return bool
     */
    public function isIp(string $ip) : bool
    {
        if ('' === $ip) return false;

        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     * @param string $mask
     * @param null   $subnet_ip
     * @param null   $cidr
     *
     * @return bool
     */
    public function isMask(string $mask, &$subnet_ip = null, &$cidr = null) : bool
    {
        if ('' === $mask) return false;

        [ $subnet_ip, $cidr ] = explode('/', $mask) + [ null, 32 ];

        $cidr = (int) $cidr;
        if ($cidr < 0) return false;
        if ($cidr > 32) return false;

        return true;
    }


    /**
     * @param string $ip
     * @param string $mask
     *
     * @return bool
     */
    public function isInSubnet(string $ip, string $mask) : bool
    {
        if (! $this->isIp($ip)) return false;
        if (! $this->isMask($mask, $subnet_ip, $cidr)) return true;

        $bitmask = -1 << 32 - $cidr;

        return ( ip2long($ip) & $bitmask ) === ( ip2long($subnet_ip) & $bitmask );
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

        $server_key = $this->str->prepend(strtoupper($this->str->snake($header)), 'HTTP_');

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
        $result = [];

        foreach ( $_SERVER as $key => $val ) {
            if (! $header = $this->str->starts($key, 'HTTP_')) continue;

            $result[ $this->str->pascal($header, null, '-') ] = $val;
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
        return isset($_SERVER[ 'HTTP_USER_AGENT' ])
            ? $_SERVER[ 'HTTP_USER_AGENT' ]
            : null;
    }
}
