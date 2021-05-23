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
        $ds = '/';

        $path->using('/', '\\');

        $this->assertEquals([ 'aa', 'aa', 'aa', 'aa' ], $path->split('aa/aa\\aa/aa'));
        $this->assertEquals([ "${ds}", 'aa', 'aa', 'aa', 'aa' ], $path->split('/aa/aa\\aa/aa\\'));
        $this->assertEquals([ "${ds}${ds}", 'aa', 'aa', 'aa', 'aa' ], $path->split('//aa/aa\\aa/aa\\'));
        $this->assertEquals([ "${ds}${ds}${ds}", 'aa', 'aa', 'aa', 'aa' ], $path->split('/\\/aa/aa\\aa/aa\\'));
    }

    public function testJoin()
    {
        $path = $this->getPath();
        $ds = '/';

        $path->using('/', '\\');

        $this->assertEquals('', $path->join(''));
        $this->assertEquals(',', $path->join(','));
        $this->assertEquals("${ds}", $path->join('/'));
        $this->assertEquals('a', $path->join('a'));
        $this->assertEquals(',a', $path->join(',a'));
        $this->assertEquals("${ds}a", $path->join('/a'));
        $this->assertEquals('', $path->join('', [ '' ]));
        $this->assertEquals(",${ds},", $path->join(',', [ ',' ]));
        $this->assertEquals("${ds}", $path->join('/', [ '/' ]));
        $this->assertEquals("a${ds}a", $path->join('a', [ 'a' ]));
        $this->assertEquals(",a${ds},a", $path->join(',a', [ ',a' ]));
        $this->assertEquals("${ds}a${ds}a", $path->join('/a', [ '/a' ]));

        $this->assertEquals("${ds}a", $path->join('/', [ '/a' ]));

        $parts = [ '', ',', "${ds}", 'a', ',a', "${ds}a", [ '', ',', "${ds}", 'a', ',a', "${ds}a" ] ];

        $this->assertEquals(",${ds}a${ds},a${ds}a${ds},${ds}a${ds},a${ds}a", $path->join(...$parts));
    }

    public function testNormalize()
    {
        $path = $this->getPath();
        $ds = '/';

        $path->using('/', '\\');

        $this->assertEquals('', $path->normalize(''));
        $this->assertEquals(',', $path->normalize(','));
        $this->assertEquals("${ds}", $path->normalize('/'));
        $this->assertEquals('a', $path->normalize('a'));
        $this->assertEquals(',a', $path->normalize(',a'));
        $this->assertEquals("${ds}a", $path->normalize('/a'));
        $this->assertEquals('', $path->normalize('', [ '' ]));
        $this->assertEquals(",${ds},", $path->normalize(',', [ ',' ]));
        $this->assertEquals("${ds}", $path->normalize('/', [ '/' ]));
        $this->assertEquals("a${ds}a", $path->normalize('a', [ 'a' ]));
        $this->assertEquals(",a${ds},a", $path->normalize(',a', [ ',a' ]));
        $this->assertEquals("${ds}a${ds}a", $path->normalize('/a', [ '/a' ]));

        $this->assertEquals("${ds}a", $path->normalize('/', [ '/a' ]));

        $parts = [ '', ',', "${ds}", 'a', ',a', "${ds}a", [ '', ',', "${ds}", 'a', ',a', "${ds}a" ] ];

        $this->assertEquals(",${ds}a${ds},a${ds}a${ds},${ds}a${ds},a${ds}a", $path->normalize(...$parts));
    }

    public function testConcat()
    {
        $path = $this->getPath();
        $ds = '/';

        $path->using('/', '\\');

        $this->assertEquals("1${ds}2${ds}3", $path->concat('1/2/3', ''));
        $this->assertEquals("1${ds}2${ds}3", $path->concat('1/2/3', '/'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $path->concat('1/2/3', '1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3', '3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3', '2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3', '1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $path->concat('1/2/3', '0/1/2/3/4'));

        $this->assertEquals("1${ds}2${ds}3", $path->concat('1/2/3/', ''));
        $this->assertEquals("1${ds}2${ds}3", $path->concat('1/2/3/', '/'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $path->concat('1/2/3/', '1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3/', '3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3/', '2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3/', '1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $path->concat('1/2/3/', '0/1/2/3/4'));

        $this->assertEquals("1${ds}2${ds}3", $path->concat('1/2/3', '//'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $path->concat('1/2/3', '/1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3', '/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3', '/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $path->concat('1/2/3', '/1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $path->concat('1/2/3', '/0/1/2/3/4'));
    }


    public function testDirname()
    {
        $path = $this->getPath();
        $ds = '/';

        $path->using('/', '\\');

        $a = __CLASS__;
        $b = 'A\\B/C\\D';
        $c = '\\A\\B/C\\D';

        $this->assertEquals("Gzhegow${ds}Support${ds}Tests", $path->dirname($a));

        $this->assertEquals("A${ds}B${ds}C", $path->dirname($b));

        $this->assertEquals("${ds}A${ds}B", $path->dirname($c, 2));
    }

    public function testBasename()
    {
        $path = $this->getPath();
        $ds = '/';

        $path->using('/', '\\');

        $a = __CLASS__;
        $b = 'A\\B/C\\D';
        $c = '\\A\\B/C\\D';

        $this->assertEquals('Path', $path->basename($a, 'Test'));

        $this->assertEquals('D', $path->basename($b));

        $this->assertEquals("B${ds}C${ds}D", $path->basename($c, null, 2));
    }

    public function testRelative()
    {
        $path = $this->getPath();
        $ds = '/';

        $path->using('/', '\\');

        $a = __CLASS__;
        $b = 'A\\B/C\\D';
        $c = '\\A\\B/C\\D';

        $this->assertEquals("Support${ds}Tests${ds}PathTest", $path->relative($a, 'Gzhegow'));

        $this->assertEquals("A${ds}B${ds}C${ds}D", $path->relative($b));

        $this->assertEquals("B${ds}C${ds}D", $path->relative($b, 'A'));

        $this->assertEquals("B${ds}C${ds}D", $path->relative($c, '/A'));
        $this->assertEquals(null, $path->relative($c, 'A'));
    }
}
