<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XNum;
use Gzhegow\Support\INum;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class NumTest extends AbstractTestCase
{
    protected function getNum() : INum
    {
        return XNum::getInstance();
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
        $this->assertEquals([], $num->theIntvals([ [] ], null, true));

        $this->assertEquals([ '1' ], $num->theIntvals([ [ 1 ] ], null, true));
        $this->assertEquals([ '1' ], $num->theIntvals([ [ 1.0 ] ], null, true));
        $this->assertEquals([ '1' ], $num->theIntvals([ [ '1' ] ], null, true));
        $this->assertEquals([ '1.0' ], $num->theIntvals([ [ '1.0' ] ], null, true));
        $this->assertEquals([], $num->theIntvals([ [ [] ] ], null, true));
    }

    public function testBadTheIntvals()
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
        $this->assertEquals([], $num->theFloatvals([ [] ], null, true));

        $this->assertEquals([ '1' ], $num->theFloatvals([ [ 1 ] ], null, true));
        $this->assertEquals([ '1' ], $num->theFloatvals([ [ 1.0 ] ], null, true));
        $this->assertEquals([ '1.1' ], $num->theFloatvals([ [ 1.1 ] ], null, true));
        $this->assertEquals([ '1' ], $num->theFloatvals([ [ '1' ] ], null, true));
        $this->assertEquals([ '1.0' ], $num->theFloatvals([ [ '1.0' ] ], null, true));
        $this->assertEquals([ '1.1' ], $num->theFloatvals([ [ '1.1' ] ], null, true));
        $this->assertEquals([], $num->theFloatvals([ [ [] ] ], null, true));
    }

    public function testBadTheFloatvals()
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

        $this->assertEquals([ 1 ], $num->theNumericvals(1));
        $this->assertEquals([ 1 ], $num->theNumericvals(1.0));
        $this->assertEquals([ 1.1 ], $num->theNumericvals(1.1));
        $this->assertEquals([ '1' ], $num->theNumericvals('1'));
        $this->assertEquals([ '1.0' ], $num->theNumericvals('1.0'));
        $this->assertEquals([ '1.1' ], $num->theNumericvals('1.1'));
        $this->assertEquals([], $num->theNumericvals([]));

        $this->assertEquals([ 1 ], $num->theNumericvals([ 1 ]));
        $this->assertEquals([ 1 ], $num->theNumericvals([ 1.0 ]));
        $this->assertEquals([ 1.1 ], $num->theNumericvals([ 1.1 ]));
        $this->assertEquals([ '1' ], $num->theNumericvals([ '1' ]));
        $this->assertEquals([ '1.0' ], $num->theNumericvals([ '1.0' ]));
        $this->assertEquals([ '1.1' ], $num->theNumericvals([ '1.1' ]));
        $this->assertEquals([], $num->theNumericvals([ [] ], null, true));

        $this->assertEquals([ '1' ], $num->theNumericvals([ [ 1 ] ], null, true));
        $this->assertEquals([ '1' ], $num->theNumericvals([ [ 1.0 ] ], null, true));
        $this->assertEquals([ '1.1' ], $num->theNumericvals([ [ 1.1 ] ], null, true));
        $this->assertEquals([ '1' ], $num->theNumericvals([ [ '1' ] ], null, true));
        $this->assertEquals([ '1.0' ], $num->theNumericvals([ [ '1.0' ] ], null, true));
        $this->assertEquals([ '1.1' ], $num->theNumericvals([ [ '1.1' ] ], null, true));
        $this->assertEquals([], $num->theNumericvals([ [ [] ] ], null, true));
    }

    public function testBadTheNumvals()
    {
        $num = $this->getNum();

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals('');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals('hello');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ '' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ 'hello' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ [ '' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ [ 'hello' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($num) {
            $num->theNumericvals([ [ new \StdClass() ] ]);
        });
    }
}