<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Preg;
use Gzhegow\Support\Type;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

class PregTest extends AbstractTestCase
{
    public function testNew()
    {
        $preg = new Preg(new Type());

        $this->assertEquals('//', $preg->new(''));
        $this->assertEquals('//', $preg->new([ '' ]));
        $this->assertEquals('//', $preg->new([ [ '' ] ]));
        $this->assertEquals('/\//', $preg->new([ [ '/' ] ]));
        $this->assertEquals('/hello(world)+/', $preg->new([ 'hello(', [ 'world' ], ')+' ]));
    }

    public function testCurry()
    {
        $preg = new Preg(new Type());

        $this->assertEquals('//', $preg->curry()('')());
        $this->assertEquals('//', $preg->curry()([ '' ])());
        $this->assertEquals('/\//', $preg->curry()([ '/' ])());
        $this->assertEquals('/hello(world)+/', $preg->curry()([ 'hello' ])('(')([ 'world' ])(')+')());
    }


    public function testBadNew0_()
    {
        $this->expectException(InvalidArgumentException::class);

        $preg = new Preg(new Type());

        /** @noinspection PhpParamsInspection */
        $preg->new([ [ [ '' ] ] ]); // max input level depth is only 2, 1st means nothing, 2st means "escape me"
    }

    public function testBadNew1_()
    {
        $this->expectException(InvalidArgumentException::class);

        $preg = new Preg(new Type());

        $preg->new('/'); // without escaping this collides with enclosure
    }

    public function testBadNew2_()
    {
        $this->expectException(InvalidArgumentException::class);

        $preg = new Preg(new Type());

        $preg->new([ '/' ]); // each input first of all will be mapped to array, so it becomes "/"
    }

    public function testBadNew3_()
    {
        $this->expectException(InvalidArgumentException::class);

        $preg = new Preg(new Type());

        // currently we don't support formatted regex passed to regex builder
        // you should pass ->new('hello', 'iu')
        $preg->new([ '/hello/iu' ]);
    }
}
