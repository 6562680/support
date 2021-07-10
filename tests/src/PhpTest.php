<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Php;
use Gzhegow\Support\IPhp;


class PhpTest extends AbstractTestCase
{
    protected function getPhp() : IPhp
    {
        return Php::me();
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


    public function testSequence()
    {
        $php = $this->getPhp();

        $this->assertEquals([
            [ 1, 3 ],
            [ 2, 3 ],
        ], $php->sequence([ 1, 2 ], [ 3 ]));
    }

    public function testSequenceFlatten()
    {
        $php = $this->getPhp();

        $this->assertEquals([
            [ 1, 1 ],
            [ 1, 2 ],
            [ 2, 1 ],
            [ 2, 2 ],
        ], $php->sequenceFlatten(1, 2));
    }


    public function testBitmask()
    {
        $php = $this->getPhp();

        $this->assertEquals([
            '00' => [ null, null ],
            '01' => [ null, 2 ],
            '10' => [ 1, null ],
            '11' => [ 1, 2 ],
        ], $php->bitmask([ 1, 2 ]));

        $this->assertCount(8, $php->bitmask([ 1, 2, 3 ]));
        $this->assertCount(16, $php->bitmask([ 1, 2, 3, 4 ]));
    }
}
