<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ZPreg;
use Gzhegow\Support\IPreg;
use Gzhegow\Support\Exceptions\RuntimeException;


class PregTest extends AbstractTestCase
{
    protected function getPreg() : IPreg
    {
        return ZPreg::getInstance();
    }


    public function testNew()
    {
        $preg = $this->getPreg();

        $this->assertEquals('//', $preg->concat(''));
        $this->assertEquals('//', $preg->concat([ '' ]));
        $this->assertEquals('/\//', $preg->concat([ '/' ]));
        $this->assertEquals('/hello(world)+/', $preg->concat('hello(', [ 'world' ], ')+'));
        $this->assertEquals('/foohelloworld/iu', $preg->concat('foo', '/hello/iu', 'world'));
    }

    public function testBadNew()
    {
        $preg = $this->getPreg();

        $this->assertException(RuntimeException::class, function () use ($preg) {
            $preg->concat('/'); // without escaping this collides with delimiter
        });
    }
}
