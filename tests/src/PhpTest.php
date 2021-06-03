<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Php;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\RuntimeException;


class PhpTest extends AbstractTestCase
{
    protected function getPhp() : Php
    {
        return ( new SupportFactory() )->newPhp();
    }


    public function testListval()
    {
        $php = $this->getPhp();

        $this->assertEquals([ null ], $php->listval(null));
        $this->assertEquals([ null ], $php->listval([ null ]));
        $this->assertEquals([ null, null ], $php->listval([ null, [ null ] ]));

        $this->assertEquals([ null, null ], $php->listval(null, null));
        $this->assertEquals([ null, null ], $php->listval([ null ], [ null ]));
        $this->assertEquals([ null, null, null, null ], $php->listval([ null, [ null ] ], [ null, [ null ] ]));
    }

    public function testListvals()
    {
        $php = $this->getPhp();

        $this->assertEquals([ [ null ] ], $php->listvals(null));
        $this->assertEquals([ [ null ] ], $php->listvals([ null ]));
        $this->assertEquals([ [ null, null ] ], $php->listvals([ null, [ null ] ]));

        $this->assertEquals([ [ null ], [ null ] ], $php->listvals(null, null));
        $this->assertEquals([ [ null ], [ null ] ], $php->listvals([ null ], [ null ]));
        $this->assertEquals([ [ null, null ], [ null, null ] ], $php->listvals([ null, [ null ] ], [ null, [ null ] ]));
    }


    public function testMapval()
    {
        $php = $this->getPhp();

        $map = [];
        $keys = [ null, 0, 0.0, '', 'a' ];
        foreach ( $keys as $key ) {
            $map[] = array_combine($keys, array_fill(0, count($keys), $key));
        }

        $this->assertEquals([ 0, 'a', 0.0 ], $php->mapval($map));
    }

    public function testMapvals()
    {
        $php = $this->getPhp();

        $map = [];
        $keys = [ null, 0, 0.0, '', 'a' ];
        foreach ( $keys as $key ) {
            $map[] = array_combine($keys, array_fill(0, count($keys), $key));
        }

        $this->assertEquals([
            [ 0, 'a', 0.0 ],
            [ 0, 'a', 0.0 ],
        ], $php->mapvals($map, $map));
    }
}
