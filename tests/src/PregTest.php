<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Preg;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Assert;
use Gzhegow\Support\Exceptions\RuntimeException;


class PregTest extends AbstractTestCase
{
    protected function getAssert() : Assert
    {
        return new Assert();
    }

    protected function getFilter() : Filter
    {
        return new Filter(
            $this->getAssert()
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


    public function testBadNew1_()
    {
        $this->expectException(RuntimeException::class);

        $preg = $this->getPreg();

        $preg->concat('/'); // without escaping this collides with delimiter
    }

    public function testBadNew2_()
    {
        $this->expectException(RuntimeException::class);

        $preg = $this->getPreg();

        $preg->concat('/'); // each input first of all will be mapped to array, so it becomes "/"
    }
}
