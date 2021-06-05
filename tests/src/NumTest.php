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


    public function testTheIntvals()
    {
        $num = $this->getNum();

        $this->assertEquals([ 1 ], $num->theIntvals(1));
        $this->assertEquals([ 1 ], $num->theIntvals(1.0));
        $this->assertEquals([ '1' ], $num->theIntvals('1'));
        $this->assertEquals([ '1.0' ], $num->theIntvals('1.0'));
        $this->assertEquals([], $num->theIntvals([]));

        $this->assertEquals([ 1 ], $num->theIntvals([ 1 ]));
        $this->assertEquals([ 1 ], $num->theIntvals([ 1.0 ]));
        $this->assertEquals([ '1' ], $num->theIntvals([ '1' ]));
        $this->assertEquals([ '1.0' ], $num->theIntvals([ '1.0' ]));
        $this->assertEquals([], $num->theIntvals([ [] ]));

        $this->assertEquals([ '1' ], $num->theIntvals([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $num->theIntvals([ [ 1.0 ] ]));
        $this->assertEquals([ '1' ], $num->theIntvals([ [ '1' ] ]));
        $this->assertEquals([ '1.0' ], $num->theIntvals([ [ '1.0' ] ]));
        $this->assertEquals([], $num->theIntvals([ [ [] ] ]));
    }

    public function testTheIntvalsBad()
    {
        $num = $this->getNum();

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals('');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals('hello');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ '' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ 'hello' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ [ '' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ [ 'hello' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theIntvals([ [ new \StdClass() ] ]);
        });
    }


    public function testTheFloatvals()
    {
        $num = $this->getNum();

        $this->assertEquals([ 1 ], $num->theFloatvals(1));
        $this->assertEquals([ 1 ], $num->theFloatvals(1.0));
        $this->assertEquals([ 1.1 ], $num->theFloatvals(1.1));
        $this->assertEquals([ '1' ], $num->theFloatvals('1'));
        $this->assertEquals([ '1.0' ], $num->theFloatvals('1.0'));
        $this->assertEquals([ '1.1' ], $num->theFloatvals('1.1'));
        $this->assertEquals([], $num->theFloatvals([]));

        $this->assertEquals([ 1 ], $num->theFloatvals([ 1 ]));
        $this->assertEquals([ 1 ], $num->theFloatvals([ 1.0 ]));
        $this->assertEquals([ 1.1 ], $num->theFloatvals([ 1.1 ]));
        $this->assertEquals([ '1' ], $num->theFloatvals([ '1' ]));
        $this->assertEquals([ '1.0' ], $num->theFloatvals([ '1.0' ]));
        $this->assertEquals([ '1.1' ], $num->theFloatvals([ '1.1' ]));
        $this->assertEquals([], $num->theFloatvals([ [] ]));

        $this->assertEquals([ '1' ], $num->theFloatvals([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $num->theFloatvals([ [ 1.0 ] ]));
        $this->assertEquals([ '1.1' ], $num->theFloatvals([ [ 1.1 ] ]));
        $this->assertEquals([ '1' ], $num->theFloatvals([ [ '1' ] ]));
        $this->assertEquals([ '1.0' ], $num->theFloatvals([ [ '1.0' ] ]));
        $this->assertEquals([ '1.1' ], $num->theFloatvals([ [ '1.1' ] ]));
        $this->assertEquals([], $num->theFloatvals([ [ [] ] ]));
    }

    public function testTheFloatvalsBad()
    {
        $num = $this->getNum();

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals('');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals('hello');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ '' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ 'hello' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ [ '' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ [ 'hello' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theFloatvals([ [ new \StdClass() ] ]);
        });
    }


    public function testTheNumvals()
    {
        $num = $this->getNum();

        $this->assertEquals([ 1 ], $num->theNumvals(1));
        $this->assertEquals([ 1 ], $num->theNumvals(1.0));
        $this->assertEquals([ 1.1 ], $num->theNumvals(1.1));
        $this->assertEquals([ '1' ], $num->theNumvals('1'));
        $this->assertEquals([ '1.0' ], $num->theNumvals('1.0'));
        $this->assertEquals([ '1.1' ], $num->theNumvals('1.1'));
        $this->assertEquals([], $num->theNumvals([]));

        $this->assertEquals([ 1 ], $num->theNumvals([ 1 ]));
        $this->assertEquals([ 1 ], $num->theNumvals([ 1.0 ]));
        $this->assertEquals([ 1.1 ], $num->theNumvals([ 1.1 ]));
        $this->assertEquals([ '1' ], $num->theNumvals([ '1' ]));
        $this->assertEquals([ '1.0' ], $num->theNumvals([ '1.0' ]));
        $this->assertEquals([ '1.1' ], $num->theNumvals([ '1.1' ]));
        $this->assertEquals([], $num->theNumvals([ [] ]));

        $this->assertEquals([ '1' ], $num->theNumvals([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $num->theNumvals([ [ 1.0 ] ]));
        $this->assertEquals([ '1.1' ], $num->theNumvals([ [ 1.1 ] ]));
        $this->assertEquals([ '1' ], $num->theNumvals([ [ '1' ] ]));
        $this->assertEquals([ '1.0' ], $num->theNumvals([ [ '1.0' ] ]));
        $this->assertEquals([ '1.1' ], $num->theNumvals([ [ '1.1' ] ]));
        $this->assertEquals([], $num->theNumvals([ [ [] ] ]));
    }

    public function testTheNumvalsBad()
    {
        $num = $this->getNum();

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals('');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals('hello');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ '' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ 'hello' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ [ '' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ [ 'hello' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumvals([ [ new \StdClass() ] ]);
        });
    }
}
