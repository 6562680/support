<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XArr;
use Gzhegow\Support\IArr;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class ArrTest extends AbstractTestCase
{
    protected function getArr() : IArr
    {
        return XArr::getInstance();
    }


    public function testGet()
    {
        $arr = $this->getArr();

        $array = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => [
                ''            => 1,
                'hello'       => 2,
                'world'       => [],
                'foo'         => [
                    1,
                ],
                'hello.world' => [
                    1,
                ],
            ],
            'hello.world' => [
                ''            => 1,
                'hello'       => 2,
                'world'       => [],
                'foo'         => [
                    1,
                ],
                'hello.world' => [
                    1,
                ],
            ],
        ];

        // $this->assertEquals(1, $arr->get('', $array));
        // $this->assertEquals(1, $arr->get([ '' ], $array));
        // $this->assertEquals(2, $arr->get('hello', $array));
        // $this->assertEquals(2, $arr->get([ 'hello' ], $array));
        // $this->assertEquals([], $arr->get('world', $array));
        // $this->assertEquals([], $arr->get([ 'world' ], $array));
        // $this->assertEquals($arrayChild, $arr->get('foo', $array));
        // $this->assertEquals($arrayChild, $arr->get([ 'foo' ], $array));

        // $this->assertEquals(1, $arr->get('foo.', $array));
        $this->assertEquals(1, $arr->get([ 'foo', '' ], $array));
        $this->assertEquals(2, $arr->get('foo.hello', $array));
        $this->assertEquals(2, $arr->get([ 'foo', 'hello' ], $array));
        $this->assertEquals([], $arr->get('foo.world', $array));
        $this->assertEquals([], $arr->get([ 'foo', 'world' ], $array));
        $this->assertEquals([ 1 ], $arr->get('foo.foo', $array));
        $this->assertEquals([ 1 ], $arr->get([ 'foo', 'foo' ], $array));

        $this->assertEquals(1, $arr->get('foo.foo.0', $array));
        $this->assertEquals(1, $arr->get([ 'foo', 'foo', 0 ], $array));
        $this->assertEquals(1, $arr->get([ 'foo', 'foo', '0' ], $array));
    }

    public function testBadGet()
    {
        $arr = $this->getArr();

        $arrayChild = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => [
                1,
            ],
            'hello.world' => [
                1,
            ],
        ];
        $array = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => $arrayChild,
            'hello.world' => $arrayChild,
        ];

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->get([], $array);
        });

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->get('hello.world', $array);
        });

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->get([ '', '' ], $array);
        });

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->get([ 'hello.world' ], $array);
        });

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->get([ 'hello', 'world' ], $array);
        });
    }


    public function testGetRef()
    {
        $arr = $this->getArr();

        $arrayChild = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => [
                1,
            ],
            'hello.world' => [
                1,
            ],
        ];
        $array = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => $arrayChild,
            'hello.world' => $arrayChild,
        ];

        $this->assertEquals(1, $arr->getRef('', $array));
        $this->assertEquals(1, $arr->getRef([ '' ], $array));
        $this->assertEquals(2, $arr->getRef('hello', $array));
        $this->assertEquals(2, $arr->getRef([ 'hello' ], $array));
        $this->assertEquals([], $arr->getRef('world', $array));
        $this->assertEquals([], $arr->getRef([ 'world' ], $array));
        $this->assertEquals($arrayChild, $arr->getRef('foo', $array));
        $this->assertEquals($arrayChild, $arr->getRef([ 'foo' ], $array));

        $this->assertEquals(1, $arr->getRef('foo.', $array));
        $this->assertEquals(1, $arr->getRef([ 'foo', '' ], $array));
        $this->assertEquals(2, $arr->getRef('foo.hello', $array));
        $this->assertEquals(2, $arr->getRef([ 'foo', 'hello' ], $array));
        $this->assertEquals([], $arr->getRef('foo.world', $array));
        $this->assertEquals([], $arr->getRef([ 'foo', 'world' ], $array));
        $this->assertEquals([ 1 ], $arr->getRef('foo.foo', $array));
        $this->assertEquals([ 1 ], $arr->getRef([ 'foo', 'foo' ], $array));

        $this->assertEquals(1, $arr->getRef('foo.foo.0', $array));
        $this->assertEquals(1, $arr->getRef([ 'foo', 'foo', 0 ], $array));
        $this->assertEquals(1, $arr->getRef([ 'foo', 'foo', '0' ], $array));
    }

    public function testBadGetRef()
    {
        $arr = $this->getArr();

        $arrayChild = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => [
                1,
            ],
            'hello.world' => [
                1,
            ],
        ];
        $array = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => $arrayChild,
            'hello.world' => $arrayChild,
        ];

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->getRef([], $array);
        });

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->getRef('hello.world', $array);
        });

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->getRef([ '', '' ], $array);
        });

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->getRef([ 'hello.world' ], $array);
        });

        $this->assertException(OutOfRangeException::class, function () use ($arr, $array) {
            $arr->getRef([ 'hello', 'world' ], $array);
        });
    }


    public function testHas()
    {
        $arr = $this->getArr();

        $arrayChild = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => [
                1,
            ],
            'hello.world' => [
                1,
            ],
        ];
        $array = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => $arrayChild,
            'hello.world' => $arrayChild,
        ];

        $this->assertEquals(true, $arr->has('', $array));
        $this->assertEquals(true, $arr->has([ '' ], $array));
        $this->assertEquals(true, $arr->has('hello', $array));
        $this->assertEquals(true, $arr->has([ 'hello' ], $array));
        $this->assertEquals(true, $arr->has('world', $array));
        $this->assertEquals(true, $arr->has([ 'world' ], $array));
        $this->assertEquals(true, $arr->has('foo', $array));
        $this->assertEquals(true, $arr->has([ 'foo' ], $array));

        $this->assertEquals(true, $arr->has('foo.', $array));
        $this->assertEquals(true, $arr->has([ 'foo', '' ], $array));
        $this->assertEquals(true, $arr->has('foo.hello', $array));
        $this->assertEquals(true, $arr->has([ 'foo', 'hello' ], $array));
        $this->assertEquals(true, $arr->has('foo.world', $array));
        $this->assertEquals(true, $arr->has([ 'foo', 'world' ], $array));
        $this->assertEquals(true, $arr->has('foo.foo', $array));
        $this->assertEquals(true, $arr->has([ 'foo', 'foo' ], $array));

        $this->assertEquals(true, $arr->has('foo.foo.0', $array));
        $this->assertEquals(true, $arr->has([ 'foo', 'foo', 0 ], $array));
        $this->assertEquals(true, $arr->has([ 'foo', 'foo', '0' ], $array));

        $this->assertEquals(false, $arr->has([], $array));
        $this->assertEquals(false, $arr->has('hello.world', $array));
        $this->assertEquals(false, $arr->has([ '', '' ], $array));
        $this->assertEquals(false, $arr->has([ 'hello.world' ], $array));
        $this->assertEquals(false, $arr->has([ 'hello', 'world' ], $array));
    }


    public function testSet()
    {
        $arr = $this->getArr();

        $dst = [];
        $arr->set($dst, '', 1);
        $this->assertEquals([ '' => 1 ], $dst);

        $dst = [];
        $arr->set($dst, 'hello', 1);
        $this->assertEquals([ 'hello' => 1 ], $dst);

        $dst = [];
        $arr->set($dst, 'hello.world', 1);
        $this->assertEquals([ 'hello' => [ 'world' => 1 ] ], $dst);

        $dst = [];
        $arr->set($dst, [ '' ], 1);
        $this->assertEquals([ '' => 1 ], $dst);

        $dst = [];
        $arr->set($dst, [ '', '' ], 1);
        $this->assertEquals([ '' => [ '' => 1 ] ], $dst);

        $dst = [];
        $arr->set($dst, [ 'hello' ], 1);
        $this->assertEquals([ 'hello' => 1 ], $dst);

        $dst = [];
        $arr->set($dst, [ 'hello.world' ], 1);
        $this->assertEquals([ 'hello' => [ 'world' => 1 ] ], $dst);

        $dst = [];
        $arr->set($dst, [ 'hello', 'world' ], 1);
        $this->assertEquals([ 'hello' => [ 'world' => 1 ] ], $dst);

        $dst = [];
        $arr->set($dst, [ 'hello', 'world', 'hello.world' ], 1);
        $this->assertEquals([ 'hello' => [ 'world' => [ 'hello' => [ 'world' => 1 ] ] ] ], $dst);

        $dst = [];
        $arr->set($dst, [ 'hello', 'world', [ 'hello.world' ] ], 1);
        $this->assertEquals([ 'hello' => [ 'world' => [ 'hello' => [ 'world' => 1 ] ] ] ], $dst);
    }

    public function testBadSet()
    {
        $arr = $this->getArr();

        $dst = [];

        $this->assertException(InvalidArgumentException::class, function () use ($arr, $dst) {
            $arr->set($dst, null, 1);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr, $dst) {
            $arr->set($dst, [], 1);
        });
    }


    public function testDel()
    {
        $arr = $this->getArr();

        $array = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => [
                ''            => 1,
                'hello'       => 2,
                'world'       => [],
                'foo'         => [
                    1,
                ],
                'hello.world' => [
                    1,
                ],
            ],
            'hello.world' => [
                ''            => 1,
                'hello'       => 2,
                'world'       => [],
                'foo'         => [
                    1,
                ],
                'hello.world' => [
                    1,
                ],
            ],
        ];

        $copy = $array;
        $expect = $array;
        unset($expect[ '' ]);
        $this->assertEquals($expect, $arr->del($copy, ''));

        $copy = $array;
        $expect = $array;
        unset($expect[ '' ]);
        $this->assertEquals($expect, $arr->del($copy, [ '' ]));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'hello' ]);
        $this->assertEquals($expect, $arr->del($copy, 'hello'));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'hello' ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'hello' ]));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'world' ]);
        $this->assertEquals($expect, $arr->del($copy, 'world'));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'world' ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'world' ]));


        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ]);
        $this->assertEquals($expect, $arr->del($copy, 'foo'));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'foo' ]));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ '' ]);
        $this->assertEquals($expect, $arr->del($copy, 'foo.'));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ '' ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'foo', '' ]));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'hello' ]);
        $this->assertEquals($expect, $arr->del($copy, 'foo.hello'));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'hello' ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'foo', 'hello' ]));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'world' ]);
        $this->assertEquals($expect, $arr->del($copy, 'foo.world'));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'world' ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'foo', 'world' ]));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'foo' ]);
        $this->assertEquals($expect, $arr->del($copy, 'foo.foo'));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'foo' ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'foo', 'foo' ]));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'foo' ][ 0 ]);
        $this->assertEquals($expect, $arr->del($copy, 'foo.foo.0'));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'foo' ][ 0 ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'foo', 'foo', 0 ]));

        $copy = $array;
        $expect = $array;
        unset($expect[ 'foo' ][ 'foo' ][ 0 ]);
        $this->assertEquals($expect, $arr->del($copy, [ 'foo', 'foo', '0' ]));
    }

    public function testBadDel()
    {
        $arr = $this->getArr();

        $arrayChild = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => [
                1,
            ],
            'hello.world' => [
                1,
            ],
        ];
        $array = [
            ''            => 1,
            'hello'       => 2,
            'world'       => [],
            'foo'         => $arrayChild,
            'hello.world' => $arrayChild,
        ];

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            $copy = $array;
            $arr->del($copy, []);
        });

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            $copy = $array;
            $arr->del($copy, [ '', '' ]);
        });

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            // cus of path becomes to [ 'hello', 'world' ]

            $copy = $array;
            $arr->del($copy, 'hello.world');
        });

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            // cus of path becomes to [ 'hello', 'world' ]

            $copy = $array;
            $arr->del($copy, [ 'hello.world' ]);
        });

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            // cus of path becomes to [ 'hello', 'world' ]

            $copy = $array;
            $arr->del($copy, [ 'hello', 'world' ]);
        });
    }


    public function testPut()
    {
        $arr = $this->getArr();

        $dst = [];
        $ref =& $arr->setRef($dst, '', 1);
        $ref = 2;
        $this->assertEquals([ '' => 2 ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, 'hello', 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => 2 ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, 'hello.world', 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => 2 ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, [ '' ], 1);
        $ref = 2;
        $this->assertEquals([ '' => 2 ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, [ '', '' ], 1);
        $ref = 2;
        $this->assertEquals([ '' => [ '' => 2 ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, [ 'hello' ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => 2 ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, [ 'hello.world' ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => 2 ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, [ 'hello', 'world' ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => 2 ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, [ 'hello', 'world', 'hello.world' ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => [ 'hello' => [ 'world' => 2 ] ] ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->setRef($dst, [ 'hello', 'world', [ 'hello.world' ] ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => [ 'hello' => [ 'world' => 2 ] ] ] ], $dst);
        unset($ref);
    }

    public function testBadPut()
    {
        $arr = $this->getArr();

        $dst = [];

        $this->assertException(InvalidArgumentException::class, function () use ($arr, $dst) {
            $arr->setRef($dst, null, 1);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr, $dst) {
            $arr->setRef($dst, [], 1);
        });
    }


    public function testListval()
    {
        $arr = $this->getArr();

        $this->assertEquals([], $arr->listval(null));
        $this->assertEquals([], $arr->listval(null, null));
        $this->assertEquals([], $arr->listval([ null ]));
        $this->assertEquals([], $arr->listval([ null, null ]));
        $this->assertEquals([ [ null ] ], $arr->listval([ null, [ null ] ]));

        $this->assertEquals([ [ 'a' => null ] ], $arr->listval([ 'a' => null ]));
        $this->assertEquals([ [ 'a' => null ], [ 'a' => null ] ], $arr->listval([ 'a' => null ], [ 'a' => null ]));
        $this->assertEquals([ [ 'a' => null ], [ 'a' => null ] ], $arr->listval([ [ 'a' => null ], [ 'a' => null ] ]));

        $this->assertEquals([ 1 ], $arr->listval(1));
        $this->assertEquals([ 1, 1 ], $arr->listval(1, 1));
        $this->assertEquals([ 1 ], $arr->listval([ 1 ]));
        $this->assertEquals([ 1, 1 ], $arr->listval([ 1, 1 ]));
        $this->assertEquals([ 1, [ 1 ] ], $arr->listval([ 1, [ 1 ] ]));
    }


    public function testEnumval()
    {
        $arr = $this->getArr();

        $map = [];

        $keys = [ null, 0, 0.0, '', 'a' ];
        foreach ( $keys as $key ) {
            $map[] = array_combine($keys,
                array_fill(0, count($keys), $key)
            );
        }

        $this->assertEquals([ 0, 'a', 0.0 ], $arr->enumval($map));
    }

    public function testEnumvalEach()
    {
        $arr = $this->getArr();

        $map = [];
        $keys = [ null, 0, 0.0, '', 'a' ];
        foreach ( $keys as $key ) {
            $map[] = array_combine($keys, array_fill(0, count($keys), $key));
        }

        $this->assertEquals([
            [ 0, 'a', 0.0 ],
            [ 0, 'a', 0.0 ],
        ], $arr->enumvalEach($map, $map));
    }


    public function testOnly()
    {
        $arr = $this->getArr();

        $this->assertEquals([ 1 => 1 ], $arr->only([ 1 => 1, 2 => 1 ], 1));
        $this->assertEquals([ 1 => 1 ], $arr->only([ 1 => 1, 2 => 1 ], '1'));
        $this->assertEquals([ 1 => 1 ], $arr->only([ 1 => 1, 2 => 1 ], [ 1 ]));
    }

    public function testExcept()
    {
        $arr = $this->getArr();

        $this->assertEquals([ 2 => 1 ], $arr->except([ 1 => 1, 2 => 1 ], 1));
        $this->assertEquals([ 2 => 1 ], $arr->except([ 1 => 1, 2 => 1 ], '1'));
        $this->assertEquals([ 2 => 1 ], $arr->except([ 1 => 1, 2 => 1 ], [ 1 ]));
    }

    public function testDrop()
    {
        $arr = $this->getArr();

        $this->assertEquals([ 1 => null, 2 => 1 ], $arr->drop([ 1 => 1, 2 => 1 ], 1));
        $this->assertEquals([ 1 => null, 2 => 1 ], $arr->drop([ 1 => 1, 2 => 1 ], '1'));
        $this->assertEquals([ 1 => null, 2 => 1 ], $arr->drop([ 1 => 1, 2 => 1 ], [ 1 ]));
    }


    public function testCombine()
    {
        $arr = $this->getArr();

        $this->assertEquals([ 1 => 1 ], $arr->combine([ 1 ], 1));
        $this->assertEquals([ 1 => 1 ], $arr->combine([ 1 ], [ 1, 2 ]));

        $this->assertEquals([ 1 => 1, 2 => 1 ], $arr->combine([ 1, 2 ], 1));
        $this->assertEquals([ 1 => 1, 2 => 2 ], $arr->combine([ 1, 2 ], [ 1, 2 ]));

        $this->assertEquals([ 1 => 1, 2 => 1, 3 => 1 ], $arr->combine([ 1, 2, 3 ], 1));
        $this->assertEquals([ 1 => 1, 2 => 2, 3 => null ], $arr->combine([ 1, 2, 3 ], [ 1, 2 ]));
    }


    public function testZip()
    {
        $arr = $this->getArr();

        $this->assertEquals([
            [ 'b1', 'b2' ],
        ], $arr->zip([ 'b1' ], [ 'b2' ]));

        $ids = [ 1, 2, 3, 4 ];
        $names = [ 'a', 'b', 'c', 'd' ];
        $this->assertEquals([
            [ 1, 'a' ],
            [ 2, 'b' ],
            [ 3, 'c' ],
            [ 4, 'd' ],
        ], $arr->zip($ids, $names));
    }


    public function testTwo()
    {
        $arr = $this->getArr();

        $ids = [ 1, 2, 3, 4 ];
        $this->assertEquals(
            [
                [ 2 => 3, 3 => 4 ],
                [ 1, 2 ],
            ],
            $arr->two($ids, function ($v) { return $v > 2; })
        );

        $ids = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4 ];
        $this->assertEquals(
            [
                [ 'c' => 3, 'd' => 4 ],
                [ 'a' => 1, 'b' => 2 ],
            ],
            $arr->two($ids, function ($v) { return $v > 2; })
        );
    }

    public function testGroup()
    {
        $arr = $this->getArr();

        $ids = [ 1, 2, 3, 4 ];
        $this->assertEquals([
            [
                'lower' => [ 1, 2 ],
                'upper' => [ 2 => 3, 3 => 4 ],
            ],
            [],
        ], $arr->group($ids, function ($v) { return $v > 2 ? 'upper' : 'lower'; }));
    }


    public function testPath()
    {
        $arr = $this->getArr();

        $this->assertEquals([ '' ], $arr->path('', ':'));
        $this->assertEquals([ 'hello' ], $arr->path('hello', ':'));
        $this->assertEquals([ 'hello', 'world' ], $arr->path('hello:world', ':'));
        $this->assertEquals([], $arr->path([], ':'));
        $this->assertEquals([ '' ], $arr->path([ '' ], ':'));
        $this->assertEquals([ '', '' ], $arr->path([ '', '' ], ':'));
        $this->assertEquals([ 'hello' ], $arr->path([ 'hello' ], ':'));
        $this->assertEquals([ 'hello', 'world' ], $arr->path([ 'hello:world' ], ':'));
        $this->assertEquals([ 'hello', 'world' ], $arr->path([ 'hello', 'world' ], ':'));
        $this->assertEquals(
            [ 'hello', 'world', 'hello', 'world' ],
            $arr->path([ 'hello', 'world', 'hello:world' ], ':')
        );
        $this->assertEquals(
            [ 'hello', 'world', 'hello', 'world' ],
            $arr->path([ 'hello', 'world', [ 'hello:world' ] ], ':')
        );
    }

    public function testBadPath()
    {
        $arr = $this->getArr();

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->path(null, ':');
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->path([ null ], ':');
        });
    }


    public function testPathkey()
    {
        $arr = $this->getArr();

        $this->assertEquals('', $arr->pathkey('', ':'));
        $this->assertEquals('hello', $arr->pathkey('hello', ':'));
        $this->assertEquals('hello:world', $arr->pathkey('hello:world', ':'));
        $this->assertEquals('', $arr->pathkey([], ':'));
        $this->assertEquals('', $arr->pathkey([ '' ], ':'));
        $this->assertEquals('', '', $arr->pathkey([ '', '' ], ':'));
        $this->assertEquals('hello', $arr->pathkey([ 'hello' ], ':'));
        $this->assertEquals('hello:world', $arr->pathkey([ 'hello:world' ], ':'));
        $this->assertEquals('hello:world', $arr->pathkey([ 'hello', 'world' ], ':'));
        $this->assertEquals(
            'hello:world:hello:world',
            $arr->pathkey([ 'hello', 'world', 'hello:world' ], ':')
        );
        $this->assertEquals(
            'hello:world:hello:world',
            $arr->pathkey([ 'hello', 'world', [ 'hello:world' ] ], ':')
        );
    }

    public function testBadPathkey()
    {
        $arr = $this->getArr();

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->pathkey('.', null);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->pathkey('.', [ null ]);
        });
    }


    public function testDot()
    {
        $arr = $this->getArr();

        $array = [ 1, [ 2, [ 3, [ 4 ] ] ] ];

        $this->assertEquals([
            '0'       => 1,
            '1.0'     => 2,
            '1.1.0'   => 3,
            '1.1.1.0' => 4,
        ], $arr->dot($array));
    }

    public function testDotarr()
    {
        $arr = $this->getArr();

        $array = [ 1, [ 2, [ 3, [ 4 ] ] ] ];

        $this->assertEquals($array, $arr->dotarr($array));

        $array = [
            'catalog' => [
                'err' => [
                    'undefined' => [
                        'en' => [ 'text', [ '1', '2', 'foo' => 'bar' ] ],
                        'ru' => [ 'text', [ '1', '2', 'foo' => 'bar' ] ],
                    ],
                ],
            ],
        ];

        $expected = [
            "catalog.err.undefined.en" => [ 'text', [ '1', '2', 'foo' => 'bar' ] ],
            "catalog.err.undefined.ru" => [ 'text', [ '1', '2', 'foo' => 'bar' ] ],
        ];

        $this->assertEquals($expected, $arr->dotarr($array));
    }

    public function testUndot()
    {
        $arr = $this->getArr();

        $array = [
            '0'       => 1,
            '1.0'     => 2,
            '1.1.0'   => 3,
            '1.1.1.0' => 4,
        ];

        $this->assertEquals([ 1, [ 2, [ 3, [ 4 ] ] ] ], $arr->undot($array));
    }


    public function testWalk()
    {
        $arr = $this->getArr();

        $array = [ 1, [ 2, [ 3, [ 4 ] ] ] ];

        $result = [];
        foreach ( $arr->walk($array) as $path => $seq ) {
            $result[] = [ $path, $seq ];
        }

        $this->assertEquals([
            [ [ 0 ], 1 ],
            [ [ 1, 0 ], 2 ],
            [ [ 1, 1, 0 ], 3 ],
            [ [ 1, 1, 1, 0 ], 4 ],
        ], $result);


        $result = [];
        foreach ( $arr->walk($array, null, true) as $path => $seq ) {
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
        foreach ( $arr->walk($array, null, null, true) as $path => $seq ) {
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
        foreach ( $arr->walk($array, null, true, true) as $path => $seq ) {
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


        $array2 = [ [ 1, 1 ], [ [ 2, 2 ], [ [ 3, 3 ], [ 4, 4 ] ] ] ];

        $result = [];
        foreach ( $arr->walk($array2) as $path => $seq ) {
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


    public function testExpand()
    {
        $arr = $this->getArr();

        $this->assertEquals(
            [ 'hello', 'hello.world', 'world' ],
            $arr->expand([ 'hello', 'world' ], 1, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world' ],
            $arr->expand([ 1 => 'hello', 2 => 'world' ], 2, 'hello.world')
        );
        $this->assertEquals(
            [ 1 => 'hello', 2 => 'hello.world', 3 => 'world' ],
            $arr->expand([ 1 => 'hello', 3 => 'world' ], 2, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'hello.world' ],
            $arr->expand([ 1 => 'hello', 2 => 'world', 3 => 'foo' ], 3, 'hello.world')
        );
        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo' ],
            $arr->expand([ 1 => 'hello', 2 => 'world', 4 => 'foo' ], 3, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'hello.world', 5 => 'bar' ],
            $arr->expand([ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'bar' ], 3, 'hello.world')
        );
        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo', 5 => 'bar' ],
            $arr->expand([ 1 => 'hello', 2 => 'world', 4 => 'foo', 5 => 'bar' ], 3, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'hello.world', 5 => 'bar' ],
            $arr->expand([ 1 => 'hello', 2 => 'world', 3 => 'foo', 5 => 'bar' ], 3, 'hello.world')
        );
        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo', 6 => 'bar' ],
            $arr->expand([ 1 => 'hello', 2 => 'world', 4 => 'foo', 6 => 'bar' ], 3, 'hello.world')
        );
    }

    public function testExpandSearch()
    {
        $arr = $this->getArr();

        $this->assertEquals(
            [ 0 => 'hello', 1 => 'world', 2 => 'hello.world' ],
            $arr->expandAfter([ 0 => 'hello', 1 => 'world' ], 1, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world' ],
            $arr->expandAfter([ 1 => 'hello', 2 => 'world' ], 2, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'hello.world' ],
            $arr->expandAfter([ 1 => 'hello', 2 => 'world', 3 => 'foo' ], 3, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'hello.world', 5 => 'bar' ],
            $arr->expandAfter([ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'bar' ], 3, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'hello.world', 5 => 'bar' ],
            $arr->expand([ 1 => 'hello', 2 => 'world', 3 => 'foo', 5 => 'bar' ], 3, 'hello.world')
        );
    }

    public function testBadExpandSearch()
    {
        $this->expectException(RuntimeException::class);

        $arr = $this->getArr();

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'hello.world', 3 => 'world' ],
            $arr->expandAfter([ 1 => 'hello', 3 => 'world' ], 2, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo' ],
            $arr->expandAfter([ 1 => 'hello', 2 => 'world', 4 => 'foo' ], 3, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo', 5 => 'bar' ],
            $arr->expandAfter([ 1 => 'hello', 2 => 'world', 4 => 'foo', 5 => 'bar' ], 3, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo', 6 => 'bar' ],
            $arr->expand([ 1 => 'hello', 2 => 'world', 4 => 'foo', 6 => 'bar' ], 3, 'hello.world')
        );
    }


    public function testExpandMany()
    {
        $arr = $this->getArr();

        $array = [
            -1     => '0',
            -3     => '0',
            '-bar' => '0',
            '-foo' => '0',
            'foo'  => '0',
            'bar'  => '0',
            3      => '0',
            1      => '0',
        ];

        $expands[] = [
            [ null, '1', -2 ],
            [ null, '1', -4 ],
            [ null, '1', '-bar2' ],
            [ null, '1', '-foo2' ],
            [ null, '1', 'foo2' ],
            [ null, '1', 'bar2' ],
            [ null, '1', 4 ],
            [ null, '1', 2 ],
        ];
        $expands[] = [
            [ 8, '2', -1 ],
            [ null, '2', -3 ],
            [ null, '2', 3 ],
            [ null, '2', 1 ],
        ];
        $expands[] = [
            [ null, '3', -2 ],
            [ null, '3', -4 ],
            [ null, '3', 4 ],
            [ null, '3', 2 ],
        ];

        $this->assertEquals(
            [
                -1     => "0",
                -3     => "0",
                "-bar" => "0",
                "-foo" => "0",
                "foo"  => "0",
                "bar"  => "0",
                3      => "0",
                1      => "0",

                4 => "2",
                5 => "2",
                6 => "2",
                7 => "2",

                -2      => "1",
                -4      => "1",
                "-bar2" => "1",
                "-foo2" => "1",
                "foo2"  => "1",
                "bar2"  => "1",
                8       => "1",
                2       => "1",

                9  => "3",
                10 => "3",
                11 => "3",
                12 => "3",
            ],
            $arr->expandMany($array, ...$expands)
        );
    }

    public function testBadExpandMany()
    {
        // similar string keys couldn't be ordered when conflict

        $this->expectException(RuntimeException::class);

        $arr = $this->getArr();

        $dst = [
            'hello' => '0',
            'world' => '0',
        ];
        $expands[] = [
            [ null, '1', 'hello' ],
            [ null, '1', 'world' ],
        ];

        $arr->expandMany($dst, ...$expands);
    }
}