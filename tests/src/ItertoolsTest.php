<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XItertools;
use Gzhegow\Support\IItertools;


class ItertoolsTest extends AbstractTestCase
{
    protected function getItertools() : IItertools
    {
        return XItertools::getInstance();
    }


    public function testRange()
    {
        $itertools = $this->getItertools();


        $result = [];
        foreach ( $itertools->range(2) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([ 0, 1 ], $result);


        $result = [];
        foreach ( $itertools->range(0, 2) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([ 0, 1 ], $result);


        $result = [];
        foreach ( $itertools->range(2, 0, -1) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([ 2, 1 ], $result);


        $result = [];
        foreach ( $itertools->range(2, 0, -1, true) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([ 2, 1, 0 ], $result);
    }


    public function testReverse()
    {
        $itertools = $this->getItertools();


        $result = [];
        foreach ( $itertools->reversed($itertools->range(2)) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([ 1, 0 ], $result);
    }


    public function testWalk()
    {
        $itertools = $this->getItertools();


        $result = [];
        foreach ( $itertools->walkeach([ 1, [ 2, [ 3, [ 4 ] ] ] ]) as $path => $seq ) {
            $result[] = [ $path, $seq ];
        }

        $this->assertEquals([
            [ [ 0 ], 1 ],
            [ [ 1, 0 ], 2 ],
            [ [ 1, 1, 0 ], 3 ],
            [ [ 1, 1, 1, 0 ], 4 ],
        ], $result);


        $result = [];
        foreach ( $itertools->walkeach([ 1, [ 2, [ 3, [ 4 ] ] ] ], $continue, null, true) as $path => $seq ) {
            $result[] = [ $path, $seq ];
        }

        $this->assertEquals([
            [ [ 0 ], 1 ],
            [ [ 1 ], [ 2, [ 3, [ 4 ] ] ] ],
            [ [ 1, 0 ], 2 ],
            [ [ 1, 1 ], [ 3, [ 4 ] ] ],
            [ [ 1, 1, 0 ], 3 ],
            [ [ 1, 1, 1 ], [ 4 ] ],
            [ [ 1, 1, 1, 0 ], 4 ],
        ], $result);


        $result = [];
        foreach ( $itertools->walkeach([ 1, [ 2, [ 3, [ 4 ] ] ] ], $continue, null, null, true) as $path => $seq ) {
            $result[] = [ $path, $seq ];
        }

        $this->assertEquals([
            [ [], [ 1, [ 2, [ 3, [ 4 ] ] ] ] ],
            [ [ 0 ], 1 ],
            [ [ 1, 0 ], 2 ],
            [ [ 1, 1, 0 ], 3 ],
            [ [ 1, 1, 1, 0 ], 4 ],
        ], $result);


        $result = [];
        foreach ( $itertools->walkeach([ 1, [ 2, [ 3, [ 4 ] ] ] ], $continue, null, true, true) as $path => $seq ) {
            $result[] = [ $path, $seq ];
        }

        $this->assertEquals([
            [ [], [ 1, [ 2, [ 3, [ 4 ] ] ] ] ],
            [ [ 0 ], 1 ],
            [ [ 1 ], [ 2, [ 3, [ 4 ] ] ] ],
            [ [ 1, 0 ], 2 ],
            [ [ 1, 1 ], [ 3, [ 4 ] ] ],
            [ [ 1, 1, 0 ], 3 ],
            [ [ 1, 1, 1 ], [ 4 ] ],
            [ [ 1, 1, 1, 0 ], 4 ],
        ], $result);


        $result = [];
        foreach ( $itertools->walkeach([ [ 1, 1 ], [ [ 2, 2 ], [ [ 3, 3 ], [ 4, 4 ] ] ] ]) as $path => $seq ) {
            $result[] = [ $path, $seq ];
        }

        $this->assertEquals([
            [ [ 0, 0 ], 1 ],
            [ [ 0, 1 ], 1 ],
            [ [ 1, 0, 0 ], 2 ],
            [ [ 1, 0, 1 ], 2 ],
            [ [ 1, 1, 0, 0 ], 3 ],
            [ [ 1, 1, 0, 1 ], 3 ],
            [ [ 1, 1, 1, 0 ], 4 ],
            [ [ 1, 1, 1, 1 ], 4 ],
        ], $result);
    }


    public function testProduct()
    {
        $itertools = $this->getItertools();

        $result = [];
        foreach ( $itertools->product([ 'a', 'b' ], [ 1, 2 ]) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ 'a', 1 ],
            [ 'a', 2 ],
            [ 'b', 1 ],
            [ 'b', 2 ],
        ], $result);
    }

    public function testProductRepeat()
    {
        $itertools = $this->getItertools();

        $result = [];
        foreach ( $itertools->productRepeat(3, $itertools->range(2)) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ 0, 0, 0 ],
            [ 0, 0, 1 ],
            [ 0, 1, 0 ],
            [ 0, 1, 1 ],
            [ 1, 0, 0 ],
            [ 1, 0, 1 ],
            [ 1, 1, 0 ],
            [ 1, 1, 1 ],
        ], $result);
    }


    public function testPermutations()
    {
        $itertools = $this->getItertools();


        $result = [];
        foreach ( $itertools->permutations([ 'a', 'b', 'c', 'd' ], 2) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ 'a', 'b' ],
            [ 'a', 'c' ],
            [ 'a', 'd' ],
            [ 'b', 'a' ],
            [ 'b', 'c' ],
            [ 'b', 'd' ],
            [ 'c', 'a' ],
            [ 'c', 'b' ],
            [ 'c', 'd' ],
            [ 'd', 'a' ],
            [ 'd', 'b' ],
            [ 'd', 'c' ],
        ], $result);


