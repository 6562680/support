<?php

namespace Gzhegow\Support;


use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Uri
 */
class Uri
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Php
     */
    protected $php;


    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Php    $php
     */
    public function __construct(
        Filter $filter,
        Php $php
    )
    {
        $this->filter = $filter;
        $this->php = $php;
    }


    /**
     * @param mixed ...$batches
     *
     * @return array
     */
    public function query(...$batches) : array
    {
        $query = [];

        foreach ( $batches as $batch ) {
            [ $kwargs, $args ] = $this->php->kwargs($batch);

            if ($kwargs) {
                $query = array_merge_recursive($query, $kwargs);
            }

            foreach ( $args as $arg ) {
                if (null !== ( $str = $this->filter->filterStringable($arg) )) {
                    parse_str($str, $current);

                    if ($current) {
                        $query = array_merge_recursive($query, $current);
                    }
                }
            }
        }

        array_walk_recursive($query, function (&$value) {
            if (0
                || ( [] === $value )
                || ( null === $this->filter->filterStringable($value) )
            ) {
                $value = '';
            }
        });

        return $query;
    }


    /**
     * @param string $uri
     *
     * @return array
     */
    public function linkinfo(string $uri) : array
    {
        if (null === ( $url = $this->filter->filterLink($uri) )) {
            throw new InvalidArgumentException('Invalid Link passed: ' . $url);
        }

        $info = parse_url($url)
            + [
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
     * @param string|null $link
     * @param array       $q
     * @param string|null $ref
     *
     * @return string
     */
    public function url(string $link = null, array $q = [], string $ref = null) : string
    {
        $query = [];
        $fragment = null;

        if (is_null($link)) { // empty url with hash reference for <a href="#hello"></a>
            $info[ 'scheme' ] = null;
            $info[ 'host' ] = null;
            $info[ 'path' ] = null;
            $info[ 'query' ] = null;
            $info[ 'fragment' ] = null;

        } elseif ('' === $link) { // current page
            $info[ 'scheme' ] = $_SERVER[ 'REQUEST_SCHEME' ];
            $info[ 'host' ] = $_SERVER[ 'HTTP_HOST' ];
            $info[ 'path' ] = explode('?', $_SERVER[ 'REQUEST_URI' ])[ 0 ];
            $info[ 'query' ] = $_SERVER[ 'QUERY_STRING' ];
            $info[ 'fragment' ] = null;

            parse_str($info[ 'query' ], $query);

        } else { // concrete page
            $info = $this->linkinfo($link);

            $info[ 'scheme' ] = $info[ 'scheme' ] ?? $_SERVER[ 'REQUEST_SCHEME' ];
            $info[ 'host' ] = $info[ 'host' ] ?? $_SERVER[ 'HTTP_HOST' ];

            parse_str($info[ 'query' ], $query);

            $fragment = $info[ 'fragment' ];
        }

        $q = array_replace_recursive($query, $q);

        $ref = $ref ?? $fragment;

        $result = [];

        if ($info[ 'scheme' ] && $info[ 'host' ]) {
            $result[] = $info[ 'scheme' ];
            $result[] = '://';

            if ($info[ 'user' ]) {
                $result[] = $info[ 'user' ];
                $result[] = rtrim(':' . $info[ 'pass' ], ':');
                $result[] = '@';
            }

            $result[] = $info[ 'host' ];
            $result[] = rtrim(':' . $info[ 'port' ], ':');
        }

        $result[] = $info[ 'path' ] ?: '';
        $result[] = rtrim('?' . http_build_query($q), '?');
        $result[] = rtrim('#' . ltrim($ref, '#'), '#');

        $result = implode('', $result);

        return $result;
    }


    /**
     * @param string|null $link
     * @param array       $q
     * @param string|null $ref
     *
     * @return string
     */
    public function link(string $link = null, array $q = [], string $ref = null) : string
    {
        $result = $this->url($link, $q, $ref);

        $info = parse_url($result);

        $result = ''
            . ( $info[ 'path' ] ?: '' )
            . rtrim('?' . $info[ 'query' ], '?')
            . rtrim('#' . $info[ 'fragment' ], '#');

        return $result;
    }
}
