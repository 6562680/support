<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XUri
 */
class XUri implements IUri
{
    use ArrLoadTrait;


    /**
     * @param string    $regex
     * @param null|bool $absolute
     *
     * @return bool
     */
    public function isUrlCurrent(string $regex, bool $absolute = null) : bool
    {
        $absolute = $absolute ?? true;

        if (false !== @preg_match($regex, null)) {
            throw new InvalidArgumentException([
                'Invalid regex passed: %s',
                $regex,
            ]);
        }

        $url = $absolute
            ? $this->url()
            : $this->link();

        $result = preg_match($regex, $url);

        return $result;
    }

    /**
     * @param string $url
     * @param string $needle
     *
     * @return bool
     */
    public function isUrlMatch(string $url, string $needle) : bool
    {
        if (null === $this->filterLink($url)) {
            throw new InvalidArgumentException([
                'The `haystack` should be valid link: ' . $url,
            ]);
        }

        if (null === $this->filterLink($needle)) {
            throw new InvalidArgumentException([
                'The `needle` should be valid link: ' . $needle,
            ]);
        }

        $isUrl = null !== $this->filterUrl($url);

        $infoUrl = $this->parseUrl($url);
        $infoNeedle = $this->parseUrl($needle);

        $results = [];

        if (isset($infoUrl[ $var = 'path' ])) $results[ $var ] = $infoUrl[ $var ] === $infoNeedle[ $var ];
        if (isset($infoUrl[ $var = 'fragment' ])) $results[ $var ] = $infoUrl[ $var ] === $infoNeedle[ $var ];
        if (isset($infoUrl[ $var = 'query' ])) {
            $results[ $var ] = true;

            $theArr = $this->getArr();

            $queryUrl = $this->parseQuery($infoUrl[ $var ]);
            $queryNeedle = $this->parseQuery($infoNeedle[ $var ]);

            foreach ( $theArr->walk($queryNeedle) as $path => $v ) {
                if (! $theArr->has($path, $queryUrl)) {
                    $results[ $var ] = false;

                    break;
                }
            }
        }

        if ($isUrl) {
            if (isset($infoUrl[ $var = 'scheme' ])) $results[ $var ] = ( $infoUrl[ $var ] === $infoNeedle[ $var ] );
            if (isset($infoUrl[ $var = 'host' ])) $results[ $var ] = ( $infoUrl[ $var ] === $infoNeedle[ $var ] );
            if (isset($infoUrl[ $var = 'port' ])) $results[ $var ] = ( $infoUrl[ $var ] === $infoNeedle[ $var ] );
            if (isset($infoUrl[ $var = 'user' ])) $results[ $var ] = ( $infoUrl[ $var ] === $infoNeedle[ $var ] );
            if (isset($infoUrl[ $var = 'pass' ])) $results[ $var ] = ( $infoUrl[ $var ] === $infoNeedle[ $var ] );
        }

        return $results === array_filter($results);
    }


    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterLink($value) : ?string
    {
        if (is_string($value)
            && ( false !== parse_url($value) )
        ) {
            return $value;
        }

        return null;
    }

    /**
     * @param string|mixed $value
     *
     * @return null|string
     */
    public function filterUrl($value) : ?string
    {
        if (is_string($value)
            && ( false !== filter_var($value, FILTER_VALIDATE_URL) )
            && ( false !== parse_url($value) )
        ) {
            return $value;
        }

        return null;
    }


    /**
     * @param string|null       $url
     * @param bool|string|array $q
     * @param bool|string|null  $ref
     *
     * @return string
     */
    function link(string $url = null, $q = null, $ref = null) : string
    {
        $q = ! is_bool($q) ? $q : ( $q ? null : false );
        $ref = ! is_bool($ref) ? $ref : ( $ref ? null : false );

        $serverRequestUri = $_SERVER[ 'REQUEST_URI' ] ?? null;

        $url = $url
            ?? $serverRequestUri;

        $info = $this->parseUrl($url);

        if (! $withoutQuery = ( $q === false )) {
            $q = $this->parseQuery($q);
            $q += $this->parseQuery($info[ 'query' ] ?? null);
        }

        if (! $withoutFragment = ( $ref === false )) {
            $ref = $ref ?? $info[ 'fragment' ] ?? null;
        }

        $info[ 'path' ] = $info[ 'path' ] ?? null;
        $info[ 'query' ] = $withoutQuery
            ? null
            : ( http_build_query($q) ?: null );
        $info[ 'fragment' ] = $withoutFragment
            ? null
            : ( $ref ?: null );

        $result = $this->buildLink($info);

        return $result;
    }

