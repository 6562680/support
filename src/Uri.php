<?php

namespace Gzhegow\Support;


/**
 * Uri
 */
class Uri
{
    /**
     * @param string $url
     *
     * @return array
     */
    public function linkinfo(string $url) : array
    {
        $info = parse_url($url) + [
                'scheme'   => null,
                'host'     => null,
                'port'     => null,
                'user'     => null,
                'pass'     => null,
                'path'     => null,
                'query'    => null,
                'fragment' => null,
            ];

        return $info;
    }


    /**
     * @param string|null $query
     *
     * @return array
     */
    public function query(string $query = null) : array
    {
        $data = [];

        if (isset($query)) {
            parse_str($query, $data);
        }

        return $data
            ?: [];
    }


    /**
     * @param string|null $url
     * @param array       $q
     * @param string|null $ref
     *
     * @return string
     */
    public function path(string $url = null, array $q = [], string $ref = null) : string
    {
        $info = $this->linkinfo($url);

        $info[ 'path' ] = $info[ 'path' ] ?? null;
        $info[ 'query' ] = $info[ 'query' ] ?? null;
        $info[ 'fragment' ] = $info[ 'fragment' ] ?? null;

        $ref = $ref ?? $info[ 'fragment' ];

        parse_str($info[ 'query' ], $data);

        $q += $data;

        return '/'
            . ltrim($info[ 'path' ], '/')
            . rtrim('?' . http_build_query($q), '?')
            . rtrim('#' . $ref, '#');
    }


    /**
     * @param string|null $url
     * @param array       $q
     * @param string|null $ref
     *
     * @return string
     */
    public function link(string $url = null, array $q = [], string $ref = null) : string
    {
        $query = [];
        $fragment = null;

        if (is_null($url)) {
            // supports only hash
            $info[ 'scheme' ] = null;
            $info[ 'host' ] = null;
            $info[ 'path' ] = null;
            $info[ 'query' ] = null;
            $info[ 'fragment' ] = null;

        } elseif ('' === $url) {
            // current page
            $info[ 'scheme' ] = $_SERVER[ 'REQUEST_SCHEME' ];
            $info[ 'host' ] = $_SERVER[ 'HTTP_HOST' ];
            $info[ 'path' ] = explode('?', $_SERVER[ 'REQUEST_URI' ])[ 0 ];
            $info[ 'query' ] = $_SERVER[ 'QUERY_STRING' ];
            $info[ 'fragment' ] = null;

            parse_str($info[ 'query' ], $query);

        } else {
            // concrete page
            $info = $this->linkinfo($url);

            $info[ 'scheme' ] = $info[ 'scheme' ] ?? $_SERVER[ 'REQUEST_SCHEME' ];
            $info[ 'host' ] = $info[ 'host' ] ?? $_SERVER[ 'HTTP_HOST' ];

            parse_str($info[ 'query' ], $query);

            $fragment = $info[ 'fragment' ];
        }

        $q += $query;

        $ref = $ref ?? $fragment;

        return ''
            . ( ( $info[ 'scheme' ] && $info[ 'host' ] )
                ? ( $info[ 'scheme' ] . '://' . $info[ 'host' ] . '/' )
                : '/'
            )
            . ( $info[ 'path' ]
                ? ltrim($info[ 'path' ], '/')
                : null )
            . rtrim('?' . http_build_query($q), '?')
            . rtrim('#' . ltrim($ref, '#'), '#');
    }


    /**
     * @param string|null $url
     * @param string|null $ref
     * @param array       $q
     *
     * @return string
     */
    public function ref(string $url = null, string $ref = null, array $q = []) : string
    {
        return $this->link($url, $q, $ref);
    }
}