        $result = [];
        foreach ( $itertools->permutations($itertools->range(3)) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ 0, 1, 2 ],
            [ 0, 2, 1 ],
            [ 1, 0, 2 ],
            [ 1, 2, 0 ],
            [ 2, 0, 1 ],
            [ 2, 1, 0 ],
        ], $result);
    }

    public function testCombinations()
    {
        $itertools = $this->getItertools();


        $result = [];
        foreach ( $itertools->combinations([ 'a', 'b', 'c', 'd' ], 2) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ 'a', 'b' ],
            [ 'a', 'c' ],
            [ 'a', 'd' ],
            [ 'b', 'c' ],
            [ 'b', 'd' ],
            [ 'c', 'd' ],
        ], $result);


        $result = [];
        foreach ( $itertools->combinations($itertools->range(4), 3) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ 0, 1, 2 ],
            [ 0, 1, 3 ],
            [ 0, 2, 3 ],
            [ 1, 2, 3 ],
        ], $result);


        $result = [];
        foreach ( $itertools->combinations([ '', 'a', 'b', 'c' ], 2) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ '', 'a' ],
            [ '', 'b' ],
            [ '', 'c' ],
            [ 'a', 'b' ],
            [ 'a', 'c' ],
            [ 'b', 'c' ],
        ], $result);
    }

    public function testCombinationsAll()
    {
        $itertools = $this->getItertools();


        $result = [];
        foreach ( $itertools->combinationsAll([ '', 'a', 'b', 'c' ], 2) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ '', '' ],

            [ '', 'a' ],
            [ '', 'b' ],
            [ '', 'c' ],

            [ 'a', 'a' ],
            [ 'a', 'b' ],
            [ 'a', 'c' ],

            [ 'b', 'b' ],
            [ 'b', 'c' ],

            [ 'c', 'c' ],
        ], $result);


        $result = [];
        foreach ( $itertools->combinationsAll($itertools->range(4), 3) as $seq ) {
            $result[] = $seq;
        }

        $this->assertEquals([
            [ 0, 0, 0 ],

            [ 0, 0, 1 ],
            [ 0, 0, 2 ],
            [ 0, 0, 3 ],

            [ 0, 1, 1 ],
            [ 0, 1, 2 ],
            [ 0, 1, 3 ],

            [ 0, 2, 2 ],
            [ 0, 2, 3 ],

            [ 0, 3, 3 ],

            [ 1, 1, 1 ],
            [ 1, 1, 2 ],
            [ 1, 1, 3 ],
            [ 1, 2, 2 ],
            [ 1, 2, 3 ],
            [ 1, 3, 3 ],

            [ 2, 2, 2 ],
            [ 2, 2, 3 ],
            [ 2, 3, 3 ],

            [ 3, 3, 3 ],
        ], $result);
    }
}