    /**
     * @param string|null       $url
     * @param bool|string|array $q
     * @param bool|string|null  $ref
     *
     * @return string
     */
    function url(string $url = null, $q = null, $ref = null) : string
    {
        $q = ! is_bool($q) ? $q : ( $q ? null : false );
        $ref = ! is_bool($ref) ? $ref : ( $ref ? null : false );

        $serverScheme = $_SERVER[ 'REQUEST_SCHEME' ] ?? null;
        $serverHost = $_SERVER[ 'HTTP_HOST' ] ?? null;
        $serverRequestUri = $_SERVER[ 'REQUEST_URI' ] ?? null;

        $url = $url
            ?? ( ( $serverScheme && $serverHost && $serverRequestUri )
                ? ( $serverScheme . '://' . $serverHost . $serverRequestUri )
                : null
            );

        $info = $this->parseUrl($url);

        if (! $withoutQuery = ( $q === false )) {
            $q = $this->parseQuery($q);
            $q += $this->parseQuery($info[ 'query' ] ?? null);
        }

        if (! $withoutFragment = ( $ref === false )) {
            $ref = $ref ?? $info[ 'fragment' ] ?? null;
        }

        $info[ 'scheme' ] = $info[ 'scheme' ] ?? null;
        $info[ 'host' ] = $info[ 'host' ] ?? null;
        $info[ 'path' ] = $info[ 'path' ] ?? null;
        $info[ 'query' ] = $withoutQuery
            ? null
            : ( http_build_query($q) ?: null );
        $info[ 'fragment' ] = $withoutFragment
            ? null
            : ( $ref ?: null );

        $forceScheme = $serverScheme && ( $info[ 'scheme' ] !== $serverScheme );
        $forceHost = $serverHost && ( $info[ 'host' ] !== $serverHost );

        if ($forceScheme) $info[ 'scheme' ] = $info[ 'scheme' ] ?? $serverScheme;
        if ($forceHost) $info[ 'host' ] = $info[ 'host' ] ?? $serverHost;

        $result = $this->buildUrl($info);

        return $result;
    }


    /**
     * @param null|string $url
     *
     * @return array
     */
    public function parseUrl(string $url = null) : array
    {
        [ $url, $fragment ] = explode('#', $url, 2) + [ null, null ];
        [ $url, $query ] = explode('?', $url, 2) + [ null, null ];

        $info = ( null !== $url )
            ? parse_url($url)
            : [];

        $info += [
            'scheme'   => null,
            'user'     => null,
            'pass'     => null,
            'host'     => null,
            'port'     => null,
            'path'     => null,
            'query'    => $query,
            'fragment' => $fragment,
        ];

        return $info;
    }

    /**
     * @param string|array ...$queries
     *
     * @return array
     */
    public function parseQuery(...$queries) : array
    {
        foreach ( $queries as $i => $query ) {
            if (null === $query) {
                $query = [];

            } elseif (is_string($query)) {
                parse_str($query, $query);
            }

            if (! is_array($query)) {
                throw new InvalidArgumentException([
                    'Invalid query passed: %s',
                    $query,
                ]);
            }

            $queries[ $i ] = $query;
        }

        $result = array_merge(...$queries);

        return $result;
    }


    /**
     * @param array $parseUrlResult
     *
     * @return string
     */
    public function buildLink(array $parseUrlResult) : string
    {
        $parseUrlResult += [
            'path'     => null,
            'query'    => null,
            'fragment' => null,
        ];

        return ''
            . ( strlen($var = $parseUrlResult[ 'path' ]) ? "{$var}" : '' )
            . ( strlen($var = $parseUrlResult[ 'query' ]) ? "?{$var}" : '' )
            . ( strlen($var = $parseUrlResult[ 'fragment' ]) ? "#{$var}" : '' );
    }

    /**
     * @param array $parseUrlResult
     *
     * @return string
     */
    public function buildUrl(array $parseUrlResult) : string
    {
        $parseUrlResult += [
            'scheme'   => null,
            'user'     => null,
            'pass'     => null,
            'host'     => null,
            'port'     => null,
            'path'     => null,
            'query'    => null,
            'fragment' => null,
        ];

        $isUser = strlen($varUser = $parseUrlResult[ 'user' ]);
        $isHost = strlen($varHost = $parseUrlResult[ 'host' ]);

        return ''
            . ( strlen($var = $parseUrlResult[ 'scheme' ]) ? "{$var}:" : '' )
            . ( ( $isUser || $isHost ) ? '//' : '' )
            . ( $isUser ? "{$varUser}" : '' )
            . ( ( $isUser && strlen($var = $parseUrlResult[ 'pass' ]) ) ? ":{$var}" : '' )
            . ( $isUser ? '@' : '' )
            . ( $isHost ? "{$varHost}" : '' )
            . ( ( $isHost && strlen($var = $parseUrlResult[ 'port' ]) ) ? ":{$var}" : '' )
            . ( strlen($var = $parseUrlResult[ 'path' ])
                ? ( $isHost
                    ? '/' . ltrim($var, '/')
                    : $var
                )
                : ''
            )
            . ( strlen($var = $parseUrlResult[ 'query' ]) ? "?{$var}" : '' )
            . ( strlen($var = $parseUrlResult[ 'fragment' ]) ? "#{$var}" : '' );
    }


    /**
     * @param array $parseQueryResult
     *
     * @return string
     */
    public function buildQuery(array $parseQueryResult) : ?string
    {
        return http_build_query($parseQueryResult) ?: null;
    }


    /**
     * @return IUri
     */
    public static function getInstance() : IUri
    {
        return SupportFactory::getInstance()->getUri();
    }
}