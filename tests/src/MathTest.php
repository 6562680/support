<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Math;
use Gzhegow\Support\Domain\SupportFactory;


class MathTest extends AbstractTestCase
{
    protected function getMath() : Math
    {
        return ( new SupportFactory() )->newMath();
    }


    public function testBcval()
    {
        $math = $this->getMath();

        $this->assertEquals('0', $math->bcval(0));

        $this->assertEquals('0', $math->bcval(0e5));
        $this->assertEquals('0', $math->bcval(0e+5));
        $this->assertEquals('0', $math->bcval(0e-5));
        $this->assertEquals('0', $math->bcval(0E5));
        $this->assertEquals('0', $math->bcval(0E+5));
        $this->assertEquals('0', $math->bcval(0E-5));

        $this->assertEquals('0', $math->bcval(0.0));
        $this->assertEquals('0', $math->bcval(0.0e5));
        $this->assertEquals('0', $math->bcval(0.0e+5));
        $this->assertEquals('0', $math->bcval(0.0e-5));
        $this->assertEquals('0', $math->bcval(0.0E5));
        $this->assertEquals('0', $math->bcval(0.0E+5));
        $this->assertEquals('0', $math->bcval(0.0E-5));

        $this->assertEquals('0.1', $math->bcval(.1));
        $this->assertEquals('10000', $math->bcval(.1e5));
        $this->assertEquals('10000000000000', $math->bcval(.1e14));
        $this->assertEquals('0.000001', $math->bcval(.1e-5));

        $this->assertEquals('0.1', $math->bcval(0.1));
        $this->assertEquals('10000', $math->bcval(0.1e5));
        $this->assertEquals('10000000000000', $math->bcval(0.1e14));
        $this->assertEquals('0.000001', $math->bcval(0.1e-5));

        $this->assertEquals('0.01', $math->bcval(0.01));
        $this->assertEquals('1000', $math->bcval(0.01e5));
        $this->assertEquals('1000000000000', $math->bcval(0.01e14));
        $this->assertEquals('0.0000001', $math->bcval(0.01e-5));

        $this->assertEquals('1', $math->bcval(1));
        $this->assertEquals('100000', $math->bcval(1e5));
        $this->assertEquals('100000000000000', $math->bcval(1e14));
        $this->assertEquals('0.00001', $math->bcval(1e-5));

        $this->assertEquals('1', $math->bcval(1.0));
        $this->assertEquals('100000', $math->bcval(1.0e5));
        $this->assertEquals('100000000000000', $math->bcval(1.0e14));
        $this->assertEquals('0.00001', $math->bcval(1.0e-5));

        $this->assertEquals('1.1', $math->bcval(1.1));
        $this->assertEquals('110000', $math->bcval(1.1e5));
        $this->assertEquals('110000000000000', $math->bcval(1.1e14));
        $this->assertEquals('0.000011', $math->bcval(1.1e-5));

        $this->assertEquals('1.01', $math->bcval(1.01));
        $this->assertEquals('101000', $math->bcval(1.01e5));
        $this->assertEquals('101000000000000', $math->bcval(1.01e14));
        $this->assertEquals('0.0000101', $math->bcval(1.01e-5));

        $this->assertEquals('10.01', $math->bcval(10.01));
        $this->assertEquals('1001000', $math->bcval(10.01e5));
        $this->assertEquals('1001000000000000', $math->bcval(10.01e14));
        $this->assertEquals('0.0001001', $math->bcval(10.01e-5));

        $this->assertEquals('0', $math->bcval('0'));

        $this->assertEquals('0', $math->bcval('0e5'));
        $this->assertEquals('0', $math->bcval('0e+5'));
        $this->assertEquals('0', $math->bcval('0e-5'));
        $this->assertEquals('0', $math->bcval('0E5'));
        $this->assertEquals('0', $math->bcval('0E+5'));
        $this->assertEquals('0', $math->bcval('0E-5'));

        $this->assertEquals('0', $math->bcval('0.0'));
        $this->assertEquals('0', $math->bcval('0.0e5'));
        $this->assertEquals('0', $math->bcval('0.0e+5'));
        $this->assertEquals('0', $math->bcval('0.0e-5'));
        $this->assertEquals('0', $math->bcval('0.0E5'));
        $this->assertEquals('0', $math->bcval('0.0E+5'));
        $this->assertEquals('0', $math->bcval('0.0E-5'));

        $this->assertEquals('0.1', $math->bcval('.1'));
        $this->assertEquals('10000', $math->bcval('.1e5')); // error
        $this->assertEquals('10000000000000', $math->bcval('.1e14')); // error
        $this->assertEquals('0.000001', $math->bcval('.1e-5')); // error

        $this->assertEquals('0.1', $math->bcval('0.1'));
        $this->assertEquals('10000', $math->bcval('0.1e5'));
        $this->assertEquals('10000000000000', $math->bcval('0.1e14'));
        $this->assertEquals('0.000001', $math->bcval('0.1e-5'));

        $this->assertEquals('0.01', $math->bcval('0.01'));
        $this->assertEquals('1000', $math->bcval('0.01e5'));
        $this->assertEquals('1000000000000', $math->bcval('0.01e14'));
        $this->assertEquals('0.0000001', $math->bcval('0.01e-5'));

        $this->assertEquals('1', $math->bcval('1'));
        $this->assertEquals('100000', $math->bcval('1e5'));
        $this->assertEquals('100000000000000', $math->bcval('1e14'));
        $this->assertEquals('0.00001', $math->bcval('1e-5'));

        $this->assertEquals('1', $math->bcval('1.0'));
        $this->assertEquals('100000', $math->bcval('1.0e5'));
        $this->assertEquals('100000000000000', $math->bcval('1.0e14'));
        $this->assertEquals('0.00001', $math->bcval('1.0e-5'));

        $this->assertEquals('1.1', $math->bcval('1.1'));
        $this->assertEquals('110000', $math->bcval('1.1e5'));
        $this->assertEquals('110000000000000', $math->bcval('1.1e14'));
        $this->assertEquals('0.000011', $math->bcval('1.1e-5'));

        $this->assertEquals('1.01', $math->bcval('1.01'));
        $this->assertEquals('101000', $math->bcval('1.01e5'));
        $this->assertEquals('101000000000000', $math->bcval('1.01e14'));
        $this->assertEquals('0.0000101', $math->bcval('1.01e-5'));

        $this->assertEquals('10.01', $math->bcval('10.01'));
        $this->assertEquals('1001000', $math->bcval('10.01e5'));
        $this->assertEquals('1001000000000000', $math->bcval('10.01e14'));
        $this->assertEquals('0.0001001', $math->bcval('10.01e-5')); // error
    }


