<?php

namespace Gzhegow\Support;


use Gzhegow\Support\Interfaces\UriInterface;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Uri
 */
class Uri implements UriInterface
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
     * @var Str
     */
    protected $str;


    /**
     * Constructor
     *
     * @param Arr    $arr
     * @param Filter $filter
     * @param Str    $str
     * @param Php    $php
     */
    public function __construct(
        Arr $arr,
        Filter $filter,
        Php $php,
        Str $str
    )
    {
        $this->arr = $arr;
        $this->filter = $filter;
        $this->php = $php;
        $this->str = $str;
    }


    /**
     * Compares links, allows to create `active` buttons if urls match
     *
     * @param null|string $link
     *
     * @param null|string $needle
     * @param null|array  $needleQuery
     * @param null|string $needleRef
     *
     * @param null|bool   $strictPath
     * @param null|bool   $strictQuery
     * @param null|bool   $strictRef
     *
     * @return bool
     */
    public function isLinkMatch(string $link,
        string $needle = null,
        array $needleQuery = null,
        string $needleRef = null,

        bool $strictPath = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ) : bool
    {
        $strictPath = $strictPath ?? true;
        $strictQuery = $strictQuery ?? true;
        $strictRef = $strictRef ?? true;

        if ($link === ( $link2 = $this->link($needle, $needleQuery, $needleRef) )) {
            return true;
        }

        $info = $this->linkinfo($link);
        $info2 = $this->linkinfo($link2);

        if ($strictPath) {
            $matchPath = ( $info[ 'path' ] === $info2[ 'path' ] );

        } else {
            $parts = explode('/', trim($info[ 'path' ], '/'));
            $parts2 = explode('/', trim($info2[ 'path' ], '/'));

            $match = true;
            foreach ( $parts as $key => $part ) {
                if (! isset($parts2[ $key ])) {
                    continue;
                }

                if ($part !== $parts2[ $key ]) {
                    $match = false;
                    break;
                }
            }

            $matchPath = $match;
        }

        if ($strictQuery) {
            $matchQuery = ( $info[ 'query' ] === $info2[ 'query' ] );

        } else {
            $query = $this->query($info[ 'query' ]);
            $query2 = $this->query($info2[ 'query' ]);

            $match = true;
            foreach ( $this->arr->walk($query) as $fullpath => $value ) {
                $value2 = $this->arr->get($fullpath, $query2, null);

                if (! $value2) {
                    continue;
                }

                if ($value !== $value2) {
                    $match = false;
                    break;
                }
            }

            $matchQuery = $match;
        }

        if (! $strictRef) {
            $matchRef = true;

        } else {
            $matchRef = ( $info[ 'fragment' ] === $info2[ 'fragment' ] );
        }

        $result = 1
            && $matchPath
            && $matchQuery
            && $matchRef;

        return $result;
    }

    /**
     * Compares urls, allows to create `active` buttons if urls match
     *
     * @param null|string $url
     *
     * @param null|string $needle
     * @param null|array  $needleQuery
     * @param null|string $needleRef
     *
     * @param null|bool   $strictPath
     * @param null|bool   $strictQuery
     * @param null|bool   $strictRef
     *
     * @return bool
     */
    public function isUrlMatch(string $url,
        string $needle = null,
        array $needleQuery = null,
        string $needleRef = null,

        bool $strictPath = null,
        bool $strictQuery = null,
        bool $strictRef = null
    ) : bool
    {
        $strictPath = $strictPath ?? true;
        $strictQuery = $strictQuery ?? true;
        $strictRef = $strictRef ?? true;

        if ($url === ( $url2 = $this->url($needle, $needleQuery, $needleRef) )) {
            return true;
        }

        $info = $this->linkinfo($url);
        $info2 = $this->linkinfo($url2);

        $keys = [
            'scheme',
            'host',
            'port',
            'user',
            'pass',
        ];
        foreach ( $keys as $key ) {
            if ($info[ $key ] !== $info2[ $key ]) {
                return false;
            }
        }

        $result = $this->isLinkMatch($url,
            $needle,
            $needleQuery,
            $needleRef,

            $strictPath,
            $strictQuery,
            $strictRef,
        );

        return $result;
    }


    /**
     * @param mixed ...$items
     *
     * @return array
     */
    public function query(...$items) : array
    {
        $query = [];

        foreach ( $items as $item ) {
            if (is_array($item)) {
                $parsed = $item;

            } else {
                parse_str($item, $parsed);
            }

            $query = array_replace_recursive($query, $parsed);
        }

        array_walk_recursive($query, function ($value) {
            if ([] === $value) {
                return;
            }

            if (null === $this->filter->filterStrval($value)) {
                throw new InvalidArgumentException(
                    [ 'Unable to create query string from: %s', $value ]
                );
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
     * @param null|array  $query
     * @param string|null $fragment
     *
     * @return string
     */
    public function url(string $link = null, array $query = null, string $fragment = null) : string
    {
        $query = $query ?? [];

        $_query = [];
        $_fragment = null;

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

            parse_str($info[ 'query' ], $_query);

        } else { // concrete page
            $info = $this->linkinfo($link);

            $info[ 'scheme' ] = $info[ 'scheme' ] ?? $_SERVER[ 'REQUEST_SCHEME' ];
            $info[ 'host' ] = $info[ 'host' ] ?? $_SERVER[ 'HTTP_HOST' ];

            parse_str($info[ 'query' ], $_query);

            $_fragment = $info[ 'fragment' ];
        }

        $_query = array_replace_recursive($_query, $query);

        $_fragment = $fragment ?? $_fragment;

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
        $result[] = rtrim('?' . http_build_query($_query), '?');
        $result[] = rtrim('#' . ltrim($_fragment, '#'), '#');

        $result = implode('', $result);

        return $result;
    }


    /**
     * @param string|null $link
     * @param null|array  $query
     * @param string|null $fragment
     *
     * @return string
     */
    public function link(string $link = null, array $query = null, string $fragment = null) : string
    {
        $result = $this->url($link, $query, $fragment);

        $info = parse_url($result);

        $result = ''
            . ( $info[ 'path' ] ?: '' )
            . rtrim('?' . $info[ 'query' ], '?')
            . rtrim('#' . $info[ 'fragment' ], '#');

        return $result;
    }
}
