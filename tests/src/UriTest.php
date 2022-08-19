<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XUri;
use Gzhegow\Support\IUri;


class UriTest extends AbstractTestCase
{
    protected function getUri() : IUri
    {
        return XUri::getInstance();
    }


    public function testIsUrlMatch()
    {
        $uri = $this->getUri();


        $this->assertEquals(true, $uri->isUrlMatch(
            'http://login:password@hostname:9090/path?arg=value#anchor',
            'http://login:password@hostname:9090/path?arg=value#anchor'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            '/path?arg=value#anchor',
            'http://login:password@hostname:9090/path?arg=value#anchor'
        ));


        $this->assertEquals(false, $uri->isUrlMatch(
            'http://login:password@hostname:9090/path?arg=value#anchor',
            '/path?arg=value#anchor'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            '/path?arg=value#anchor',
            '/path?arg=value#anchor'
        ));


        $this->assertEquals(false, $uri->isUrlMatch(
            '/path/',
            'http://login:password@hostname:9090/path'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            '/path/',
            'http://login:password@hostname:9090/path/'
        ));


        $this->assertEquals(false, $uri->isUrlMatch(
            '/path/subpath',
            'http://login:password@hostname:9090/path'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            '/path/subpath',
            'http://login:password@hostname:9090/path/subpath'
        ));


        $this->assertEquals(false, $uri->isUrlMatch(
            '/path?arg=value',
            'http://login:password@hostname:9090/path'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            '/path?arg=value',
            'http://login:password@hostname:9090/path?arg=value'
        ));


        $this->assertEquals(false, $uri->isUrlMatch(
            '/path?arg=value',
            'http://login:password@hostname:9090/path?arg=value&arg2=value2'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            '/path?arg=value&arg2=value2',
            'http://login:password@hostname:9090/path?arg=value'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            '/path?arg=value&arg2=value2',
            'http://login:password@hostname:9090/path?arg=value&arg2=value2'
        ));


        $this->assertEquals(false, $uri->isUrlMatch(
            '/path#anchor',
            'http://login:password@hostname:9090/path'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            '/path#anchor',
            'http://login:password@hostname:9090/path#anchor'
        ));
    }


    public function testQuery()
    {
        $uri = $this->getUri();

        $this->assertEquals([
            'hello' => '',
            'foo'   => 'bar',
            'world' => [ 1, 2 ],
        ], $uri->parseQuery('hello', [ 'foo' => 'bar' ], 'world[]=1&world[]=2'));
    }


    public function testLinkinfo()
    {
        $uri = $this->getUri();

        $this->assertEquals([
            'scheme'   => null,
            'host'     => null,
            'port'     => null,
            'user'     => null,
            'pass'     => null,
            'path'     => '',
            'query'    => null,
            'fragment' => null,
        ], $uri->parseUrl(''));

        $this->assertEquals([
            'scheme'   => null,
            'host'     => null,
            'port'     => null,
            'user'     => null,
            'pass'     => null,
            'path'     => '_',
            'query'    => null,
            'fragment' => null,
        ], $uri->parseUrl("\0"));

        $this->assertEquals([
            'scheme'   => null,
            'host'     => null,
            'port'     => null,
            'user'     => null,
            'pass'     => null,
            'path'     => '/',
            'query'    => null,
            'fragment' => null,
        ], $uri->parseUrl('/'));

        $this->assertEquals([
            'scheme'   => 'http',
            'host'     => 'hostname',
            'port'     => 9090,
            'user'     => 'login',
            'pass'     => 'password',
            'path'     => '/path',
            'query'    => 'arg=value',
            'fragment' => 'anchor',
        ], $uri->parseUrl('http://login:password@hostname:9090/path?arg=value#anchor'));

        $this->assertEquals([
            'scheme'   => 'https',
            'host'     => 'www.google.com',
            'port'     => 80,
            'user'     => 'login',
            'pass'     => 'password',
            'path'     => '/path',
            'query'    => 'param=value',
            'fragment' => 'hash',
        ], $uri->parseUrl('https://login:password@www.google.com:80/path?param=value#hash'));

        $this->assertEquals([
            'scheme'   => 'https',
            'host'     => 'www.google.com',
            'port'     => 80,
            'user'     => 'login',
            'pass'     => 'password',
            'path'     => '/path',
            'query'    => null,
            'fragment' => 'hash?param=value',
        ], $uri->parseUrl('https://login:password@www.google.com:80/path#hash?param=value'));
    }


    public function testUrl()
    {
        $uri = $this->getUri();

        // $this->assertEquals('', $uri->url(null));
        // $this->assertEquals('', $uri->url(''));
        $this->assertEquals(
            'http://login:password@hostname:9090/path?arg=value#anchor',
            $uri->url('http://login:password@hostname:9090/path?arg=value#anchor')
        );
        $this->assertEquals(
            'http://login:password@www.google.com:8080/path#hash?param=value',
            $uri->url('http://login:password@www.google.com:8080/path#hash?param=value')
        );
        $this->assertEquals(
            'http://login:password@hostname:9090/path',
            $uri->url('http://login:password@hostname:9090/path?arg=value#anchor', [ 'arg' => null ], '')
        );
    }

    public function testLink()
    {
        $uri = $this->getUri();

        $this->assertEquals('', $uri->link(null));
        $this->assertEquals('', $uri->link(''));
        $this->assertEquals(
            '/path?arg=value#anchor',
            $uri->link('http://login:password@hostname:9090/path?arg=value#anchor')
        );
        $this->assertEquals(
            '/path#hash?param=value',
            $uri->link('http://login:password@www.google.com:8080/path#hash?param=value')
        );

        $this->assertEquals(
            '/path',
            $uri->link('http://login:password@hostname:9090/path?arg=value#anchor', [ 'arg' => null ], '')
        );
    }
}