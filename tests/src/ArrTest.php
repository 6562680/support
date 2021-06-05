<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class ArrTest extends AbstractTestCase
{
    protected function getArr() : Arr
    {
        return ( new SupportFactory() )->newArr();
    }


    public function testGet()
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

        // $this->assertEquals(1, $arr->get('', $array));
        // $this->assertEquals(1, $arr->get([ '' ], $array));
        // $this->assertEquals(2, $arr->get('hello', $array));
        // $this->assertEquals(2, $arr->get([ 'hello' ], $array));
        // $this->assertEquals([], $arr->get('world', $array));
        // $this->assertEquals([], $arr->get([ 'world' ], $array));
        // $this->assertEquals($arrayChild, $arr->get('foo', $array));
        // $this->assertEquals($arrayChild, $arr->get([ 'foo' ], $array));

        $this->assertEquals(1, $arr->get('foo.', $array));
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
            $arr->del($copy, 'hello.world');
        });

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            $copy = $array;
            $arr->del($copy, []);
        });

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            $copy = $array;
            $arr->del($copy, [ '', '' ]);
        });

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            $copy = $array;
            $arr->del($copy, [ 'hello.world' ]);
        });

        $this->assertException(UnderflowException::class, function () use ($arr, $array) {
            $copy = $array;
            $arr->del($copy, [ 'hello', 'world' ]);
        });
    }


    public function testDelete()
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

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, ''));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ '' ]));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, 'hello'));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'hello' ]));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, 'world'));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'world' ]));


        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, 'foo'));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'foo' ]));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, 'foo.'));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'foo', '' ]));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, 'foo.hello'));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'foo', 'hello' ]));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, 'foo.world'));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'foo', 'world' ]));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, 'foo.foo'));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'foo', 'foo' ]));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, 'foo.foo.0'));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'foo', 'foo', 0 ]));

        $copy = $array;
        $this->assertEquals(true, $arr->delete($copy, [ 'foo', 'foo', '0' ]));


        $copy = $array;
        $this->assertEquals(false, $arr->delete($copy, []));

        $copy = $array;
        $this->assertEquals(false, $arr->delete($copy, 'hello.world'));

        $copy = $array;
        $this->assertEquals(false, $arr->delete($copy, [ '', '' ]));

        $copy = $array;
        $this->assertEquals(false, $arr->delete($copy, [ 'hello.world' ]));

        $copy = $array;
        $this->assertEquals(false, $arr->delete($copy, [ 'hello', 'world' ]));
    }


    public function testPut()
    {
        $arr = $this->getArr();

        $dst = [];
        $ref =& $arr->put($dst, '', 1);
        $ref = 2;
        $this->assertEquals([ '' => 2 ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, 'hello', 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => 2 ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, 'hello.world', 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => 2 ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, [ '' ], 1);
        $ref = 2;
        $this->assertEquals([ '' => 2 ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, [ '', '' ], 1);
        $ref = 2;
        $this->assertEquals([ '' => [ '' => 2 ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, [ 'hello' ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => 2 ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, [ 'hello.world' ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => 2 ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, [ 'hello', 'world' ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => 2 ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, [ 'hello', 'world', 'hello.world' ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => [ 'hello' => [ 'world' => 2 ] ] ] ], $dst);
        unset($ref);

        $dst = [];
        $ref =& $arr->put($dst, [ 'hello', 'world', [ 'hello.world' ] ], 1);
        $ref = 2;
        $this->assertEquals([ 'hello' => [ 'world' => [ 'hello' => [ 'world' => 2 ] ] ] ], $dst);
        unset($ref);
    }

    public function testBadPut()
    {
        $arr = $this->getArr();

        $dst = [];

        $this->assertException(InvalidArgumentException::class, function () use ($arr, $dst) {
            $arr->put($dst, null, 1);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr, $dst) {
            $arr->put($dst, [], 1);
        });
    }


    public function testClear()
    {
        $arr = $this->getArr();

        $this->assertEquals([ 1 => null ], $arr->clear([ 1 => 1 ]));
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

        $this->assertEquals([ 2 => 1 ], $arr->drop([ 1 => 1, 2 => 1 ], 1));
        $this->assertEquals([ 2 => 1 ], $arr->drop([ 1 => 1, 2 => 1 ], '1'));
        $this->assertEquals([ 2 => 1 ], $arr->drop([ 1 => 1, 2 => 1 ], [ 1 ]));
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

    public function testPartition()
    {
        $arr = $this->getArr();

        $ids = [ 1, 2, 3, 4 ];
        $this->assertEquals([
            [ 1, 2 ],
            [ 2 => 3, 3 => 4 ],
        ], $arr->partition($ids, function ($v) { return $v > 2; }));

        $ids = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4 ];
        $this->assertEquals([
            [ 'a' => 1, 'b' => 2 ],
            [ 'c' => 3, 'd' => 4 ],
        ], $arr->partition($ids, function ($v) { return $v > 2; }));
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


    public function testFullpath()
    {
        $arr = $this->getArr();

        $this->assertEquals([ '' ], $arr->fullpath('', ':'));
        $this->assertEquals([ 'hello' ], $arr->fullpath('hello', ':'));
        $this->assertEquals([ 'hello', 'world' ], $arr->fullpath('hello:world', ':'));
        $this->assertEquals([], $arr->fullpath([], ':'));
        $this->assertEquals([ '' ], $arr->fullpath([ '' ], ':'));
        $this->assertEquals([ '', '' ], $arr->fullpath([ '', '' ], ':'));
        $this->assertEquals([ 'hello' ], $arr->fullpath([ 'hello' ], ':'));
        $this->assertEquals([ 'hello', 'world' ], $arr->fullpath([ 'hello:world' ], ':'));
        $this->assertEquals([ 'hello', 'world' ], $arr->fullpath([ 'hello', 'world' ], ':'));
        $this->assertEquals(
            [ 'hello', 'world', 'hello', 'world' ],
            $arr->fullpath([ 'hello', 'world', 'hello:world' ], ':')
        );
        $this->assertEquals(
            [ 'hello', 'world', 'hello', 'world' ],
            $arr->fullpath([ 'hello', 'world', [ 'hello:world' ] ], ':')
        );
    }

    public function testBadFullpath()
    {
        $arr = $this->getArr();

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->fullpath(null, ':');
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->fullpath([ null ], ':');
        });
    }


    public function testKey()
    {
        $arr = $this->getArr();

        $this->assertEquals('', $arr->key('', ':'));
        $this->assertEquals('hello', $arr->key('hello', ':'));
        $this->assertEquals('hello:world', $arr->key('hello:world', ':'));
        $this->assertEquals('', $arr->key([], ':'));
        $this->assertEquals('', $arr->key([ '' ], ':'));
        $this->assertEquals('', '', $arr->key([ '', '' ], ':'));
        $this->assertEquals('hello', $arr->key([ 'hello' ], ':'));
        $this->assertEquals('hello:world', $arr->key([ 'hello:world' ], ':'));
        $this->assertEquals('hello:world', $arr->key([ 'hello', 'world' ], ':'));
        $this->assertEquals(
            'hello:world:hello:world',
            $arr->key([ 'hello', 'world', 'hello:world' ], ':')
        );
        $this->assertEquals(
            'hello:world:hello:world',
            $arr->key([ 'hello', 'world', [ 'hello:world' ] ], ':')
        );
    }

    public function testBadKey()
    {
        $arr = $this->getArr();

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->key('.', null);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->key('.', [ null ]);
        });
    }


    public function testIndexKey()
    {
        $arr = $this->getArr();

        $this->assertEquals('', $arr->index('.', ''));
        $this->assertEquals('', $arr->index('.', []));
        $this->assertEquals('', $arr->index('.', [ '' ]));
        $this->assertEquals('', $arr->index('.', [ '', '' ]));

        $this->assertEquals('hello', $arr->index('.', 'hello'));
        $this->assertEquals('hello', $arr->index('.', [ 'hello' ]));
        $this->assertEquals('hello.world', $arr->index('.', 'hello.world'));
        $this->assertEquals('hello.world', $arr->index('.', [ 'hello.world' ]));

        $this->assertEquals('hello.world', $arr->index('.', [ 'hello', 'world' ]));
        $this->assertEquals('hello.world.hello.world', $arr->index('.', [ 'hello', 'world', 'hello.world' ]));
        $this->assertEquals('hello.world.hello.world', $arr->index('.', [ 'hello', 'world', [ 'hello.world' ] ]));
    }

    public function testBadIndexKey()
    {
        $arr = $this->getArr();

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->index(null, '.');
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->index([ null ], '.');
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

        $this->assertEquals([
            0       => 1,
            1       => [ 2 ],
            '1.1'   => [ 3 ],
            '1.1.1' => [ 4 ],
        ], $arr->dotarr($array));
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

        $array = [
            'hello'       => null,
            'world'       => [],
            'hello.world' => [
                'hello'       => null,
                'world'       => [],
                'hello.world' => [
                    null,
                ],
            ],
        ];

        $pathes = [];
        $values = [];
        foreach ( $arr->walk($array) as $fullpath => $item ) {
            $pathes[] = $fullpath;
            $values[] = $item;
        }

        $this->assertEquals([
            [ 'hello' ],
            [ 'world' ],
            [ 'hello.world' ],
            [ 'hello.world', 'hello' ],
            [ 'hello.world', 'world' ],
            [ 'hello.world', 'hello.world' ],
            [ 'hello.world', 'hello.world', 0 ],
        ], $pathes);

        $this->assertEquals([
            null,
            [],
            [
                'hello'       => null,
                'world'       => [],
                'hello.world' => [
                    0 => null,
                ],
            ],
            null,
            [],
            [ 0 => null ],
            null,
        ], $values);
    }

    public function testCrawl()
    {
        $arr = $this->getArr();

        $array = [
            'hello'       => null,
            'world'       => [],
            'hello.world' => $it = new \ArrayIterator([
                'hello'       => null,
                'world'       => [],
                'hello.world' => [
                    null,
                ],
            ]),
        ];

        $pathes = [];
        $values = [];
        foreach ( $arr->crawl($array) as $fullpath => $item ) {
            $pathes[] = $fullpath;
            $values[] = $item;
        }

        $this->assertEquals([
            [ 'hello' ],
            [ 'world' ],
            [ 'hello.world' ],
            [ 'hello.world', 'hello' ],
            [ 'hello.world', 'world' ],
            [ 'hello.world', 'hello.world' ],
            [ 'hello.world', 'hello.world', 0 ],
        ], $pathes);

        $this->assertEquals([
            null,
            [],
            $it,
            null,
            [],
            [ 0 => null ],
            null,
        ], $values);
    }


    public function testExpand()
    {
        $arr = $this->getArr();

        $array1 = [ 'hello', 'world' ];

        $array21 = [ 1 => 'hello', 2 => 'world' ];
        $array22 = [ 1 => 'hello', 3 => 'world' ];

        $array31 = [ 1 => 'hello', 2 => 'world', 3 => 'foo' ];
        $array32 = [ 1 => 'hello', 2 => 'world', 4 => 'foo' ];

        $array41 = [ 1 => 'hello', 2 => 'world', 3 => 'foo', 4 => 'bar' ];
        $array42 = [ 1 => 'hello', 2 => 'world', 4 => 'foo', 5 => 'bar' ];

        $array51 = [ 1 => 'hello', 2 => 'world', 3 => 'foo', 5 => 'bar' ];
        $array52 = [ 1 => 'hello', 2 => 'world', 4 => 'foo', 6 => 'bar' ];

        $this->assertEquals(
            [ 'hello', 'hello.world', 'world' ],
            $arr->expand($array1, 1, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'hello.world', 3 => 'world' ],
            $arr->expand($array21, 2, 'hello.world')
        );
        $this->assertEquals(
            [ 1 => 'hello', 2 => 'hello.world', 3 => 'world' ],
            $arr->expand($array22, 2, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo' ],
            $arr->expand($array31, 3, 'hello.world')
        );
        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo' ],
            $arr->expand($array32, 3, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo', 5 => 'bar' ],
            $arr->expand($array41, 3, 'hello.world')
        );
        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo', 5 => 'bar' ],
            $arr->expand($array42, 3, 'hello.world')
        );

        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo', 5 => 'bar' ],
            $arr->expand($array51, 3, 'hello.world')
        );
        $this->assertEquals(
            [ 1 => 'hello', 2 => 'world', 3 => 'hello.world', 4 => 'foo', 6 => 'bar' ],
            $arr->expand($array52, 3, 'hello.world')
        );
    }

    public function testExpandMany()
    {
        $arr = $this->getArr();

        $dst = [
            -1      => '0',
            -3      => '0',
            'hello' => '0',
            'world' => '0',
            3       => '0',
            'foo'   => '0',
            'bar'   => '0',
            1       => '0',
        ];
        $expands[] = [
            -2       => '1',
            -4       => '1',
            'hello2' => '1',
            'world2' => '1',
            4        => '1',
            'foo2'   => '1',
            'bar2'   => '1',
            2        => '1',
        ];
        $expands[] = [
            -1 => '2',
            -3 => '2',
            3  => '2',
            1  => '2',
        ];
        $expands[] = [
            -2 => '3',
            -4 => '3',
            4  => '3',
            2  => '3',
        ];

        $this->assertEquals(
            [
                -4       => '1',
                -3       => '3',
                'hello2' => '1',
                'world2' => '1',
                -2       => '2',
                -1       => '0',
                'hello'  => '0',
                'world'  => '0',
                0        => '1',
                1        => '3',
                2        => '2',
                3        => '0',
                4        => '2',
                5        => '0',
                6        => '3',
                7        => '1',
                8        => '2',
                9        => '0',
                'foo'    => '0',
                'bar'    => '0',
                10       => '3',
                11       => '1',
                'foo2'   => '1',
                'bar2'   => '1',
            ],
            $arr->expandMany($dst, ...$expands)
        );
    }

    public function testBadExpandMany()
    {
        // similar string keys couldn't be ordered when conflict

        $this->expectException(InvalidArgumentException::class);

        $arr = $this->getArr();

        $dst = [
            'hello' => '0',
            'world' => '0',
        ];
        $expands[] = [
            'hello' => '1',
            'world' => '1',
        ];

        $arr->expandMany($dst, ...$expands);
    }
}
