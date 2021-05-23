<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Php;
use Gzhegow\Support\Preg;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Exceptions\RuntimeException;


class PregTest extends AbstractTestCase
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

    protected function getPreg() : Preg
    {
        return new Preg(
            $this->getStr()
        );
    }


    public function testNew()
    {
        $preg = $this->getPreg();

        $this->assertEquals('//', $preg->concat(''));
        $this->assertEquals('//', $preg->concat([ '' ]));
        $this->assertEquals('/\//', $preg->concat([ '/' ]));
        $this->assertEquals('/hello(world)+/', $preg->concat('hello(', [ 'world' ], ')+'));
        $this->assertEquals('/foohelloworld/iu', $preg->concat('foo', '/hello/iu', 'world'));
    }

    public function testBadNew()
    {
        $preg = $this->getPreg();

        $this->assertException(RuntimeException::class, function () use ($preg) {
            $preg->concat('/'); // without escaping this collides with delimiter
        });
    }
}