    public function testRound()
    {
        $math = $this->getMath();

        $this->assertEquals(1, $math->round(0.5));
        $this->assertEquals(0, $math->round(0.01));
        $this->assertEquals(-1, $math->round(-0.5));
        $this->assertEquals(0, $math->round(-0.01));
    }

    public function testFloor()
    {
        $math = $this->getMath();

        $this->assertEquals(1, $math->floor(1.5));
        $this->assertEquals(0, $math->floor(0.01));
        $this->assertEquals(-2, $math->floor(-1.5));
        $this->assertEquals(-1, $math->floor(-0.01));
    }

    public function testCeil()
    {
        $math = $this->getMath();

        $this->assertEquals(2, $math->ceil(1.5));
        $this->assertEquals(1, $math->ceil(0.01));
        $this->assertEquals(-1, $math->ceil(-1.5));
        $this->assertEquals(0, $math->ceil(-0.01));
    }


    public function testRates()
    {
        $math = $this->getMath();

        $this->assertEquals([ 1 ], $math->rates(1));
        $this->assertEquals([ 0.25, 0.5, 0.25 ], $math->rates([ 1, 2, 1 ]));
        $this->assertEquals([ 0.25, 0.5, 0.25 ], $math->rates([ 2, 4, 2 ]));
        $this->assertEquals([ 0.25, 0.5, 0.25, 0 ], $math->rates([ 2, 4, 2, 0 ]));
    }

    public function testRatesZero()
    {
        $math = $this->getMath();

        $this->assertEquals([ 1 ], $math->ratesZero(1));
        $this->assertEquals([ 0.25, 0.5, 0.25 ], $math->ratesZero([ 1, 2, 1 ]));
        $this->assertEquals([ 0.25, 0.5, 0.25 ], $math->ratesZero([ 2, 4, 2 ]));

        $this->assertEquals([
            0.20833333333333334,
            0.4166666666666667,
            0.20833333333333334,

            0.16666666666666663,
        ], $math->ratesZero([ 2, 4, 2, 0 ]));

        $this->assertEquals([
            0.20833333333333334,
            0.4166666666666667,
            0.20833333333333334,

            0.08333333333333331,
            0.08333333333333331,
        ], $math->ratesZero([ 2, 4, 2, 0, 0 ]));
    }


    public function testBalance()
    {
        $math = $this->getMath();

        $this->assertEquals([ 15, 30, 20 ], $math->balance(65, [ 5, 10, 50 ], [ 2 => 20 ]));
    }


    public function testBcround()
    {
        $math = $this->getMath();

        $this->assertEquals(1, strval($math->bcround(0.5)));
        $this->assertEquals(0, strval($math->bcround(0.01)));
        $this->assertEquals(-1, strval($math->bcround(-0.5)));
        $this->assertEquals(0, strval($math->bcround(-0.01)));
    }

    public function testBcfloor()
    {
        $math = $this->getMath();

        $this->assertEquals(1, strval($math->bcfloor(1.5)));
        $this->assertEquals(0, strval($math->bcfloor(0.01)));
        $this->assertEquals(-2, strval($math->bcfloor(-1.5)));
        $this->assertEquals(-1, strval($math->bcfloor(-0.01)));
    }

