<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\IStr;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class StrTest extends AbstractTestCase
{
    protected function getStr() : IStr
    {
        return Str::getInstance();
    }


    public function testTheStrvals()
    {
        $str = $this->getStr();

        $this->assertEquals([ '1' ], $str->theStrvals(1));
        $this->assertEquals([ '1' ], $str->theStrvals(1.0));
        $this->assertEquals([ '1.1' ], $str->theStrvals(1.1));
        $this->assertEquals([ '' ], $str->theStrvals(''));
        $this->assertEquals([ 'hello' ], $str->theStrvals('hello'));
        $this->assertEquals([ 'hello', 'hello' ], $str->theStrvals([ 'hello', 'hello' ]));
        $this->assertEquals([], $str->theStrvals([]));

        $this->assertEquals([ '1' ], $str->theStrvals([ 1 ]));
        $this->assertEquals([ '1' ], $str->theStrvals([ 1.0 ]));
        $this->assertEquals([ '1.1' ], $str->theStrvals([ 1.1 ]));
        $this->assertEquals([ '' ], $str->theStrvals([ '' ]));
        $this->assertEquals([ 'hello' ], $str->theStrvals([ 'hello' ]));
        $this->assertEquals([ 'hello', 'hello' ], $str->theStrvals([ 'hello', 'hello' ]));
        $this->assertEquals([], $str->theStrvals([ [] ]));

        $this->assertEquals([ '1' ], $str->theStrvals([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $str->theStrvals([ [ 1.0 ] ]));
        $this->assertEquals([ '1.1' ], $str->theStrvals([ [ 1.1 ] ]));
        $this->assertEquals([ '' ], $str->theStrvals([ [ '' ] ]));
        $this->assertEquals([ 'hello' ], $str->theStrvals([ [ 'hello' ] ]));
        $this->assertEquals([ 'hello', 'hello' ], $str->theStrvals([ [ 'hello' ], 'hello' ]));
        $this->assertEquals([], $str->theStrvals([ [ [] ] ]));
    }

    public function testBadTheStrvals()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theStrvals([ [ new \StdClass() ] ]);
        });
    }


    public function testTheWordvals()
    {
        $str = $this->getStr();

        $this->assertEquals([ '1' ], $str->theWordvals(1));
        $this->assertEquals([ '1' ], $str->theWordvals(1.0));
        $this->assertEquals([ '1.1' ], $str->theWordvals(1.1));
        $this->assertEquals([ 'hello' ], $str->theWordvals('hello'));
        $this->assertEquals([ 'hello', 'hello' ], $str->theWordvals([ 'hello', 'hello' ]));
        $this->assertEquals([], $str->theWordvals([]));

        $this->assertEquals([ '1' ], $str->theWordvals([ 1 ]));
        $this->assertEquals([ '1' ], $str->theWordvals([ 1.0 ]));
        $this->assertEquals([ '1.1' ], $str->theWordvals([ 1.1 ]));
        $this->assertEquals([ 'hello' ], $str->theWordvals([ 'hello' ]));
        $this->assertEquals([ 'hello', 'hello' ], $str->theWordvals([ 'hello', 'hello' ]));
        $this->assertEquals([], $str->theWordvals([ [] ]));

        $this->assertEquals([ '1' ], $str->theWordvals([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $str->theWordvals([ [ 1.0 ] ]));
        $this->assertEquals([ '1.1' ], $str->theWordvals([ [ 1.1 ] ]));
        $this->assertEquals([ 'hello' ], $str->theWordvals([ [ 'hello' ] ]));
        $this->assertEquals([ 'hello', 'hello' ], $str->theWordvals([ [ 'hello' ], 'hello' ]));
        $this->assertEquals([], $str->theWordvals([ [ [] ] ]));
    }

    public function testBadTheWordvals()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals('');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ '' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ [ '' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->theWordvals([ [ new \StdClass() ] ]);
        });
    }


    public function testReplace()
    {
        $str = $this->getStr();

        $this->assertEquals('baa', $str->replace('a', 'b', 'aaa', 1));
        $this->assertEquals('bba', $str->replace('a', 'b', 'aaa', 2));
        $this->assertEquals('aab', $str->replace('a', 'b', 'aaa', -1));
        $this->assertEquals('abb', $str->replace('a', 'b', 'aaa', -2));
    }

    public function testIreplace()
    {
        $str = $this->getStr();

        $this->assertEquals('bAa', $str->ireplace('A', 'b', 'aAa', 1));
        $this->assertEquals('bba', $str->ireplace('A', 'b', 'aAa', 2));
        $this->assertEquals('aAb', $str->ireplace('A', 'b', 'aAa', -1));
        $this->assertEquals('abb', $str->ireplace('A', 'b', 'aAa', -2));
    }


    public function testLcrop()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->lcrop('', ''));
        $this->assertEquals('', $str->lcrop('', '', false));
        $this->assertEquals('', $str->lcrop('', '', false, 0));
        $this->assertEquals('', $str->lcrop('', '', false, 1));
        $this->assertEquals('', $str->lcrop('', '', true));
        $this->assertEquals('', $str->lcrop('', '', true, 0));
        $this->assertEquals('', $str->lcrop('', '', true, 1));

        $this->assertEquals('', $str->lcrop('', 'A'));
        $this->assertEquals('', $str->lcrop('', 'A', false));
        $this->assertEquals('', $str->lcrop('', 'A', false, 0));
        $this->assertEquals('', $str->lcrop('', 'A', false, 1));
        $this->assertEquals('', $str->lcrop('', 'A', true));
        $this->assertEquals('', $str->lcrop('', 'A', true, 0));
        $this->assertEquals('', $str->lcrop('', 'A', true, 1));

        $this->assertEquals('a', $str->lcrop('a', ''));
        $this->assertEquals('a', $str->lcrop('a', '', false));
        $this->assertEquals('a', $str->lcrop('a', '', false, 0));
        $this->assertEquals('a', $str->lcrop('a', '', false, 1));
        $this->assertEquals('a', $str->lcrop('a', '', true));
        $this->assertEquals('a', $str->lcrop('a', '', true, 0));
        $this->assertEquals('a', $str->lcrop('a', '', true, 1));

        $this->assertEquals('', $str->lcrop('a', 'A'));
        $this->assertEquals('a', $str->lcrop('a', 'A', false));
        $this->assertEquals('a', $str->lcrop('a', 'A', false, 0));
        $this->assertEquals('a', $str->lcrop('a', 'A', false, 1));
        $this->assertEquals('', $str->lcrop('a', 'A', true));
        $this->assertEquals('a', $str->lcrop('a', 'A', true, 0));
        $this->assertEquals('', $str->lcrop('a', 'A', true, 1));

        $this->assertEquals('b', $str->lcrop('b', 'A'));
        $this->assertEquals('b', $str->lcrop('b', 'A', false));
        $this->assertEquals('b', $str->lcrop('b', 'A', false, 0));
        $this->assertEquals('b', $str->lcrop('b', 'A', false, 1));
        $this->assertEquals('b', $str->lcrop('b', 'A', true));
        $this->assertEquals('b', $str->lcrop('b', 'A', true, 0));
        $this->assertEquals('b', $str->lcrop('b', 'A', true, 1));

        $this->assertEquals('baa', $str->lcrop('aabaa', 'A'));
        $this->assertEquals('aabaa', $str->lcrop('aabaa', 'A', false));
        $this->assertEquals('aabaa', $str->lcrop('aabaa', 'A', false, 0));
        $this->assertEquals('aabaa', $str->lcrop('aabaa', 'A', false, 1));
        $this->assertEquals('baa', $str->lcrop('aabaa', 'A', true));
        $this->assertEquals('aabaa', $str->lcrop('aabaa', 'A', true, 0));
        $this->assertEquals('abaa', $str->lcrop('aabaa', 'A', true, 1));
    }

    public function testRcrop()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->rcrop('', ''));
        $this->assertEquals('', $str->rcrop('', '', false));
        $this->assertEquals('', $str->rcrop('', '', false, 0));
        $this->assertEquals('', $str->rcrop('', '', false, 1));
        $this->assertEquals('', $str->rcrop('', '', true));
        $this->assertEquals('', $str->rcrop('', '', true, 0));
        $this->assertEquals('', $str->rcrop('', '', true, 1));

        $this->assertEquals('', $str->rcrop('', 'A'));
        $this->assertEquals('', $str->rcrop('', 'A', false));
        $this->assertEquals('', $str->rcrop('', 'A', false, 0));
        $this->assertEquals('', $str->rcrop('', 'A', false, 1));
        $this->assertEquals('', $str->rcrop('', 'A', true));
        $this->assertEquals('', $str->rcrop('', 'A', true, 0));
        $this->assertEquals('', $str->rcrop('', 'A', true, 1));

        $this->assertEquals('a', $str->rcrop('a', ''));
        $this->assertEquals('a', $str->rcrop('a', '', false));
        $this->assertEquals('a', $str->rcrop('a', '', false, 0));
        $this->assertEquals('a', $str->rcrop('a', '', false, 1));
        $this->assertEquals('a', $str->rcrop('a', '', true));
        $this->assertEquals('a', $str->rcrop('a', '', true, 0));
        $this->assertEquals('a', $str->rcrop('a', '', true, 1));

        $this->assertEquals('', $str->rcrop('a', 'A'));
        $this->assertEquals('a', $str->rcrop('a', 'A', false));
        $this->assertEquals('a', $str->rcrop('a', 'A', false, 0));
        $this->assertEquals('a', $str->rcrop('a', 'A', false, 1));
        $this->assertEquals('', $str->rcrop('a', 'A', true));
        $this->assertEquals('a', $str->rcrop('a', 'A', true, 0));
        $this->assertEquals('', $str->rcrop('a', 'A', true, 1));

        $this->assertEquals('b', $str->rcrop('b', 'A'));
        $this->assertEquals('b', $str->rcrop('b', 'A', false));
        $this->assertEquals('b', $str->rcrop('b', 'A', false, 0));
        $this->assertEquals('b', $str->rcrop('b', 'A', false, 1));
        $this->assertEquals('b', $str->rcrop('b', 'A', true));
        $this->assertEquals('b', $str->rcrop('b', 'A', true, 0));
        $this->assertEquals('b', $str->rcrop('b', 'A', true, 1));

        $this->assertEquals('aab', $str->rcrop('aabaa', 'A'));
        $this->assertEquals('aabaa', $str->rcrop('aabaa', 'A', false));
        $this->assertEquals('aabaa', $str->rcrop('aabaa', 'A', false, 0));
        $this->assertEquals('aabaa', $str->rcrop('aabaa', 'A', false, 1));
        $this->assertEquals('aab', $str->rcrop('aabaa', 'A', true));
        $this->assertEquals('aabaa', $str->rcrop('aabaa', 'A', true, 0));
        $this->assertEquals('aaba', $str->rcrop('aabaa', 'A', true, 1));
    }

    public function testCrop()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->crop('', ''));
        $this->assertEquals('', $str->crop('', '', false));
        $this->assertEquals('', $str->crop('', '', false, 0));
        $this->assertEquals('', $str->crop('', '', false, 1));
        $this->assertEquals('', $str->crop('', '', true));
        $this->assertEquals('', $str->crop('', '', true, 0));
        $this->assertEquals('', $str->crop('', '', true, 1));

        $this->assertEquals('', $str->crop('', 'A'));
        $this->assertEquals('', $str->crop('', 'A', false));
        $this->assertEquals('', $str->crop('', 'A', false, 0));
        $this->assertEquals('', $str->crop('', 'A', false, 1));
        $this->assertEquals('', $str->crop('', 'A', true));
        $this->assertEquals('', $str->crop('', 'A', true, 0));
        $this->assertEquals('', $str->crop('', 'A', true, 1));

        $this->assertEquals('a', $str->crop('a', ''));
        $this->assertEquals('a', $str->crop('a', '', false));
        $this->assertEquals('a', $str->crop('a', '', false, 0));
        $this->assertEquals('a', $str->crop('a', '', false, 1));
        $this->assertEquals('a', $str->crop('a', '', true));
        $this->assertEquals('a', $str->crop('a', '', true, 0));
        $this->assertEquals('a', $str->crop('a', '', true, 1));

        $this->assertEquals('', $str->crop('a', 'A'));
        $this->assertEquals('a', $str->crop('a', 'A', false));
        $this->assertEquals('a', $str->crop('a', 'A', false, 0));
        $this->assertEquals('a', $str->crop('a', 'A', false, 1));
        $this->assertEquals('', $str->crop('a', 'A', true));
        $this->assertEquals('a', $str->crop('a', 'A', true, 0));
        $this->assertEquals('', $str->crop('a', 'A', true, 1));

        $this->assertEquals('b', $str->crop('b', 'A'));
        $this->assertEquals('b', $str->crop('b', 'A', false));
        $this->assertEquals('b', $str->crop('b', 'A', false, 0));
        $this->assertEquals('b', $str->crop('b', 'A', false, 1));
        $this->assertEquals('b', $str->crop('b', 'A', true));
        $this->assertEquals('b', $str->crop('b', 'A', true, 0));
        $this->assertEquals('b', $str->crop('b', 'A', true, 1));

        $this->assertEquals('b', $str->crop('aabaa', 'A'));
        $this->assertEquals('aabaa', $str->crop('aabaa', 'A', false));
        $this->assertEquals('aabaa', $str->crop('aabaa', 'A', false, 0));
        $this->assertEquals('aabaa', $str->crop('aabaa', 'A', false, 1));
        $this->assertEquals('b', $str->crop('aabaa', 'A', true));
        $this->assertEquals('aabaa', $str->crop('aabaa', 'A', true, 0));
        $this->assertEquals('aba', $str->crop('aabaa', 'A', true, 1));
    }


    public function testStarts()
    {
        $str = $this->getStr();

        $this->assertEquals(null, $str->starts('hell', 'hello'));
        $this->assertEquals('', $str->starts('hello', 'hello'));
        $this->assertEquals(' world', $str->starts('hello world', 'hello'));

        $this->assertEquals(null, $str->starts('Hello', 'hello', false));

        $this->assertEquals(null, $str->starts('Hell', 'Hello', false));
        $this->assertEquals('', $str->starts('Hello', 'Hello', false));
        $this->assertEquals(' World', $str->starts('Hello World', 'Hello', false));
    }

    public function testEnds()
    {
        $str = $this->getStr();

        $this->assertEquals(null, $str->ends('word', 'world'));
        $this->assertEquals('', $str->ends('world', 'world'));
        $this->assertEquals('hello ', $str->ends('hello world', 'world'));

        $this->assertEquals(null, $str->ends('Hello', 'hello', false));

        $this->assertEquals(null, $str->ends('Word', 'World', false));
        $this->assertEquals('', $str->ends('World', 'World', false));
        $this->assertEquals('Hello ', $str->ends('Hello World', 'World', false));
    }

    public function testContains()
    {
        $str = $this->getStr();

        $this->assertEquals([], $str->contains('word', 'world'));
        $this->assertEquals([ '', '' ], $str->contains('world', 'world'));
        $this->assertEquals([ 'hello ', '' ], $str->contains('hello world', 'world'));

        $this->assertEquals([], $str->contains('Hello', 'hello', null, false));

        $this->assertEquals([], $str->contains('Word', 'World', null, false));
        $this->assertEquals([ '', '' ], $str->contains('World', 'World', null, false));
        $this->assertEquals([ 'Hello ', '' ], $str->contains('Hello World', 'World', null, false));
    }


    public function testUnltrim()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->unltrim(''));
        $this->assertEquals('', $str->unltrim('', ''));
        $this->assertEquals('$', $str->unltrim('', '$'));
        $this->assertEquals('$$', $str->unltrim('', '$', 2));

        $this->assertEquals('a', $str->unltrim('a'));
        $this->assertEquals('a', $str->unltrim('a', ''));
        $this->assertEquals('$a', $str->unltrim('a', '$'));
        $this->assertEquals('$$a', $str->unltrim('a', '$', 2));

        $this->assertEquals('$', $str->unltrim('$'));
        $this->assertEquals('$', $str->unltrim('$', ''));
        $this->assertEquals('$$', $str->unltrim('$', '$'));
        $this->assertEquals('$$$', $str->unltrim('$', '$', 2));
    }

    public function testUnrtrim()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->unrtrim(''));
        $this->assertEquals('', $str->unrtrim('', ''));
        $this->assertEquals('$', $str->unrtrim('', '$'));
        $this->assertEquals('$$', $str->unrtrim('', '$', 2));

        $this->assertEquals('a', $str->unrtrim('a'));
        $this->assertEquals('a', $str->unrtrim('a', ''));
        $this->assertEquals('a$', $str->unrtrim('a', '$'));
        $this->assertEquals('a$$', $str->unrtrim('a', '$', 2));

        $this->assertEquals('$', $str->unltrim('$'));
        $this->assertEquals('$', $str->unltrim('$', ''));
        $this->assertEquals('$$', $str->unltrim('$', '$'));
        $this->assertEquals('$$$', $str->unltrim('$', '$', 2));
    }

    public function testUntrim()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->untrim('', null));
        $this->assertEquals('', $str->untrim('', ''));
        $this->assertEquals('$$', $str->untrim('', '$'));
        $this->assertEquals('$$$$', $str->untrim('', '$', 2));

        $this->assertEquals('a', $str->untrim('a', null));
        $this->assertEquals('a', $str->untrim('a', ''));
        $this->assertEquals('$a$', $str->untrim('a', '$'));
        $this->assertEquals('$$a$$', $str->untrim('a', '$', 2));

        $this->assertEquals('$', $str->untrim('$', null));
        $this->assertEquals('$', $str->untrim('$', ''));
        $this->assertEquals('$$$', $str->untrim('$', '$'));
        $this->assertEquals('$$$$$', $str->untrim('$', '$', 2));
    }


    public function testPrepend()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->prepend('', ''));
        $this->assertEquals('A', $str->prepend('', 'A'));

        $this->assertEquals('a', $str->prepend('a', ''));
        $this->assertEquals('a', $str->prepend('a', 'A'));

        $this->assertEquals('A', $str->prepend('A', ''));
        $this->assertEquals('A', $str->prepend('A', 'A'));

        $this->assertEquals('', $str->prepend('', '', false));
        $this->assertEquals('A', $str->prepend('', 'A', false));

        $this->assertEquals('a', $str->prepend('a', '', false));
        $this->assertEquals('Aa', $str->prepend('a', 'A', false));

        $this->assertEquals('A', $str->prepend('A', '', false));
        $this->assertEquals('A', $str->prepend('A', 'A', false));
    }

    public function testAppend()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->append('', ''));
        $this->assertEquals('A', $str->append('', 'A'));

        $this->assertEquals('a', $str->append('a', ''));
        $this->assertEquals('a', $str->append('a', 'A'));

        $this->assertEquals('A', $str->append('A', ''));
        $this->assertEquals('A', $str->append('A', 'A'));

        $this->assertEquals('', $str->append('', '', false));
        $this->assertEquals('A', $str->append('', 'A', false));

        $this->assertEquals('a', $str->append('a', '', false));
        $this->assertEquals('aA', $str->append('a', 'A', false));

        $this->assertEquals('A', $str->append('A', '', false));
        $this->assertEquals('A', $str->append('A', 'A', false));
    }

    public function testWrap()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->wrap('', ''));
        $this->assertEquals('A', $str->wrap('', 'A'));

        $this->assertEquals('a', $str->wrap('a', ''));
        $this->assertEquals('a', $str->wrap('a', 'A'));

        $this->assertEquals('A', $str->wrap('A', ''));
        $this->assertEquals('A', $str->wrap('A', 'A'));

        $this->assertEquals('', $str->wrap('', '', false));
        $this->assertEquals('A', $str->wrap('', 'A', false));

        $this->assertEquals('a', $str->wrap('a', '', false));
        $this->assertEquals('AaA', $str->wrap('a', 'A', false));

        $this->assertEquals('A', $str->wrap('A', '', false));
        $this->assertEquals('A', $str->wrap('A', 'A', false));
    }


    public function testSegregate()
    {
        $str = $this->getStr();

        $this->assertEquals([ 'dadbdcd' ], $str->explode('', 'dadbdcd'));
        $this->assertEquals([ 'dadbdcd' ], $str->explode([ '' ], 'dadbdcd'));

        $this->assertEquals([ 'dadbdcd' ], $str->explode('?', 'dadbdcd'));
        $this->assertEquals([ 'dadbdcd' ], $str->explode([ '?' ], 'dadbdcd'));

        $this->assertEquals([ 'd', 'dbdcd' ], $str->explode('a', 'dadbdcd'));
        $this->assertEquals([ 'd', 'dbdcd' ], $str->explode([ 'a' ], 'dadbdcd'));

        $this->assertEquals([ 'd', 'd', 'dcd' ], $str->explode([ 'a', 'b' ], 'dadbdcd'));
        $this->assertEquals([ 'd', 'd', 'd', 'd' ], $str->explode([ 'a', 'b', 'c' ], 'dadbdcd'));
    }

    public function testBadSegregate()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $this->assertEquals([ 'dadbdcd' ], $str->explode(null, 'dadbdcd'));
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $this->assertEquals([ 'dadbdcd' ], $str->explode([ null ], 'dadbdcd'));
        });
    }


    public function testSeparate()
    {
        $str = $this->getStr();

        $this->assertEquals([ 'dadbdcd' ], $str->separate('', 'dadbdcd'));
        $this->assertEquals([ 'dadbdcd' ], $str->separate([ '' ], 'dadbdcd'));

        $this->assertEquals([ 'dadbdcd' ], $str->separate('?', 'dadbdcd'));
        $this->assertEquals([ 'dadbdcd' ], $str->separate([ '?' ], 'dadbdcd'));

        $this->assertEquals([ 'd', 'dbdcd' ], $str->separate('a', 'dadbdcd'));
        $this->assertEquals([ 'd', 'dbdcd' ], $str->separate([ 'a' ], 'dadbdcd'));

        $this->assertEquals([ [ 'd' ], [ 'd', 'dcd' ] ], $str->separate([ 'a', 'b' ], 'dadbdcd'));
        $this->assertEquals([ [ [ 'd' ] ], [ [ 'd' ], [ 'd', 'd' ] ] ], $str->separate([ 'a', 'b', 'c' ], 'dadbdcd'));
    }

    public function testBadSeparate()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->separate(null, 'dadbdcd');
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->separate([ null ], 'dadbdcd');
        });
    }


    public function testExplode()
    {
        $str = $this->getStr();

        $this->assertEquals([ 'dadbdcd' ], $str->explode('', 'dadbdcd'));
        $this->assertEquals([ 'dadbdcd' ], $str->explode([ '' ], 'dadbdcd'));

        $this->assertEquals([ 'dadbdcd' ], $str->explode('?', 'dadbdcd'));
        $this->assertEquals([ 'dadbdcd' ], $str->explode([ '?' ], 'dadbdcd'));

        $this->assertEquals([ 'd', 'dbdcd' ], $str->explode('a', 'dadbdcd'));
        $this->assertEquals([ 'd', 'dbdcd' ], $str->explode([ 'a' ], 'dadbdcd'));

        $this->assertEquals([ 'd', 'd', 'dcd' ], $str->explode([ 'a', 'b' ], 'dadbdcd'));
        $this->assertEquals([ 'd', 'd', 'd', 'd' ], $str->explode([ 'a', 'b', 'c' ], 'dadbdcd'));
    }

    public function testBadExplode()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->explode(null, 'dadbdcd');
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->explode([ null ], 'dadbdcd');
        });
    }


    public function testPartition()
    {
        $str = $this->getStr();

        $this->assertEquals('dadbdcd', $str->partition('', 'dadbdcd'));
        $this->assertEquals('dadbdcd', $str->partition([ '' ], 'dadbdcd'));

        $this->assertEquals('dadbdcd', $str->partition('?', 'dadbdcd'));
        $this->assertEquals('dadbdcd', $str->partition([ '?' ], 'dadbdcd'));

        $this->assertEquals([ 'd', 'dbdcd' ], $str->partition('a', 'dadbdcd'));
        $this->assertEquals([ 'd', 'dbdcd' ], $str->partition([ 'a' ], 'dadbdcd'));

        $this->assertEquals([ 'd', [ 'd', 'dcd' ] ], $str->partition([ 'a', 'b' ], 'dadbdcd'));
        $this->assertEquals([ 'd', [ 'd', [ 'd', 'd' ] ] ], $str->partition([ 'a', 'b', 'c' ], 'dadbdcd'));
    }

    public function testBadPartition()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->partition(null, 'dadbdcd');
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->partition([ null ], 'dadbdcd');
        });
    }


    public function testImplode()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->implode(''));
        $this->assertEquals('', $str->implode('', []));

        $parts = [ '', ',', 'a', ',a', [ '', ',', 'a', ',a' ] ];

        $this->assertEquals(',a,a,a,a', $str->implodeSkip('', ...$parts));
        $this->assertEquals('a,a,a,a', $str->implodeSkip(',', ...$parts));
    }

    public function testImplodeskip()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->implodeSkip('', null));
        $this->assertEquals('', $str->implodeSkip('', [ null ]));
        $this->assertEquals('', $str->implodeSkip('', []));
        $this->assertEquals('', $str->implodeSkip('', []));

        $parts = [ null, '', ',', 'a', ',a', new \StdClass(), [ null, '', ',', 'a', ',a', new \StdClass() ] ];

        $this->assertEquals(',a,a,a,a', $str->implodeSkip('', ...$parts));
        $this->assertEquals('a,a,a,a', $str->implodeSkip(',', ...$parts));
    }

    public function testBadImplode()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->implode('', null);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->implode('', [ null ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->implode('', [ new \StdClass() ]);
        });
    }


    public function testJoin()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->join(''));
        $this->assertEquals('', $str->join('', []));

        $parts = [ '', ',', 'a', ',a', [ '', ',', 'a', ',a' ] ];

        $this->assertEquals(',a,a,a,a', $str->join('', ...$parts));
        $this->assertEquals(',a,a,,a,a', $str->join(',', ...$parts));
    }

    public function testJoinskip()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->joinSkip('', null));
        $this->assertEquals('', $str->joinSkip('', [ null ]));
        $this->assertEquals('', $str->joinSkip(''));
        $this->assertEquals('', $str->joinSkip('', []));

        $parts = [ null, '', ',', 'a', ',a', new \StdClass(), [ null, '', ',', 'a', ',a', new \StdClass() ] ];

        $this->assertEquals(',a,a,a,a', $str->joinSkip('', ...$parts));
        $this->assertEquals('a,a,a,a', $str->joinSkip(',', ...$parts));
    }

    public function testBadJoin()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->join('', null);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->join('', [ null ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->join('', [ new \StdClass() ]);
        });
    }


    public function testConcat()
    {
        $str = $this->getStr();

        $parts = [ [ 'a', 'b' ], 'c', [ 'd' ] ];

        $this->assertEquals('abcd', $str->concat($parts));
        $this->assertEquals('abcd', $str->concat($parts, ''));
        $this->assertEquals('a,b,c,d', $str->concat($parts, ','));

        $this->assertEquals('abcd', $str->concat($parts, null, ''));
        $this->assertEquals('abcd', $str->concat($parts, '', ''));
        $this->assertEquals('a,b,cd', $str->concat($parts, ',', ''));

        $this->assertEquals('abc or d', $str->concat($parts, null, ' or '));
        $this->assertEquals('abc or d', $str->concat($parts, '', ' or '));
        $this->assertEquals('a,b,c or d', $str->concat($parts, ',', ' or '));

        $this->assertEquals('"a""b""c""d"', $str->concat($parts, null, null, '"'));
        $this->assertEquals('"a""b""c""d"', $str->concat($parts, '', null, '"'));
        $this->assertEquals('"a","b","c","d"', $str->concat($parts, ',', null, '"'));

        $this->assertEquals('"a""b""c""d"', $str->concat($parts, null, '', '"'));
        $this->assertEquals('"a""b""c""d"', $str->concat($parts, '', '', '"'));
        $this->assertEquals('"a","b","c""d"', $str->concat($parts, ',', '', '"'));

        $this->assertEquals('"a""b""c" or "d"', $str->concat($parts, null, ' or ', '"'));
        $this->assertEquals('"a""b""c" or "d"', $str->concat($parts, '', ' or ', '"'));
        $this->assertEquals('"a","b","c" or "d"', $str->concat($parts, ',', ' or ', '"'));
    }

    public function testConcatskip()
    {
        $str = $this->getStr();

        $parts = [ [ 'a', 'b' ], 'c', [ 'd' ], new \StdClass() ];

        $this->assertEquals('abcd', $str->concatSkip($parts));
        $this->assertEquals('abcd', $str->concatSkip($parts, ''));
        $this->assertEquals('a,b,c,d', $str->concatSkip($parts, ','));

        $this->assertEquals('abcd', $str->concatSkip($parts, null, ''));
        $this->assertEquals('abcd', $str->concatSkip($parts, '', ''));
        $this->assertEquals('a,b,cd', $str->concatSkip($parts, ',', ''));

        $this->assertEquals('abc or d', $str->concatSkip($parts, null, ' or '));
        $this->assertEquals('abc or d', $str->concatSkip($parts, '', ' or '));
        $this->assertEquals('a,b,c or d', $str->concatSkip($parts, ',', ' or '));

        $this->assertEquals('"a""b""c""d"', $str->concatSkip($parts, null, null, '"'));
        $this->assertEquals('"a""b""c""d"', $str->concatSkip($parts, '', null, '"'));
        $this->assertEquals('"a","b","c","d"', $str->concatSkip($parts, ',', null, '"'));

        $this->assertEquals('"a""b""c""d"', $str->concatSkip($parts, null, '', '"'));
        $this->assertEquals('"a""b""c""d"', $str->concatSkip($parts, '', '', '"'));
        $this->assertEquals('"a","b","c""d"', $str->concatSkip($parts, ',', '', '"'));

        $this->assertEquals('"a""b""c" or "d"', $str->concatSkip($parts, null, ' or ', '"'));
        $this->assertEquals('"a""b""c" or "d"', $str->concatSkip($parts, '', ' or ', '"'));
        $this->assertEquals('"a","b","c" or "d"', $str->concatSkip($parts, ',', ' or ', '"'));
    }

    public function testBadConcat()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->concat(null);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->concat([ null ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->concat([ new \StdClass() ]);
        });
    }


    public function testMatch()
    {
        $str = $this->getStr();

        $this->assertEquals([ 'world', 'foo' ], $str->match('{', '}', 'Hello {world} {foo} bar'));

        $this->assertEquals([ 'World', 'Foo' ], $str->match('a', 'a', 'Hello AWorldA AFooA bar'));

        $this->assertEquals([], $str->match('a', 'a', 'Hello AWorldA AFooA bar', null, false));
        $this->assertEquals([ 'World', 'Foo' ], $str->match('A', 'A', 'Hello AWorldA AFooA bar', null, false));
    }


    public function testPrefix()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->prefix('aaa', 0));

        $this->assertEquals('11', $str->prefix('11'));
        $this->assertEquals('11', $str->prefix('11', 3));
        $this->assertEquals('11', $str->prefix('11', 4));

        $this->assertEquals('aa', $str->prefix('aa'));
        $this->assertEquals('aa', $str->prefix('aa', 3));
        $this->assertEquals('aa', $str->prefix('aa', 4));

        $this->assertEquals('bbb', $str->prefix('bbbb'));
        $this->assertEquals('bbb', $str->prefix('bbbb', 3));
        $this->assertEquals('bbbb', $str->prefix('bbbb', 4));

        $this->assertEquals('a11', $str->prefix('aa11'));
        $this->assertEquals('a11', $str->prefix('aa11', 3));
        $this->assertEquals('aa11', $str->prefix('aa11', 4));

        $this->assertEquals('usr', $str->prefix('user'));
        $this->assertEquals('usr', $str->prefix('user', 3));
        $this->assertEquals('user', $str->prefix('user', 4));

        $this->assertEquals('opr', $str->prefix('operator'));
        $this->assertEquals('opr', $str->prefix('operator', 3));
        $this->assertEquals('oprt', $str->prefix('operator', 4));

        $this->assertEquals('usr', $str->prefix('user_operator'));
        $this->assertEquals('usr', $str->prefix('user_operator', 3));
        $this->assertEquals('usrp', $str->prefix('user_operator', 4));
    }

    public function testCompact()
    {
        $str = $this->getStr();

        $this->assertEquals('usropr', $str->compact('user_operator', '_'));
        $this->assertEquals('usropr', $str->compact('user_operator', '_', 3));
        $this->assertEquals('useroprt', $str->compact('user_operator', '_', 4));
    }


    public function testCamel()
    {
        $str = $this->getStr();

        $this->assertEquals('helloworld', $str->camel('helloworld'));
        $this->assertEquals('helloWorld', $str->camel('HelloWorld'));
        $this->assertEquals('helloWorld', $str->camel('hello-world'));
        $this->assertEquals('helloWorld', $str->camel('hello_world'));
        $this->assertEquals('helloWorld', $str->camel('Hello-World'));
        $this->assertEquals('helloWorld', $str->camel('Hello World'));
        $this->assertEquals('helloWorld', $str->camel('Hello_World'));

        $this->assertEquals('hello.world', $str->camel('hello.world', '.'));
        $this->assertEquals('hello.World', $str->camel('Hello.World', '.'));
        $this->assertEquals('helloworld.foo', $str->camel('helloworld.foo', '.'));
        $this->assertEquals('helloWorld.foo', $str->camel('HelloWorld.foo', '.'));
        $this->assertEquals('helloWorld.foo', $str->camel('hello world.foo', '.'));
        $this->assertEquals('helloWorld.foo', $str->camel('hello-world.foo', '.'));
        $this->assertEquals('helloWorld.foo', $str->camel('hello_world.foo', '.'));
        $this->assertEquals('helloWorld.foo', $str->camel('Hello-World.foo', '.'));
        $this->assertEquals('helloWorld.foo', $str->camel('Hello World.foo', '.'));
        $this->assertEquals('helloWorld.foo', $str->camel('Hello_World.foo', '.'));

        $this->assertEquals('helloId', $str->camel([ 'hello', 'id' ]));
    }

    public function testPascal()
    {
        $str = $this->getStr();

        $this->assertEquals('Helloworld', $str->pascal('helloworld'));
        $this->assertEquals('HelloWorld', $str->pascal('HelloWorld'));
        $this->assertEquals('HelloWorld', $str->pascal('hello-world'));
        $this->assertEquals('HelloWorld', $str->pascal('hello_world'));
        $this->assertEquals('HelloWorld', $str->pascal('Hello-World'));
        $this->assertEquals('HelloWorld', $str->pascal('Hello World'));
        $this->assertEquals('HelloWorld', $str->pascal('Hello_World'));

        $this->assertEquals('Hello.world', $str->pascal('hello.world', '.'));
        $this->assertEquals('Hello.World', $str->pascal('Hello.World', '.'));
        $this->assertEquals('Helloworld.foo', $str->pascal('helloworld.foo', '.'));
        $this->assertEquals('HelloWorld.foo', $str->pascal('HelloWorld.foo', '.'));
        $this->assertEquals('HelloWorld.foo', $str->pascal('hello world.foo', '.'));
        $this->assertEquals('HelloWorld.foo', $str->pascal('hello-world.foo', '.'));
        $this->assertEquals('HelloWorld.foo', $str->pascal('hello_world.foo', '.'));
        $this->assertEquals('HelloWorld.foo', $str->pascal('Hello-World.foo', '.'));
        $this->assertEquals('HelloWorld.foo', $str->pascal('Hello World.foo', '.'));
        $this->assertEquals('HelloWorld.foo', $str->pascal('Hello_World.foo', '.'));

        $this->assertEquals('HelloId', $str->pascal([ 'hello', 'id' ]));
    }


    public function testSnake()
    {
        $str = $this->getStr();

        $this->assertEquals('helloworld', $str->snake('helloworld'));
        $this->assertEquals('hello_world', $str->snake('HelloWorld'));
        $this->assertEquals('hello_world', $str->snake('hello-world'));
        $this->assertEquals('hello_world', $str->snake('hello_world'));
        $this->assertEquals('hello_world', $str->snake('Hello-World'));
        $this->assertEquals('hello_world', $str->snake('Hello World'));
        $this->assertEquals('hello_world', $str->snake('Hello_World'));

        $this->assertEquals('hello.world', $str->snake('hello.world', '.'));
        $this->assertEquals('hello._world', $str->snake('Hello.World', '.'));
        $this->assertEquals('helloworld.foo', $str->snake('helloworld.foo', '.'));
        $this->assertEquals('hello_world.foo', $str->snake('HelloWorld.foo', '.'));
        $this->assertEquals('hello_world.foo', $str->snake('hello world.foo', '.'));
        $this->assertEquals('hello_world.foo', $str->snake('hello-world.foo', '.'));
        $this->assertEquals('hello_world.foo', $str->snake('hello_world.foo', '.'));
        $this->assertEquals('hello_world.foo', $str->snake('Hello-World.foo', '.'));
        $this->assertEquals('hello_world.foo', $str->snake('Hello World.foo', '.'));
        $this->assertEquals('hello_world.foo', $str->snake('Hello_World.foo', '.'));

        $this->assertEquals('hello.world', $str->snake('hello.world', null, '.'));
        $this->assertEquals('hello.world', $str->snake('Hello.World', null, '.'));
        $this->assertEquals('helloworld.foo', $str->snake('helloworld.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->snake('HelloWorld.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->snake('hello world.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->snake('hello-world.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->snake('hello_world.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->snake('Hello-World.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->snake('Hello World.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->snake('Hello_World.foo', null, '.'));

        $this->assertEquals('hello_id', $str->snake([ 'hello', 'id' ]));
        $this->assertEquals('hello.id', $str->snake([ 'hello', 'id' ], null, '.'));
    }

    public function testKebab()
    {
        $str = $this->getStr();

        $this->assertEquals('helloworld', $str->kebab('helloworld'));
        $this->assertEquals('hello-world', $str->kebab('HelloWorld'));
        $this->assertEquals('hello-world', $str->kebab('hello-world'));
        $this->assertEquals('hello-world', $str->kebab('hello_world'));
        $this->assertEquals('hello-world', $str->kebab('Hello-World'));
        $this->assertEquals('hello-world', $str->kebab('Hello World'));
        $this->assertEquals('hello-world', $str->kebab('Hello_World'));

        $this->assertEquals('hello.world', $str->kebab('hello.world', '.'));
        $this->assertEquals('hello.-world', $str->kebab('Hello.World', '.'));
        $this->assertEquals('helloworld.foo', $str->kebab('helloworld.foo', '.'));
        $this->assertEquals('hello-world.foo', $str->kebab('HelloWorld.foo', '.'));
        $this->assertEquals('hello-world.foo', $str->kebab('hello world.foo', '.'));
        $this->assertEquals('hello-world.foo', $str->kebab('hello-world.foo', '.'));
        $this->assertEquals('hello-world.foo', $str->kebab('hello_world.foo', '.'));
        $this->assertEquals('hello-world.foo', $str->kebab('Hello-World.foo', '.'));
        $this->assertEquals('hello-world.foo', $str->kebab('Hello World.foo', '.'));
        $this->assertEquals('hello-world.foo', $str->kebab('Hello_World.foo', '.'));

        $this->assertEquals('hello.world', $str->kebab('hello.world', null, '.'));
        $this->assertEquals('hello.world', $str->kebab('Hello.World', null, '.'));
        $this->assertEquals('helloworld.foo', $str->kebab('helloworld.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->kebab('HelloWorld.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->kebab('hello world.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->kebab('hello-world.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->kebab('hello_world.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->kebab('Hello-World.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->kebab('Hello World.foo', null, '.'));
        $this->assertEquals('hello.world.foo', $str->kebab('Hello_World.foo', null, '.'));

        $this->assertEquals('hello-id', $str->kebab([ 'hello', 'id' ]));
        $this->assertEquals('hello.id', $str->kebab([ 'hello', 'id' ], null, '.'));
    }


    public function testSlug()
    {
        $str = $this->getStr();

        $this->assertEquals('privet-mir', $str->slug('Привет Мир'));
        $this->assertEquals('workspace-settings', $str->slug('Wôrķšƥáçè ~~sèťtïñğš~~'));
        $this->assertEquals('set', $str->slug('Сеть'));
    }

    public function testSlugCase()
    {
        $str = $this->getStr();

        $this->assertEquals('Privet-Mir', $str->slugCase('Привет Мир'));
        $this->assertEquals('Workspace-settings', $str->slugCase('Wôrķšƥáçè ~~sèťtïñğš~~'));
    }


    public function testPluralize()
    {
        $str = $this->getStr();

        $this->assertEquals([ 'worlds' ], $str->pluralize('world'));
        $this->assertEquals([ 'persons', 'people' ], $str->pluralize('person'));
        $this->assertEquals([ 'persons' ], $str->pluralize('person', 1));
        $this->assertEquals([ 1 => 'people' ], $str->pluralize('person', 1, 1));
    }

    public function testSingularize()
    {
        $str = $this->getStr();

        $this->assertEquals([ 'world' ], $str->singularize('worlds'));
        $this->assertEquals([ 'person' ], $str->singularize('people'));
    }
}
