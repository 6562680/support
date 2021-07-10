<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ZArr;
use Gzhegow\Support\IArr;
use Gzhegow\Support\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Support\Exceptions\Runtime\UnderflowException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class ArrTest extends AbstractTestCase
{
    protected function getArr() : IArr
    {
        return ZArr::getInstance();
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


    public function testIndex()
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

    public function testBadIndex()
    {
        $arr = $this->getArr();

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->index(null, '.');
        });

        $this->assertException(InvalidArgumentException::class, function () use ($arr) {
            $arr->index([ null ], '.');
        });
    }


    public function testIndexed()
    {
        $arr = $this->getArr();

        $this->assertEquals('[]', $arr->indexed(null));
        $this->assertEquals('[""]', $arr->indexed(false));
        $this->assertEquals('["1"]', $arr->indexed(true));
        $this->assertEquals('["1"]', $arr->indexed(1));
        $this->assertEquals('["1.1"]', $arr->indexed(1.1));
        $this->assertEquals('["1.1E-10"]', $arr->indexed(1.1e-10));

        $this->assertEquals('[]', $arr->indexed([]));
        $this->assertEquals('[]', $arr->indexed([ null ]));
        $this->assertEquals('[""]', $arr->indexed([ false ]));
        $this->assertEquals('["1"]', $arr->indexed([ true ]));
        $this->assertEquals('["1"]', $arr->indexed([ 1 ]));
        $this->assertEquals('["1.1"]', $arr->indexed([ 1.1 ]));
        $this->assertEquals('["1.1E-10"]', $arr->indexed([ 1.1e-10 ]));
    }

    public function testBadIndexed()
    {
        $arr = $this->getArr();

        $this->expectError();

        $arr->indexed(new \StdClass());
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
            'category1' => [
                'category1.1' => [
                    'error1',
                    [ 'error2' ],
                    [ 'error3', 'argument1' ],
                    [ 'error4', 'argument1', 'arrayArgument2' => [ 'argument2.1' ] ],
                ],
            ],
        ];
        $expected = [
            "category1.category1.1" => [
                'error1',
                [ 'error2' ],
                [ 'error3', 'argument1' ],
                [ 'error4', 'argument1', 'arrayArgument2' => [ 'argument2.1' ] ],
            ],
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

        $array = [
            0   => $a1 = null,
            ''  => $a2 = null,
            'a' => $a3 = null,
            'b' => $a4 = [],
            'c' => $a5 = new \StdClass(),
            'd' => $a6 = [
                0   => $aa1 = null,
                ''  => $aa2 = null,
                'a' => $aa3 = null,
                'b' => $aa4 = [],
                'c' => $aa5 = new \StdClass(),
                'd' => $aa6 = new \ArrayObject([
                    0   => $aaa1 = null,
                    ''  => $aaa2 = null,
                    'a' => $aaa3 = null,
                    'b' => $aaa4 = [],
                    'c' => $aaa5 = new \StdClass(),
                ]),
            ],
        ];

        $fullpathes = [];
        $values = [];
        foreach ( $arr->walk($array, \RecursiveIteratorIterator::CHILD_FIRST) as $fullpath => $value ) {
            $fullpathes[] = $fullpath;
            $values[] = $value;
        }

        $this->assertEquals([
            [ 0 ],
            [ '' ],
            [ 'a' ],
            [ 'b' ],
            [ 'c' ],

            [ 'd', 0 ],
            [ 'd', '' ],
            [ 'd', 'a' ],
            [ 'd', 'b' ],
            [ 'd', 'c' ],
            [ 'd', 'd' ],

            [ 'd' ],
        ], $fullpathes);

        $this->assertEquals([
            $a1,
            $a2,
            $a3,
            $a4,
            $a5,


            $aa1,
            $aa2,
            $aa3,
            $aa4,
            $aa5,
            $aa6,

            $a6,
        ], $values);
    }

    public function testCrawl()
    {
        $arr = $this->getArr();

        $array = [
            0   => $a1 = null,
            ''  => $a2 = null,
            'a' => $a3 = null,
            'b' => $a4 = [],
            'c' => $a5 = new \StdClass(),
            'd' => $a6 = [
                0   => $aa1 = null,
                ''  => $aa2 = null,
                'a' => $aa3 = null,
                'b' => $aa4 = [],
                'c' => $aa5 = new \StdClass(),
                'd' => $aa6 = new \ArrayObject([
                    0   => $aaa1 = null,
                    ''  => $aaa2 = null,
                    'a' => $aaa3 = null,
                    'b' => $aaa4 = [],
                    'c' => $aaa5 = new \StdClass(),
                ]),
            ],
        ];

        $fullpathes = [];
        $values = [];
        foreach ( $arr->crawl($array, \RecursiveIteratorIterator::SELF_FIRST) as $fullpath => $value ) {
            $fullpathes[] = $fullpath;
            $values[] = $value;
        }

        $this->assertEquals([
            [ 0 ],
            [ '' ],
            [ 'a' ],
            [ 'b' ],
            [ 'c' ],
            [ 'd' ],

            [ 'd', 0 ],
            [ 'd', '' ],
            [ 'd', 'a' ],
            [ 'd', 'b' ],
            [ 'd', 'c' ],
            [ 'd', 'd' ],

            [ 'd', 'd', 0 ],
            [ 'd', 'd', '' ],
            [ 'd', 'd', 'a' ],
            [ 'd', 'd', 'b' ],
            [ 'd', 'd', 'c' ],
        ], $fullpathes);

        $this->assertEquals([
            $a1,
            $a2,
            $a3,
            $a4,
            $a5,
            $a6,

            $aa1,
            $aa2,
            $aa3,
            $aa4,
            $aa5,
            $aa6,

            $aaa1,
            $aaa2,
            $aaa3,
            $aaa4,
            $aaa5,
        ], $values);
    }


    public function testWalkRecursive()
    {
        $arr = $this->getArr();

        $array = [
            0   => $a1 = null,
            ''  => $a2 = null,
            'a' => $a3 = null,
            'b' => $a4 = [],
            'c' => $a5 = new \StdClass(),
            'd' => $a6 = [
                0   => $aa1 = null,
                ''  => $aa2 = null,
                'a' => $aa3 = null,
                'b' => $aa4 = [],
                'c' => $aa5 = new \StdClass(),
                'd' => $aa6 = new \ArrayObject([
                    0   => $aaa1 = null,
                    ''  => $aaa2 = null,
                    'a' => $aaa3 = null,
                    'b' => $aaa4 = [],
                    'c' => $aaa5 = new \StdClass(),
                ]),
            ],
        ];

        $fullpathes = [];
        $values = [];
        $arr->walk_recursive($array, function (&$value, $fullpath) use (&$fullpathes, &$values) {
            $fullpathes[] = $fullpath;
            $values[] = $value;
        });

        $this->assertEquals([
            [ 0 ],
            [ '' ],
            [ 'a' ],
            [ 'b' ],
            [ 'c' ],
            [ 'd' ],

            [ 'd', 0 ],
            [ 'd', '' ],
            [ 'd', 'a' ],
            [ 'd', 'b' ],
            [ 'd', 'c' ],
            [ 'd', 'd' ],
        ], $fullpathes);

        $this->assertEquals([
            $a1,
            $a2,
            $a3,
            $a4,
            $a5,
            $a6,

            $aa1,
            $aa2,
            $aa3,
            $aa4,
            $aa5,
            $aa6,
        ], $values);

        $fullpathes = [];
        $arr->walk_recursive($array, function (&$value, $fullpath) use (&$fullpathes) {
            $value = 123;

            $fullpathes[] = $fullpath;
        });

        $this->assertEquals([
            [ 0 ],
            [ '' ],
            [ 'a' ],
            [ 'b' ],
            [ 'c' ],
            [ 'd' ],
        ], $fullpathes);

        $this->assertEquals([
            0   => 123,
            ""  => 123,
            "a" => 123,
            "b" => 123,
            "c" => 123,
            "d" => 123,
        ], $array);
    }

    public function testCrawlRecursive()
    {
        $arr = $this->getArr();

        $array = [
            0   => $a1 = null,
            ''  => $a2 = null,
            'a' => $a3 = null,
            'b' => $a4 = [],
            'c' => $a5 = new \StdClass(),
            'd' => $a6 = [
                0   => $aa1 = null,
                ''  => $aa2 = null,
                'a' => $aa3 = null,
                'b' => $aa4 = [],
                'c' => $aa5 = new \StdClass(),
                'd' => $aa6 = new \ArrayObject([
                    0   => $aaa1 = null,
                    ''  => $aaa2 = null,
                    'a' => $aaa3 = null,
                    'b' => $aaa4 = [],
                    'c' => $aaa5 = new \StdClass(),
                ]),
            ],
        ];

        $fullpathes = [];
        $values = [];
        $arr->crawl_recursive($array, function (&$value, $fullpath) use (&$fullpathes, &$values) {
            $fullpathes[] = $fullpath;
            $values[] = $value;
        });

        $this->assertEquals([
            [ 0 ],
            [ '' ],
            [ 'a' ],
            [ 'b' ],
            [ 'c' ],
            [ 'd' ],

            [ 'd', 0 ],
            [ 'd', '' ],
            [ 'd', 'a' ],
            [ 'd', 'b' ],
            [ 'd', 'c' ],
            [ 'd', 'd' ],

            [ 'd', 'd', 0 ],
            [ 'd', 'd', '' ],
            [ 'd', 'd', 'a' ],
            [ 'd', 'd', 'b' ],
            [ 'd', 'd', 'c' ],
        ], $fullpathes);

        $this->assertEquals([
            $a1,
            $a2,
            $a3,
            $a4,
            $a5,
            $a6,

            $aa1,
            $aa2,
            $aa3,
            $aa4,
            $aa5,
            $aa6,

            $aaa1,
            $aaa2,
            $aaa3,
            $aaa4,
            $aaa5,
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