    public function testBcceil()
    {
        $math = $this->getMath();

        $this->assertEquals(2, strval($math->bcceil(1.5)));
        $this->assertEquals(1, strval($math->bcceil(0.01)));
        $this->assertEquals(-1, strval($math->bcceil(-1.5)));
        $this->assertEquals(0, strval($math->bcceil(-0.01)));
    }


    public function testBcmax()
    {
        $math = $this->getMath();

        $values = [];
        $values[] = '10.1';
        $values[] = '100';
        $values[] = '0.10';

        $this->assertEquals('100', $math->bcmax($values));
    }

    public function testBcmin()
    {
        $math = $this->getMath();

        $values = [];
        $values[] = '10.1';
        $values[] = '100';
        $values[] = '0.10';

        $this->assertEquals('0.1', $math->bcmin($values));
    }


    public function testBcsum()
    {
        $math = $this->getMath();

        $values = [];
        $values[] = '0.33333333333333333333';
        $values[] = '0.33333333333333333333';
        $values[] = '0.33333333333333333333';

        $this->assertEquals('0.99999999999999999999', $math->bcsum($values));
    }

    public function testBcavg()
    {
        $math = $this->getMath();

        $values = [];
        $values[] = '0.33333333333333333333';
        $values[] = '0.33333333333333333333';
        $values[] = '0.33333333333333333333';

        $this->assertEquals('0.33333333333333333333', $math->bcavg($values, 20));
    }

    public function testBcmedian()
    {
        $math = $this->getMath();

        $values = [];
        $values[] = '0.666666666666666666666';
        $values[] = '0.444444444444444444444';
        $values[] = '0.555555555555555555555';

        $this->assertEquals('0.555555555555555555555', $math->bcmedian($values));
    }


    public function testBcratio()
    {
        $math = $this->getMath();

        $this->assertEquals('0.01', $math->bcratio('1', '100', 2));
        $this->assertEquals('1.01', $math->bcratio('101', '100', 2));
    }

    public function testBcpercent()
    {
        $math = $this->getMath();

        $this->assertEquals('2', $math->bcpercent('1', '50', 2));
        $this->assertEquals('202', $math->bcpercent('101', '50', 2));
    }


    public function testBcrand()
    {
        $math = $this->getMath();

        $values = [];
        $values[] = '0.666666666666666666666';
        $values[] = '0.444444444444444444444';
        $values[] = '0.555555555555555555555';

        $this->assertEquals('0.555555555555555555555', $math->bcmedian($values));
    }


    public function testBcmoneyfloor()
    {
        $math = $this->getMath();

        $this->assertEquals(1, strval($math->bcmoneyfloor(1.5)));
        $this->assertEquals(0, strval($math->bcmoneyfloor(0.01)));
        $this->assertEquals(-1, strval($math->bcmoneyfloor(-1.5)));
        $this->assertEquals(0, strval($math->bcmoneyfloor(-0.01)));

        $this->assertEquals(1.5, strval($math->bcmoneyfloor(1.5, 1)));
        $this->assertEquals(0, strval($math->bcmoneyfloor(0.01, 1)));
        $this->assertEquals(-1.5, strval($math->bcmoneyfloor(-1.5, 1)));
        $this->assertEquals(0, strval($math->bcmoneyfloor(-0.01, 1)));
    }

    public function testBcmoneyceil()
    {
        $math = $this->getMath();

        $this->assertEquals(2, strval($math->bcmoneyceil(1.5)));
        $this->assertEquals(1, strval($math->bcmoneyceil(0.01)));
        $this->assertEquals(-2, strval($math->bcmoneyceil(-1.5)));
        $this->assertEquals(-1, strval($math->bcmoneyceil(-0.01)));

        $this->assertEquals(1.5, strval($math->bcmoneyceil(1.5, 1)));
        $this->assertEquals(0.1, strval($math->bcmoneyceil(0.01, 1)));
        $this->assertEquals(-1.5, strval($math->bcmoneyceil(-1.5, 1)));
        $this->assertEquals(-0.1, strval($math->bcmoneyceil(-0.01, 1)));
    }

    public function testBcmoneyshare()
    {
        $math = $this->getMath();

        $this->assertEquals([ '1', '2', '1' ], $math->bcmoneyshare(4, [ 1, 2, 1 ], 0));
        $this->assertEquals([ '25', '25', '25', '25' ], $math->bcmoneyshare(100, [ 1, 1, 1, 1 ], 0));
        $this->assertEquals([ '40', '20', '20', '20' ], $math->bcmoneyshare(100, [ 2, 1, 1, 1 ], 0));

        $this->assertEquals([ '34', '33', '33' ], $math->bcmoneyshare(100, [ 1, 1, 1 ], 0));
        $this->assertEquals([ '33.34', '33.33', '33.33' ], $math->bcmoneyshare(100, [ 1, 1, 1 ], 2));
    }
}
