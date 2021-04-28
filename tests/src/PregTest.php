<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Preg;
use Gzhegow\Support\Type;
use Gzhegow\Support\Exceptions\RuntimeException;

class PregTest extends AbstractTestCase
{
    protected function getType() : Type
    {
        return new Type();
    }

    protected function getPreg() : Preg
    {
        return new Preg(
            $this->getType()
        );
    }


    public function testNew()
    {
        $preg = $this->getPreg();

        $this->assertEquals('//', $preg->concat(''));
        $this->assertEquals('//', $preg->concat([ '' ]));
        $this->assertEquals('/\//', $preg->concat([ '/' ]));
        $this->assertEquals('/hello(world)+/', $preg->concat('hello(', [ 'world' ], ')+'));
    }


    public function testBadNew1_()
    {
        $this->expectException(RuntimeException::class);

        $preg = $this->getPreg();

        $preg->concat('/'); // without escaping this collides with enclosure
    }

    public function testBadNew2_()
    {
        $this->expectException(RuntimeException::class);

        $preg = $this->getPreg();

        $preg->concat('/'); // each input first of all will be mapped to array, so it becomes "/"
    }

    public function testBadNew3_()
    {
        $this->expectException(RuntimeException::class);

        $preg = $this->getPreg();

        // currently we don't support formatted regex passed to regex builder
        // you should pass ->new('hello', 'iu')
        $preg->concat('/hello/iu');
    }
}
