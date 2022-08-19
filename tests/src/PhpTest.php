<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XPhp;
use Gzhegow\Support\IPhp;


class PhpTest extends AbstractTestCase
{
    protected function getPhp() : IPhp
    {
        return XPhp::getInstance();
    }


    public function testKwargs()
    {
        $php = $this->getPhp();

        $array = [ 1, 2, 3, 'hello' => 'world', 'foo' => 'bar' ];
        $this->assertEquals([ [ 'hello' => 'world', 'foo' => 'bar' ], [ 1, 2, 3 ] ], $php->kwargs($array));

        $array = [ 1 => 1, 2 => 2, 3 => 3, 'hello' => 'world', 'foo' => 'bar' ];
        $this->assertEquals([ [ 'hello' => 'world', 'foo' => 'bar' ], [ 0 => 1, 1 => 2, 2 => 3 ] ], $php->kwargs($array));
    }

    public function testKwargsPreserveKeys()
    {
        $php = $this->getPhp();

        $array = [ 1, 2, 3, 'hello' => 'world', 'foo' => 'bar' ];
        $this->assertEquals([ [ 'hello' => 'world', 'foo' => 'bar' ], [ 1, 2, 3 ] ], $php->kwargsPreserveKeys($array));

        $array = [ 1 => 1, 2 => 2, 3 => 3, 'hello' => 'world', 'foo' => 'bar' ];
        $this->assertEquals([ [ 'hello' => 'world', 'foo' => 'bar' ], [ 1 => 1, 2 => 2, 3 => 3 ] ], $php->kwargsPreserveKeys($array));
    }
}