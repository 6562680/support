<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Uri;
use Gzhegow\Support\Php;
use Gzhegow\Support\Arr;
use Gzhegow\Support\Str;
use Gzhegow\Support\Filter;


class UriTest extends AbstractTestCase
{
    protected function getFilter() : Filter
    {
        return new Filter();
    }

    protected function getPhp() : Php
    {
        return new Php(
            $this->getFilter()
        );
    }

    protected function getStr() : Str
    {
        return new Str(
            $this->getFilter(),
            $this->getPhp()
        );
    }

    protected function getArr() : Arr
    {
        return new Arr(
            $this->getFilter(),
            $this->getPhp(),
            $this->getStr()
        );
    }

    protected function getUri() : Uri
    {
        return new Uri(
            $this->getArr(),
            $this->getFilter(),
            $this->getPhp(),
            $this->getStr()
        );
    }


    public function testIsLinkMatch()
    {
        $uri = $this->getUri();

        $this->assertEquals(true, $uri->isLinkMatch(
            'http://login:password@hostname:9090/path?arg=value#anchor',
            'http://login:password@hostname:9090/path?arg=value#anchor'
        ));

        $this->assertEquals(true, $uri->isLinkMatch(
            '/path?arg=value#anchor',
            'http://login:password@hostname:9090/path?arg=value#anchor'
        ));

        $this->assertEquals(true, $uri->isLinkMatch(
            '/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/?arg=value#anchor', null, null,
            false
        ));

        $this->assertEquals(true, $uri->isLinkMatch(
            '/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/subpath?arg=#anchor', null, null,
            null, false
        ));

        $this->assertEquals(true, $uri->isLinkMatch(
            '/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/subpath?arg=value', null, null,
            null, null, false
        ));
    }

    public function testIsUrlMatch()
    {
        $uri = $this->getUri();

        $this->assertEquals(true, $uri->isUrlMatch(
            'http://login:password@hostname:9090/path?arg=value#anchor',
            'http://login:password@hostname:9090/path?arg=value#anchor'
        ));


        $this->assertEquals(false, $uri->isUrlMatch(
            '/path?arg=value#anchor',
            'http://login:password@hostname:9090/path?arg=value#anchor'
        ));

        $this->assertEquals(false, $uri->isUrlMatch(
            '/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/?arg=value#anchor', null, null,
            false
        ));

        $this->assertEquals(false, $uri->isUrlMatch(
            '/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/subpath?arg=#anchor', null, null,
            null, false
        ));

        $this->assertEquals(false, $uri->isUrlMatch(
            '/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/subpath?arg=value', null, null,
            null, null, false
        ));


        $this->assertEquals(true, $uri->isUrlMatch(
            'http://login:password@hostname:9090/path?arg=value#anchor',
            'http://login:password@hostname:9090/path?arg=value#anchor'
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            'http://login:password@hostname:9090/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/?arg=value#anchor', null, null,
            false
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            'http://login:password@hostname:9090/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/subpath?arg=#anchor', null, null,
            null, false
        ));

        $this->assertEquals(true, $uri->isUrlMatch(
            'http://login:password@hostname:9090/path/subpath?arg=value#anchor',
            'http://login:password@hostname:9090/path/subpath?arg=value', null, null,
            null, null, false
        ));
    }


    public function testQuery()
    {
        $uri = $this->getUri();

        $this->assertEquals([
            'hello' => '',
            'world' => '',
            'foo'   => 'bar',
        ], $uri->query('hello', [ 'foo' => 'bar' ], 'world'));
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
        ], $uri->linkinfo(''));

        $this->assertEquals([
            'scheme'   => null,
            'host'     => null,
            'port'     => null,
            'user'     => null,
            'pass'     => null,
            'path'     => '_',
            'query'    => null,
            'fragment' => null,
        ], $uri->linkinfo("\0"));

        $this->assertEquals([
            'scheme'   => null,
            'host'     => null,
            'port'     => null,
            'user'     => null,
            'pass'     => null,
            'path'     => '/',
            'query'    => null,
            'fragment' => null,
        ], $uri->linkinfo('/'));

        $this->assertEquals([
            'scheme'   => 'http',
            'host'     => 'hostname',
            'port'     => 9090,
            'user'     => 'login',
            'pass'     => 'password',
            'path'     => '/path',
            'query'    => 'arg=value',
            'fragment' => 'anchor',
        ], $uri->linkinfo('http://login:password@hostname:9090/path?arg=value#anchor'));

        $this->assertEquals([
            'scheme'   => 'https',
            'host'     => 'www.google.com',
            'port'     => 80,
            'user'     => 'login',
            'pass'     => 'password',
            'path'     => '/path',
            'query'    => 'param=value',
            'fragment' => 'hash',
        ], $uri->linkinfo('https://login:password@www.google.com:80/path?param=value#hash'));

        $this->assertEquals([
            'scheme'   => 'https',
            'host'     => 'www.google.com',
            'port'     => 80,
            'user'     => 'login',
            'pass'     => 'password',
            'path'     => '/path',
            'query'    => null,
            'fragment' => 'hash?param=value',
        ], $uri->linkinfo('https://login:password@www.google.com:80/path#hash?param=value'));
    }


    public function testUrl()
    {
        $uri = $this->getUri();

        $this->assertEquals('', $uri->url(null));
        $this->assertEquals('', $uri->url(''));
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
