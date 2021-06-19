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


    public function testBcround()
    {
        $math = $this->getMath();

        $this->assertEquals(1, $math->bcround(0.5));
        $this->assertEquals(0, $math->bcround(0.01));
        $this->assertEquals(-1, $math->bcround(-0.5));
        $this->assertEquals(0, $math->bcround(-0.01));
    }

    public function testBcfloor()
    {
        $math = $this->getMath();

        $this->assertEquals(1, $math->bcfloor(1.5));
        $this->assertEquals(0, $math->bcfloor(0.01));
        $this->assertEquals(-2, $math->bcfloor(-1.5));
        $this->assertEquals(-1, $math->bcfloor(-0.01));
    }

    public function testBcceil()
    {
        $math = $this->getMath();

        $this->assertEquals(2, $math->bcceil(1.5));
        $this->assertEquals(1, $math->bcceil(0.01));
        $this->assertEquals(-1, $math->bcceil(-1.5));
        $this->assertEquals(0, $math->bcceil(-0.01));
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

        $this->assertEquals('0.10', $math->bcmin($values));
    }


    public function testBcsum()
    {
        $math = $this->getMath();

        $values = [];
        $values[] = '0.333333333333333333333';
        $values[] = '0.333333333333333333333';
        $values[] = '0.333333333333333333333';

        $this->assertEquals('0.999999999999999999999', $math->bcsum($values));
    }

    public function testBcavg()
    {
        $math = $this->getMath();

        $values = [];
        $values[] = '0.333333333333333333333';
        $values[] = '0.333333333333333333333';
        $values[] = '0.333333333333333333333';

        $this->assertEquals('0.333333333333333333333', $math->bcavg($values));
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

        $this->assertEquals(1, $math->bcmoneyfloor(1.5));
        $this->assertEquals(0, $math->bcmoneyfloor(0.01));
        $this->assertEquals(-1, $math->bcmoneyfloor(-1.5));
        $this->assertEquals(0, $math->bcmoneyfloor(-0.01));

        $this->assertEquals(1.5, $math->bcmoneyfloor(1.5, 1));
        $this->assertEquals(0, $math->bcmoneyfloor(0.01, 1));
        $this->assertEquals(-1.5, $math->bcmoneyfloor(-1.5, 1));
        $this->assertEquals(0, $math->bcmoneyfloor(-0.01, 1));
    }

    public function testBcmoneyceil()
    {
        $math = $this->getMath();

        $this->assertEquals(2, $math->bcmoneyceil(1.5));
        $this->assertEquals(1, $math->bcmoneyceil(0.01));
        $this->assertEquals(-2, $math->bcmoneyceil(-1.5));
        $this->assertEquals(-1, $math->bcmoneyceil(-0.01));

        $this->assertEquals(1.5, $math->bcmoneyceil(1.5, 1));
        $this->assertEquals(0.1, $math->bcmoneyceil(0.01, 1));
        $this->assertEquals(-1.5, $math->bcmoneyceil(-1.5, 1));
        $this->assertEquals(-0.1, $math->bcmoneyceil(-0.01, 1));
    }
}
