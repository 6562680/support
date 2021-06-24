<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Php;
use Gzhegow\Support\Domain\SupportFactory;


class PhpTest extends AbstractTestCase
{
    protected function getPhp() : Php
    {
        return ( new SupportFactory() )->newPhp();
    }


    public function testEnumval()
    {
        $php = $this->getPhp();

        $map = [];
        $keys = [ null, 0, 0.0, '', 'a' ];
        foreach ( $keys as $key ) {
            $map[] = array_combine($keys, array_fill(0, count($keys), $key));
        }

        $this->assertEquals([ 0, 'a', 0.0 ], $php->enumval($map));
    }

    public function testEnumvals()
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
        ], $php->enumvals($map, $map));
    }


    public function testListval()
    {
        $php = $this->getPhp();

        $this->assertEquals([], $php->listval(null));
        $this->assertEquals([], $php->listval(null, null));
        $this->assertEquals([], $php->listval([ null ]));
        $this->assertEquals([], $php->listval([ null, null ]));
        $this->assertEquals([ [ null ] ], $php->listval([ null, [ null ] ]));

        $this->assertEquals([ [ 'a' => null ] ], $php->listval([ 'a' => null ]));
        $this->assertEquals([ [ 'a' => null ], [ 'a' => null ] ], $php->listval([ 'a' => null ], [ 'a' => null ]));
        $this->assertEquals([ [ 'a' => null ], [ 'a' => null ] ], $php->listval([ [ 'a' => null ], [ 'a' => null ] ]));

        $this->assertEquals([ 1 ], $php->listval(1));
        $this->assertEquals([ 1, 1 ], $php->listval(1, 1));
        $this->assertEquals([ 1 ], $php->listval([ 1 ]));
        $this->assertEquals([ 1, 1 ], $php->listval([ 1, 1 ]));
        $this->assertEquals([ 1, [ 1 ] ], $php->listval([ 1, [ 1 ] ]));
    }
}
