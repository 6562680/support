<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Num;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class NumTest extends AbstractTestCase
{
    protected function getNum() : Num
    {
        return ( new SupportFactory() )->newNum();
    }


    public function testNumvals()
    {
        $num = $this->getNum();

        $this->assertEquals([ 1 ], $num->numvals(1));
        $this->assertEquals([ 1 ], $num->numvals(1.0));
        $this->assertEquals([ 1.1 ], $num->numvals(1.1));
        $this->assertEquals([ '1' ], $num->numvals('1'));
        $this->assertEquals([ '1.0' ], $num->numvals('1.0'));
        $this->assertEquals([ '1.1' ], $num->numvals('1.1'));
        $this->assertEquals([], $num->numvals([]));

        $this->assertEquals([ 1 ], $num->numvals([ 1 ]));
        $this->assertEquals([ 1 ], $num->numvals([ 1.0 ]));
        $this->assertEquals([ 1.1 ], $num->numvals([ 1.1 ]));
        $this->assertEquals([ '1' ], $num->numvals([ '1' ]));
        $this->assertEquals([ '1.0' ], $num->numvals([ '1.0' ]));
        $this->assertEquals([ '1.1' ], $num->numvals([ '1.1' ]));
        $this->assertEquals([], $num->numvals([ [] ]));

        $this->assertEquals([ '1' ], $num->numvals([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $num->numvals([ [ 1.0 ] ]));
        $this->assertEquals([ '1.1' ], $num->numvals([ [ 1.1 ] ]));
        $this->assertEquals([ '1' ], $num->numvals([ [ '1' ] ]));
        $this->assertEquals([ '1.0' ], $num->numvals([ [ '1.0' ] ]));
        $this->assertEquals([ '1.1' ], $num->numvals([ [ '1.1' ] ]));
        $this->assertEquals([], $num->numvals([ [ [] ] ]));
    }

    public function testNumvalsBad()
    {
        $num = $this->getNum();

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals('');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals('hello');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ '' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ 'hello' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ [ '' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ [ 'hello' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->numvals([ [ new \StdClass() ] ]);
        });
    }
}
