<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Php;
use Gzhegow\Support\Path;
use Gzhegow\Support\Filter;


class PathTest extends AbstractTestCase
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

    protected function getPath() : Path
    {
        return new Path(
            $this->getPhp(),
            $this->getStr(),
        );
    }


    public function testSplit()
    {
        $path = $this->getPath();

        $path->using('/', '\\');

        $this->assertEquals([ 'aa', 'aa', 'aa', 'aa' ], $path->split('aa/aa\\aa/aa'));
        $this->assertEquals([ '/', 'aa', 'aa', 'aa', 'aa' ], $path->split('/aa/aa\\aa/aa\\'));
        $this->assertEquals([ '//', 'aa', 'aa', 'aa', 'aa' ], $path->split('//aa/aa\\aa/aa\\'));
        $this->assertEquals([ '///', 'aa', 'aa', 'aa', 'aa' ], $path->split('/\\/aa/aa\\aa/aa\\'));
    }

    public function testJoin()
    {
        $path = $this->getPath();

        $path->using('/', '\\');

        $this->assertEquals('', $path->join(''));
        $this->assertEquals(',', $path->join(','));
        $this->assertEquals('/', $path->join('/'));
        $this->assertEquals('a', $path->join('a'));
        $this->assertEquals(',a', $path->join(',a'));
        $this->assertEquals('/a', $path->join('/a'));
        $this->assertEquals('', $path->join('', [ '' ]));
        $this->assertEquals(',/,', $path->join(',', [ ',' ]));
        $this->assertEquals('/', $path->join('/', [ '/' ]));
        $this->assertEquals('a/a', $path->join('a', [ 'a' ]));
        $this->assertEquals(',a/,a', $path->join(',a', [ ',a' ]));
        $this->assertEquals('/a/a', $path->join('/a', [ '/a' ]));

        $this->assertEquals('/a', $path->join('/', [ '/a' ]));

        $parts = [ '', ',', '/', 'a', ',a', '/a', [ '', ',', '/', 'a', ',a', '/a' ] ];

        $this->assertEquals(',/a/,a/a/,/a/,a/a', $path->join(...$parts));
    }

    public function testNormalize()
    {
        $path = $this->getPath();

        $path->using('/', '\\');

        $this->assertEquals('', $path->normalize(''));
        $this->assertEquals(',', $path->normalize(','));
        $this->assertEquals('/', $path->normalize('/'));
        $this->assertEquals('a', $path->normalize('a'));
        $this->assertEquals(',a', $path->normalize(',a'));
        $this->assertEquals('/a', $path->normalize('/a'));
        $this->assertEquals('', $path->normalize('', [ '' ]));
        $this->assertEquals(',/,', $path->normalize(',', [ ',' ]));
        $this->assertEquals('/', $path->normalize('/', [ '/' ]));
        $this->assertEquals('a/a', $path->normalize('a', [ 'a' ]));
        $this->assertEquals(',a/,a', $path->normalize(',a', [ ',a' ]));
        $this->assertEquals('/a/a', $path->normalize('/a', [ '/a' ]));

        $this->assertEquals('/a', $path->normalize('/', [ '/a' ]));

        $parts = [ '', ',', '/', 'a', ',a', '/a', [ '', ',', '/', 'a', ',a', '/a' ] ];

        $this->assertEquals(',/a/,a/a/,/a/,a/a', $path->normalize(...$parts));
    }

    public function testConcat()
    {
        $path = $this->getPath();

        $path->using('/', '\\');

        $this->assertEquals('1/2/3', $path->concat('1/2/3', ''));
        $this->assertEquals('1/2/3', $path->concat('1/2/3', '/'));
        $this->assertEquals('1/2/3/1', $path->concat('1/2/3', '1'));
        $this->assertEquals('1/2/3/4', $path->concat('1/2/3', '3/4'));
        $this->assertEquals('1/2/3/4', $path->concat('1/2/3', '2/3/4'));
        $this->assertEquals('1/2/3/4', $path->concat('1/2/3', '1/2/3/4'));
        $this->assertEquals('1/2/3/0/1/2/3/4', $path->concat('1/2/3', '0/1/2/3/4'));
    }


    public function testBasename()
    {
        $path = $this->getPath();

        $path->using('/', '\\');

        $a = PathTest::class;
        $b = 'A\\B/C\\D';
        $c = '\\A\\B/C\\D';

        $this->assertEquals('Path', $path->basename($a, 'Test'));

        $this->assertEquals('D', $path->basename($b));
        $this->assertEquals('D', $path->basename($b, null, 0));

        $this->assertEquals('B/C/D', $path->basename($c, null, 2));
    }

    public function testRelative()
    {
        $path = $this->getPath();

        $path->using('/', '\\');

        $a = PathTest::class;
        $b = 'A\\B/C\\D';
        $c = '\\A\\B/C\\D';

        $this->assertEquals('Support/Tests/PathTest', $path->relative($a, 'Gzhegow'));

        $this->assertEquals('A/B/C/D', $path->relative($b));
        $this->assertEquals('B/C/D', $path->relative($b, 'A'));

        $this->assertEquals('C/D', $path->relative($c, '/A\\B'));
        $this->assertEquals(null, $path->relative($c, 'D'));
    }
}
