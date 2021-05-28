<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Php;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class StrTest extends AbstractTestCase
{
    protected function getFilter() : Filter
    {
        return new Filter();
    }

    protected function getPhp() : Php
    {
        return new Php(
            $this->getFilter()
        );
    }

    protected function getStr() : Str
    {
        return new Str(
            $this->getFilter()
        );
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


    public function testMatch()
    {
        $str = $this->getStr();

        $this->assertEquals([ 'world', 'foo' ], $str->match('{', '}', 'Hello {world} {foo} bar'));

        $this->assertEquals([ 'World', 'Foo' ], $str->match('a', 'a', 'Hello AWorldA AFooA bar'));

        $this->assertEquals([], $str->match('a', 'a', 'Hello AWorldA AFooA bar', null, false));
        $this->assertEquals([ 'World', 'Foo' ], $str->match('A', 'A', 'Hello AWorldA AFooA bar', null, false));
    }


    public function testLwrap()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->lwrap('', null));
        $this->assertEquals('', $str->lwrap('', ''));
        $this->assertEquals('$', $str->lwrap('', '$'));
        $this->assertEquals('$$', $str->lwrap('', '$', 2));

        $this->assertEquals('a', $str->lwrap('a', null));
        $this->assertEquals('a', $str->lwrap('a', ''));
        $this->assertEquals('$a', $str->lwrap('a', '$'));
        $this->assertEquals('$$a', $str->lwrap('a', '$', 2));

        $this->assertEquals('$', $str->lwrap('$', null));
        $this->assertEquals('$', $str->lwrap('$', ''));
        $this->assertEquals('$$', $str->lwrap('$', '$'));
        $this->assertEquals('$$$', $str->lwrap('$', '$', 2));
    }

    public function testRwrap()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->rwrap('', null));
        $this->assertEquals('', $str->rwrap('', ''));
        $this->assertEquals('$', $str->rwrap('', '$'));
        $this->assertEquals('$$', $str->rwrap('', '$', 2));

        $this->assertEquals('a', $str->rwrap('a', null));
        $this->assertEquals('a', $str->rwrap('a', ''));
        $this->assertEquals('a$', $str->rwrap('a', '$'));
        $this->assertEquals('a$$', $str->rwrap('a', '$', 2));

        $this->assertEquals('$', $str->lwrap('$', null));
        $this->assertEquals('$', $str->lwrap('$', ''));
        $this->assertEquals('$$', $str->lwrap('$', '$'));
        $this->assertEquals('$$$', $str->lwrap('$', '$', 2));
    }

    public function testWrap()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->wrap('', null));
        $this->assertEquals('', $str->wrap('', ''));
        $this->assertEquals('$$', $str->wrap('', '$'));
        $this->assertEquals('$$$$', $str->wrap('', '$', 2));

        $this->assertEquals('a', $str->wrap('a', null));
        $this->assertEquals('a', $str->wrap('a', ''));
        $this->assertEquals('$a$', $str->wrap('a', '$'));
        $this->assertEquals('$$a$$', $str->wrap('a', '$', 2));

        $this->assertEquals('$', $str->wrap('$', null));
        $this->assertEquals('$', $str->wrap('$', ''));
        $this->assertEquals('$$$', $str->wrap('$', '$'));
        $this->assertEquals('$$$$$', $str->wrap('$', '$', 2));
    }


    public function testPrepend()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->prepend('', null));
        $this->assertEquals('', $str->prepend('', ''));
        $this->assertEquals('A', $str->prepend('', 'A'));

        $this->assertEquals('a', $str->prepend('a', null));
        $this->assertEquals('a', $str->prepend('a', ''));
        $this->assertEquals('a', $str->prepend('a', 'A'));

        $this->assertEquals('A', $str->prepend('A', null));
        $this->assertEquals('A', $str->prepend('A', ''));
        $this->assertEquals('A', $str->prepend('A', 'A'));

        $this->assertEquals('', $str->prepend('', null, false));
        $this->assertEquals('', $str->prepend('', '', false));
        $this->assertEquals('A', $str->prepend('', 'A', false));

        $this->assertEquals('a', $str->prepend('a', null, false));
        $this->assertEquals('a', $str->prepend('a', '', false));
        $this->assertEquals('Aa', $str->prepend('a', 'A', false));

        $this->assertEquals('A', $str->prepend('A', null, false));
        $this->assertEquals('A', $str->prepend('A', '', false));
        $this->assertEquals('A', $str->prepend('A', 'A', false));
    }

    public function testAppend()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->append('', null));
        $this->assertEquals('', $str->append('', ''));
        $this->assertEquals('A', $str->append('', 'A'));

        $this->assertEquals('a', $str->append('a', null));
        $this->assertEquals('a', $str->append('a', ''));
        $this->assertEquals('a', $str->append('a', 'A'));

        $this->assertEquals('A', $str->append('A', null));
        $this->assertEquals('A', $str->append('A', ''));
        $this->assertEquals('A', $str->append('A', 'A'));

        $this->assertEquals('', $str->append('', null, false));
        $this->assertEquals('', $str->append('', '', false));
        $this->assertEquals('A', $str->append('', 'A', false));

        $this->assertEquals('a', $str->append('a', null, false));
        $this->assertEquals('a', $str->append('a', '', false));
        $this->assertEquals('aA', $str->append('a', 'A', false));

        $this->assertEquals('A', $str->append('A', null, false));
        $this->assertEquals('A', $str->append('A', '', false));
        $this->assertEquals('A', $str->append('A', 'A', false));
    }

    public function testUncrop()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->uncrop('', null));
        $this->assertEquals('', $str->uncrop('', ''));
        $this->assertEquals('A', $str->uncrop('', 'A'));

        $this->assertEquals('a', $str->uncrop('a', null));
        $this->assertEquals('a', $str->uncrop('a', ''));
        $this->assertEquals('a', $str->uncrop('a', 'A'));

        $this->assertEquals('A', $str->uncrop('A', null));
        $this->assertEquals('A', $str->uncrop('A', ''));
        $this->assertEquals('A', $str->uncrop('A', 'A'));

        $this->assertEquals('', $str->uncrop('', null, false));
        $this->assertEquals('', $str->uncrop('', '', false));
        $this->assertEquals('A', $str->uncrop('', 'A', false));

        $this->assertEquals('a', $str->uncrop('a', null, false));
        $this->assertEquals('a', $str->uncrop('a', '', false));
        $this->assertEquals('AaA', $str->uncrop('a', 'A', false));

        $this->assertEquals('A', $str->uncrop('A', null, false));
        $this->assertEquals('A', $str->uncrop('A', '', false));
        $this->assertEquals('A', $str->uncrop('A', 'A', false));
    }


    public function testLcrop()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->lcrop('', null));
        $this->assertEquals('', $str->lcrop('', null, false));
        $this->assertEquals('', $str->lcrop('', null, false, 0));
        $this->assertEquals('', $str->lcrop('', null, false, 1));
        $this->assertEquals('', $str->lcrop('', null, true));
        $this->assertEquals('', $str->lcrop('', null, true, 0));
        $this->assertEquals('', $str->lcrop('', null, true, 1));

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

        $this->assertEquals('a', $str->lcrop('a', null));
        $this->assertEquals('a', $str->lcrop('a', null, false));
        $this->assertEquals('a', $str->lcrop('a', null, false, 0));
        $this->assertEquals('a', $str->lcrop('a', null, false, 1));
        $this->assertEquals('a', $str->lcrop('a', null, true));
        $this->assertEquals('a', $str->lcrop('a', null, true, 0));
        $this->assertEquals('a', $str->lcrop('a', null, true, 1));

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

        $this->assertEquals('', $str->rcrop('', null));
        $this->assertEquals('', $str->rcrop('', null, false));
        $this->assertEquals('', $str->rcrop('', null, false, 0));
        $this->assertEquals('', $str->rcrop('', null, false, 1));
        $this->assertEquals('', $str->rcrop('', null, true));
        $this->assertEquals('', $str->rcrop('', null, true, 0));
        $this->assertEquals('', $str->rcrop('', null, true, 1));

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

        $this->assertEquals('a', $str->rcrop('a', null));
        $this->assertEquals('a', $str->rcrop('a', null, false));
        $this->assertEquals('a', $str->rcrop('a', null, false, 0));
        $this->assertEquals('a', $str->rcrop('a', null, false, 1));
        $this->assertEquals('a', $str->rcrop('a', null, true));
        $this->assertEquals('a', $str->rcrop('a', null, true, 0));
        $this->assertEquals('a', $str->rcrop('a', null, true, 1));

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

        $this->assertEquals('', $str->crop('', null));
        $this->assertEquals('', $str->crop('', null, false));
        $this->assertEquals('', $str->crop('', null, false, 0));
        $this->assertEquals('', $str->crop('', null, false, 1));
        $this->assertEquals('', $str->crop('', null, true));
        $this->assertEquals('', $str->crop('', null, true, 0));
        $this->assertEquals('', $str->crop('', null, true, 1));

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

        $this->assertEquals('a', $str->crop('a', null));
        $this->assertEquals('a', $str->crop('a', null, false));
        $this->assertEquals('a', $str->crop('a', null, false, 0));
        $this->assertEquals('a', $str->crop('a', null, false, 1));
        $this->assertEquals('a', $str->crop('a', null, true));
        $this->assertEquals('a', $str->crop('a', null, true, 0));
        $this->assertEquals('a', $str->crop('a', null, true, 1));

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


    public function testPrefix()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->prefix('aaa', 0));

        $this->assertEquals('aaa', $str->prefix('aaa', null));
        $this->assertEquals('aaa', $str->prefix('aaa', 3));
        $this->assertEquals('aaa', $str->prefix('aaa', 4));

        $this->assertEquals('bbb', $str->prefix('bbbb', null));
        $this->assertEquals('bbb', $str->prefix('bbbb', 3));
        $this->assertEquals('bbbb', $str->prefix('bbbb', 4));

        $this->assertEquals('bbb', $str->prefix('babab', null));
        $this->assertEquals('bbb', $str->prefix('babab', 3));
        $this->assertEquals('baba', $str->prefix('babab', 4));

        $this->assertEquals('usr', $str->prefix('user', null));
        $this->assertEquals('usr', $str->prefix('user', 3));
        $this->assertEquals('user', $str->prefix('user', 4));

        $this->assertEquals('opr', $str->prefix('operator', null));
        $this->assertEquals('opr', $str->prefix('operator', 3));
        $this->assertEquals('oprt', $str->prefix('operator', 4));
    }


    public function testExplode()
    {
        $str = $this->getStr();

        $this->assertEquals([ 'dadbdcd' ], $str->explode('', 'dadbdcd'));
        $this->assertEquals([ 'dadbdcd' ], $str->explode([ '' ], 'dadbdcd'));
        $this->assertEquals([ 'd', 'dbdcd' ], $str->explode([ 'a' ], 'dadbdcd'));
        $this->assertEquals([ 'd', 'd', 'dcd' ], $str->explode([ 'a', 'b' ], 'dadbdcd'));
        $this->assertEquals([ 'd', 'd', 'd', 'd' ], $str->explode([ 'a', 'b', 'c' ], 'dadbdcd'));
    }

    public function testBadExplode()
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
        $this->assertEquals([ 'd', 'dbdcd' ], $str->separate([ 'a' ], 'dadbdcd'));
        $this->assertEquals([ 'd', [ 'd', 'dcd' ] ], $str->separate([ 'a', 'b' ], 'dadbdcd'));
        $this->assertEquals([ 'd', [ 'd', [ 'd', 'd' ] ] ], $str->separate([ 'a', 'b', 'c' ], 'dadbdcd'));
    }

    public function testBadSeparate()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->separate(null, 'dadbdcd');
        });
    }


    public function testImplode()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->implode(''));
        $this->assertEquals('', $str->implode('', []));

        $parts = [ '', ',', 'a', ',a', [ '', ',', 'a', ',a' ] ];

        $this->assertEquals(',a,a,a,a', $str->implodeskip('', ...$parts));
        $this->assertEquals('a,a,a,a', $str->implodeskip(',', ...$parts));
    }

    public function testImplodeskip()
    {
        $str = $this->getStr();

        $this->assertEquals('', $str->implodeskip('', null));
        $this->assertEquals('', $str->implodeskip('', [ null ]));
        $this->assertEquals('', $str->implodeskip('', []));
        $this->assertEquals('', $str->implodeskip('', []));

        $parts = [ null, '', ',', 'a', ',a', new \StdClass(), [ null, '', ',', 'a', ',a', new \StdClass() ] ];

        $this->assertEquals(',a,a,a,a', $str->implodeskip('', ...$parts));
        $this->assertEquals('a,a,a,a', $str->implodeskip(',', ...$parts));
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

        $this->assertEquals('', $str->joinskip('', null));
        $this->assertEquals('', $str->joinskip('', [ null ]));
        $this->assertEquals('', $str->joinskip(''));
        $this->assertEquals('', $str->joinskip('', []));

        $parts = [ null, '', ',', 'a', ',a', new \StdClass(), [ null, '', ',', 'a', ',a', new \StdClass() ] ];

        $this->assertEquals(',a,a,a,a', $str->joinskip('', ...$parts));
        $this->assertEquals('a,a,a,a', $str->joinskip(',', ...$parts));
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

        $this->assertEquals('abcd', $str->concatskip($parts));
        $this->assertEquals('abcd', $str->concatskip($parts, ''));
        $this->assertEquals('a,b,c,d', $str->concatskip($parts, ','));

        $this->assertEquals('abcd', $str->concatskip($parts, null, ''));
        $this->assertEquals('abcd', $str->concatskip($parts, '', ''));
        $this->assertEquals('a,b,cd', $str->concatskip($parts, ',', ''));

        $this->assertEquals('abc or d', $str->concatskip($parts, null, ' or '));
        $this->assertEquals('abc or d', $str->concatskip($parts, '', ' or '));
        $this->assertEquals('a,b,c or d', $str->concatskip($parts, ',', ' or '));

        $this->assertEquals('"a""b""c""d"', $str->concatskip($parts, null, null, '"'));
        $this->assertEquals('"a""b""c""d"', $str->concatskip($parts, '', null, '"'));
        $this->assertEquals('"a","b","c","d"', $str->concatskip($parts, ',', null, '"'));

        $this->assertEquals('"a""b""c""d"', $str->concatskip($parts, null, '', '"'));
        $this->assertEquals('"a""b""c""d"', $str->concatskip($parts, '', '', '"'));
        $this->assertEquals('"a","b","c""d"', $str->concatskip($parts, ',', '', '"'));

        $this->assertEquals('"a""b""c" or "d"', $str->concatskip($parts, null, ' or ', '"'));
        $this->assertEquals('"a""b""c" or "d"', $str->concatskip($parts, '', ' or ', '"'));
        $this->assertEquals('"a","b","c" or "d"', $str->concatskip($parts, ',', ' or ', '"'));
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


    public function testSnake()
    {
        $str = $this->getStr();

        static::assertEquals('helloworld', $str->snake('helloworld'));
        static::assertEquals('hello_world', $str->snake('HelloWorld'));
        static::assertEquals('hello_world', $str->snake('hello-world'));
        static::assertEquals('hello_world', $str->snake('hello_world'));
        static::assertEquals('hello_world', $str->snake('Hello-World'));
        static::assertEquals('hello_world', $str->snake('Hello World'));
        static::assertEquals('hello_world', $str->snake('Hello_World'));
        static::assertEquals('hello.world', $str->snake('hello.world'));
        static::assertEquals('hello._world', $str->snake('Hello.World'));
        static::assertEquals('helloworld.foo', $str->snake('helloworld.foo'));
        static::assertEquals('hello_world.foo', $str->snake('HelloWorld.foo'));
        static::assertEquals('hello_world.foo', $str->snake('hello world.foo'));
        static::assertEquals('hello_world.foo', $str->snake('hello-world.foo'));
        static::assertEquals('hello_world.foo', $str->snake('hello_world.foo'));
        static::assertEquals('hello_world.foo', $str->snake('Hello-World.foo'));
        static::assertEquals('hello_world.foo', $str->snake('Hello World.foo'));
        static::assertEquals('hello_world.foo', $str->snake('Hello_World.foo'));
        static::assertEquals('hello.world', $str->snake('hello.world', '.'));
        static::assertEquals('hello.world', $str->snake('Hello.World', '.'));
        static::assertEquals('helloworld.foo', $str->snake('helloworld.foo', '.'));
        static::assertEquals('hello.world.foo', $str->snake('HelloWorld.foo', '.'));
        static::assertEquals('hello.world.foo', $str->snake('hello world.foo', '.'));
        static::assertEquals('hello.world.foo', $str->snake('hello-world.foo', '.'));
        static::assertEquals('hello.world.foo', $str->snake('hello_world.foo', '.'));
        static::assertEquals('hello.world.foo', $str->snake('Hello-World.foo', '.'));
        static::assertEquals('hello.world.foo', $str->snake('Hello World.foo', '.'));
        static::assertEquals('hello.world.foo', $str->snake('Hello_World.foo', '.'));
    }

    public function testUsnake()
    {
        $str = $this->getStr();

        static::assertEquals('Helloworld', $str->usnake('helloworld'));
        static::assertEquals('Hello_World', $str->usnake('HelloWorld'));
        static::assertEquals('Hello_World', $str->usnake('hello-world'));
        static::assertEquals('Hello_World', $str->usnake('hello_world'));
        static::assertEquals('Hello_World', $str->usnake('Hello-World'));
        static::assertEquals('Hello_World', $str->usnake('Hello World'));
        static::assertEquals('Hello_World', $str->usnake('Hello_World'));
        static::assertEquals('Hello.world', $str->usnake('hello.world'));
        static::assertEquals('Hello._World', $str->usnake('Hello.World'));
        static::assertEquals('Helloworld.foo', $str->usnake('helloworld.foo'));
        static::assertEquals('Hello_World.foo', $str->usnake('HelloWorld.foo'));
        static::assertEquals('Hello_World.foo', $str->usnake('hello world.foo'));
        static::assertEquals('Hello_World.foo', $str->usnake('hello-world.foo'));
        static::assertEquals('Hello_World.foo', $str->usnake('hello_world.foo'));
        static::assertEquals('Hello_World.foo', $str->usnake('Hello-World.foo'));
        static::assertEquals('Hello_World.foo', $str->usnake('Hello World.foo'));
        static::assertEquals('Hello_World.foo', $str->usnake('Hello_World.foo'));
        static::assertEquals('Hello.World', $str->usnake('hello.world', '.'));
        static::assertEquals('Hello.World', $str->usnake('Hello.World', '.'));
        static::assertEquals('Helloworld.Foo', $str->usnake('helloworld.foo', '.'));
        static::assertEquals('Hello.World.Foo', $str->usnake('HelloWorld.foo', '.'));
        static::assertEquals('Hello.World.Foo', $str->usnake('hello world.foo', '.'));
        static::assertEquals('Hello.World.Foo', $str->usnake('hello-world.foo', '.'));
        static::assertEquals('Hello.World.Foo', $str->usnake('hello_world.foo', '.'));
        static::assertEquals('Hello.World.Foo', $str->usnake('Hello-World.foo', '.'));
        static::assertEquals('Hello.World.Foo', $str->usnake('Hello World.foo', '.'));
        static::assertEquals('Hello.World.Foo', $str->usnake('Hello_World.foo', '.'));
    }


    public function testKebab()
    {
        $str = $this->getStr();

        static::assertEquals('helloworld', $str->kebab('helloworld'));
        static::assertEquals('hello-world', $str->kebab('HelloWorld'));
        static::assertEquals('hello-world', $str->kebab('hello-world'));
        static::assertEquals('hello-world', $str->kebab('hello_world'));
        static::assertEquals('hello-world', $str->kebab('Hello-World'));
        static::assertEquals('hello-world', $str->kebab('Hello World'));
        static::assertEquals('hello-world', $str->kebab('Hello_World'));
        static::assertEquals('hello.world', $str->kebab('hello.world'));
        static::assertEquals('hello.-world', $str->kebab('Hello.World'));
        static::assertEquals('helloworld.foo', $str->kebab('helloworld.foo'));
        static::assertEquals('hello-world.foo', $str->kebab('HelloWorld.foo'));
        static::assertEquals('hello-world.foo', $str->kebab('hello world.foo'));
        static::assertEquals('hello-world.foo', $str->kebab('hello-world.foo'));
        static::assertEquals('hello-world.foo', $str->kebab('hello_world.foo'));
        static::assertEquals('hello-world.foo', $str->kebab('Hello-World.foo'));
        static::assertEquals('hello-world.foo', $str->kebab('Hello World.foo'));
        static::assertEquals('hello-world.foo', $str->kebab('Hello_World.foo'));
    }

    public function testUkebab()
    {
        $str = $this->getStr();

        static::assertEquals('Helloworld', $str->ukebab('helloworld'));
        static::assertEquals('Hello-World', $str->ukebab('HelloWorld'));
        static::assertEquals('Hello-World', $str->ukebab('hello-world'));
        static::assertEquals('Hello-World', $str->ukebab('hello_world'));
        static::assertEquals('Hello-World', $str->ukebab('Hello-World'));
        static::assertEquals('Hello-World', $str->ukebab('Hello World'));
        static::assertEquals('Hello-World', $str->ukebab('Hello_World'));
        static::assertEquals('Hello.world', $str->ukebab('hello.world'));
        static::assertEquals('Hello.-World', $str->ukebab('Hello.World'));
        static::assertEquals('Helloworld.foo', $str->ukebab('helloworld.foo'));
        static::assertEquals('Hello-World.foo', $str->ukebab('HelloWorld.foo'));
        static::assertEquals('Hello-World.foo', $str->ukebab('hello world.foo'));
        static::assertEquals('Hello-World.foo', $str->ukebab('hello-world.foo'));
        static::assertEquals('Hello-World.foo', $str->ukebab('hello_world.foo'));
        static::assertEquals('Hello-World.foo', $str->ukebab('Hello-World.foo'));
        static::assertEquals('Hello-World.foo', $str->ukebab('Hello World.foo'));
        static::assertEquals('Hello-World.foo', $str->ukebab('Hello_World.foo'));
    }


    public function testPascal()
    {
        $str = $this->getStr();

        static::assertEquals('Helloworld', $str->pascal('helloworld'));
        static::assertEquals('HelloWorld', $str->pascal('HelloWorld'));
        static::assertEquals('HelloWorld', $str->pascal('hello-world'));
        static::assertEquals('HelloWorld', $str->pascal('hello_world'));
        static::assertEquals('HelloWorld', $str->pascal('Hello-World'));
        static::assertEquals('HelloWorld', $str->pascal('Hello World'));
        static::assertEquals('HelloWorld', $str->pascal('Hello_World'));
        static::assertEquals('Hello.world', $str->pascal('hello.world'));
        static::assertEquals('Hello.World', $str->pascal('Hello.World'));
        static::assertEquals('Helloworld.foo', $str->pascal('helloworld.foo'));
        static::assertEquals('HelloWorld.foo', $str->pascal('HelloWorld.foo'));
        static::assertEquals('HelloWorld.foo', $str->pascal('hello world.foo'));
        static::assertEquals('HelloWorld.foo', $str->pascal('hello-world.foo'));
        static::assertEquals('HelloWorld.foo', $str->pascal('hello_world.foo'));
        static::assertEquals('HelloWorld.foo', $str->pascal('Hello-World.foo'));
        static::assertEquals('HelloWorld.foo', $str->pascal('Hello World.foo'));
        static::assertEquals('HelloWorld.foo', $str->pascal('Hello_World.foo'));
    }

    public function testCamel()
    {
        $str = $this->getStr();

        static::assertEquals('helloworld', $str->camel('helloworld'));
        static::assertEquals('helloWorld', $str->camel('HelloWorld'));
        static::assertEquals('helloWorld', $str->camel('hello-world'));
        static::assertEquals('helloWorld', $str->camel('hello_world'));
        static::assertEquals('helloWorld', $str->camel('Hello-World'));
        static::assertEquals('helloWorld', $str->camel('Hello World'));
        static::assertEquals('helloWorld', $str->camel('Hello_World'));
        static::assertEquals('hello.world', $str->camel('hello.world'));
        static::assertEquals('hello.World', $str->camel('Hello.World'));
        static::assertEquals('helloworld.foo', $str->camel('helloworld.foo'));
        static::assertEquals('helloWorld.foo', $str->camel('HelloWorld.foo'));
        static::assertEquals('helloWorld.foo', $str->camel('hello world.foo'));
        static::assertEquals('helloWorld.foo', $str->camel('hello-world.foo'));
        static::assertEquals('helloWorld.foo', $str->camel('hello_world.foo'));
        static::assertEquals('helloWorld.foo', $str->camel('Hello-World.foo'));
        static::assertEquals('helloWorld.foo', $str->camel('Hello World.foo'));
        static::assertEquals('helloWorld.foo', $str->camel('Hello_World.foo'));
    }


    public function testNumbers()
    {
        $str = $this->getStr();

        $this->assertEquals([ 1 ], $str->numbers(1));
        $this->assertEquals([ 1 ], $str->numbers(1.0));
        $this->assertEquals([ 1.1 ], $str->numbers(1.1));
        $this->assertEquals([ '1' ], $str->numbers('1'));
        $this->assertEquals([ '1.0' ], $str->numbers('1.0'));
        $this->assertEquals([ '1.1' ], $str->numbers('1.1'));
        $this->assertEquals([], $str->numbers([]));

        $this->assertEquals([ 1 ], $str->numbers([ 1 ]));
        $this->assertEquals([ 1 ], $str->numbers([ 1.0 ]));
        $this->assertEquals([ 1.1 ], $str->numbers([ 1.1 ]));
        $this->assertEquals([ '1' ], $str->numbers([ '1' ]));
        $this->assertEquals([ '1.0' ], $str->numbers([ '1.0' ]));
        $this->assertEquals([ '1.1' ], $str->numbers([ '1.1' ]));
        $this->assertEquals([], $str->numbers([ [] ]));

        $this->assertEquals([ '1' ], $str->numbers([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $str->numbers([ [ 1.0 ] ]));
        $this->assertEquals([ '1.1' ], $str->numbers([ [ 1.1 ] ]));
        $this->assertEquals([ '1' ], $str->numbers([ [ '1' ] ]));
        $this->assertEquals([ '1.0' ], $str->numbers([ [ '1.0' ] ]));
        $this->assertEquals([ '1.1' ], $str->numbers([ [ '1.1' ] ]));
        $this->assertEquals([], $str->numbers([ [ [] ] ]));
    }

    public function testNumbersBad()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers('');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers('hello');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ '' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ 'hello' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ [ '' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ [ 'hello' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->numbers([ [ new \StdClass() ] ]);
        });
    }


    public function testStrings()
    {
        $str = $this->getStr();

        $this->assertEquals([ '1' ], $str->strings(1));
        $this->assertEquals([ '1' ], $str->strings(1.0));
        $this->assertEquals([ '1.1' ], $str->strings(1.1));
        $this->assertEquals([ '' ], $str->strings(''));
        $this->assertEquals([ 'hello' ], $str->strings('hello'));
        $this->assertEquals([ 'hello', 'hello' ], $str->strings([ 'hello', 'hello' ]));
        $this->assertEquals([], $str->strings([]));

        $this->assertEquals([ '1' ], $str->strings([ 1 ]));
        $this->assertEquals([ '1' ], $str->strings([ 1.0 ]));
        $this->assertEquals([ '1.1' ], $str->strings([ 1.1 ]));
        $this->assertEquals([ '' ], $str->strings([ '' ]));
        $this->assertEquals([ 'hello' ], $str->strings([ 'hello' ]));
        $this->assertEquals([ 'hello', 'hello' ], $str->strings([ 'hello', 'hello' ]));
        $this->assertEquals([], $str->strings([ [] ]));

        $this->assertEquals([ '1' ], $str->strings([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $str->strings([ [ 1.0 ] ]));
        $this->assertEquals([ '1.1' ], $str->strings([ [ 1.1 ] ]));
        $this->assertEquals([ '' ], $str->strings([ [ '' ] ]));
        $this->assertEquals([ 'hello' ], $str->strings([ [ 'hello' ] ]));
        $this->assertEquals([ 'hello', 'hello' ], $str->strings([ [ 'hello' ], 'hello' ]));
        $this->assertEquals([], $str->strings([ [ [] ] ]));
    }

    public function testStringsBad()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->strings([ [ new \StdClass() ] ]);
        });
    }


    public function testWords()
    {
        $str = $this->getStr();

        $this->assertEquals([ '1' ], $str->words(1));
        $this->assertEquals([ '1' ], $str->words(1.0));
        $this->assertEquals([ '1.1' ], $str->words(1.1));
        $this->assertEquals([ 'hello' ], $str->words('hello'));
        $this->assertEquals([ 'hello', 'hello' ], $str->words([ 'hello', 'hello' ]));
        $this->assertEquals([], $str->words([]));

        $this->assertEquals([ '1' ], $str->words([ 1 ]));
        $this->assertEquals([ '1' ], $str->words([ 1.0 ]));
        $this->assertEquals([ '1.1' ], $str->words([ 1.1 ]));
        $this->assertEquals([ 'hello' ], $str->words([ 'hello' ]));
        $this->assertEquals([ 'hello', 'hello' ], $str->words([ 'hello', 'hello' ]));
        $this->assertEquals([], $str->words([ [] ]));

        $this->assertEquals([ '1' ], $str->words([ [ 1 ] ]));
        $this->assertEquals([ '1' ], $str->words([ [ 1.0 ] ]));
        $this->assertEquals([ '1.1' ], $str->words([ [ 1.1 ] ]));
        $this->assertEquals([ 'hello' ], $str->words([ [ 'hello' ] ]));
        $this->assertEquals([ 'hello', 'hello' ], $str->words([ [ 'hello' ], 'hello' ]));
        $this->assertEquals([], $str->words([ [ [] ] ]));
    }

    public function testWordsBad()
    {
        $str = $this->getStr();

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words(null);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words(false);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words('');
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ null ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ false ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ '' ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ new \StdClass() ]);
        });

        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ [ null ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ [ false ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ [ '' ] ]);
        });
        $this->assertException(InvalidArgumentException::class, function () use ($str) {
            $str->words([ [ new \StdClass() ] ]);
        });
    }
}
