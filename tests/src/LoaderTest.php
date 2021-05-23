<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;
use Gzhegow\Support\Php;
use Gzhegow\Support\Path;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Loader;


class LoaderTest extends AbstractTestCase
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

    protected function getLoader() : Loader
    {
        return new Loader(
            $this->getFilter(),
            $this->getPath(),
            $this->getPhp()
        );
    }


    public function testIsInstanceOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };

        $this->assertEquals(true, $loader->isInstanceOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(true, $loader->isInstanceOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testIsClassOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };
        $c = 'StdClass';

        $this->assertEquals(true, $loader->isClassOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(true, $loader->isClassOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(true, $loader->isClassOf($c, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testIsSubclassOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };
        $c = 'StdClass';

        $this->assertEquals(true, $loader->isSubclassOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(true, $loader->isSubclassOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(false, $loader->isSubclassOf($c, [ \StdClass::class, \SplPriorityQueue::class ]));
    }


    public function testFilterInstanceOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };

        $this->assertEquals($a, $loader->filterInstanceOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals($b, $loader->filterInstanceOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testFilterClassOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };
        $c = 'StdClass';

        $this->assertEquals($a, $loader->filterClassOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals($b, $loader->filterClassOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals($c, $loader->filterClassOf($c, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testFilterSubclassOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };
        $c = 'StdClass';

        $this->assertEquals($a, $loader->filterSubclassOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals($b, $loader->filterSubclassOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(null, $loader->filterSubclassOf($c, [ \StdClass::class, \SplPriorityQueue::class ]));
    }


    public function testNsClass()
    {
        $loader = $this->getLoader();

        $a = LoaderTest::class;
        $b = $this->getLoader();
        $c = 'A\\B\\C\\D';
        $d = '\\A\\B\\C\\D';

        $this->assertEquals([ 'Gzhegow\Support\Tests', 'LoaderTest' ], $loader->nsClass($a));
        $this->assertEquals([ 'Gzhegow\Support', 'Loader' ], $loader->nsClass($b));
        $this->assertEquals([ 'A\\B\\C', 'D' ], $loader->nsClass($c));
        $this->assertEquals([ 'A\\B\\C', 'D' ], $loader->nsClass($d));
    }

    public function testNamespace()
    {
        $loader = $this->getLoader();

        $a = LoaderTest::class;
        $b = $this->getLoader();
        $c = 'A\\B\\C\\D';
        $d = '\\A\\B\\C\\D';

        $this->assertEquals('Gzhegow\Support\Tests', $loader->namespace($a));
        $this->assertEquals('Gzhegow\Support', $loader->namespace($b));
        $this->assertEquals('A\\B\\C', $loader->namespace($c));
        $this->assertEquals('A\\B\\C', $loader->namespace($d));
    }

    public function testClassName()
    {
        $loader = $this->getLoader();

        $a = LoaderTest::class;
        $b = $this->getLoader();
        $c = 'A\\B\\C\\D';
        $d = '\\A\\B\\C\\D';

        $this->assertEquals('LoaderTest', $loader->className($a));
        $this->assertEquals('Loader', $loader->className($b));
        $this->assertEquals('D', $loader->className($c));
        $this->assertEquals('D', $loader->className($d));
    }


    public function testPathSplit()
    {
        $loader = $this->getLoader();
        $ds = '\\';

        $this->assertEquals([ 'aa', 'aa', 'aa', 'aa' ], $loader->pathSplit('aa/aa\\aa/aa'));
        $this->assertEquals([ "${ds}", 'aa', 'aa', 'aa', 'aa' ], $loader->pathSplit('/aa/aa\\aa/aa\\'));
        $this->assertEquals([ "${ds}${ds}", 'aa', 'aa', 'aa', 'aa' ], $loader->pathSplit('//aa/aa\\aa/aa\\'));
        $this->assertEquals([ "${ds}${ds}${ds}", 'aa', 'aa', 'aa', 'aa' ], $loader->pathSplit('/\\/aa/aa\\aa/aa\\'));
    }

    public function testPathJoin()
    {
        $loader = $this->getLoader();
        $ds = '\\';

        $this->assertEquals('', $loader->pathJoin(''));
        $this->assertEquals(',', $loader->pathJoin(','));
        $this->assertEquals("${ds}", $loader->pathJoin('/'));
        $this->assertEquals('a', $loader->pathJoin('a'));
        $this->assertEquals(',a', $loader->pathJoin(',a'));
        $this->assertEquals("${ds}a", $loader->pathJoin('/a'));
        $this->assertEquals('', $loader->pathJoin('', [ '' ]));
        $this->assertEquals(",${ds},", $loader->pathJoin(',', [ ',' ]));

        $this->assertEquals("${ds}/", $loader->pathJoin('/', [ '/' ]));

        $this->assertEquals("a${ds}a", $loader->pathJoin('a', [ 'a' ]));
        $this->assertEquals(",a${ds},a", $loader->pathJoin(',a', [ ',a' ]));

        $this->assertEquals("${ds}a${ds}/a", $loader->pathJoin('/a', [ '/a' ]));
        $this->assertEquals("${ds}/a", $loader->pathJoin('/', [ '/a' ]));

        $parts = [ '', ',', "${ds}", 'a', ',a', "${ds}a", [ '', ',', "${ds}", 'a', ',a', "${ds}a" ] ];

        $this->assertEquals(",${ds}a${ds},a${ds}a${ds},${ds}a${ds},a${ds}a", $loader->pathJoin(...$parts));
    }

    public function testPathNormalize()
    {
        $loader = $this->getLoader();
        $ds = '\\';

        $this->assertEquals('', $loader->pathNormalize(''));
        $this->assertEquals(',', $loader->pathNormalize(','));
        $this->assertEquals("${ds}", $loader->pathNormalize('/'));
        $this->assertEquals('a', $loader->pathNormalize('a'));
        $this->assertEquals(',a', $loader->pathNormalize(',a'));
        $this->assertEquals("${ds}a", $loader->pathNormalize('/a'));
        $this->assertEquals('', $loader->pathNormalize('', [ '' ]));
        $this->assertEquals(",${ds},", $loader->pathNormalize(',', [ ',' ]));
        $this->assertEquals("${ds}", $loader->pathNormalize('/', [ '/' ]));
        $this->assertEquals("a${ds}a", $loader->pathNormalize('a', [ 'a' ]));
        $this->assertEquals(",a${ds},a", $loader->pathNormalize(',a', [ ',a' ]));
        $this->assertEquals("${ds}a${ds}a", $loader->pathNormalize('/a', [ '/a' ]));

        $this->assertEquals("${ds}a", $loader->pathNormalize('/', [ '/a' ]));

        $parts = [ '', ',', "${ds}", 'a', ',a', "${ds}a", [ '', ',', "${ds}", 'a', ',a', "${ds}a" ] ];

        $this->assertEquals(",${ds}a${ds},a${ds}a${ds},${ds}a${ds},a${ds}a", $loader->pathNormalize(...$parts));
    }

    public function testPathConcat()
    {
        $loader = $this->getLoader();
        $ds = '\\';

        $this->assertEquals("1${ds}2${ds}3", $loader->pathConcat('1/2/3', ''));
        $this->assertEquals("1${ds}2${ds}3", $loader->pathConcat('1/2/3', '/'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $loader->pathConcat('1/2/3', '1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3', '3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3', '2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3', '1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3', '0/1/2/3/4'));

        $this->assertEquals("1${ds}2${ds}3", $loader->pathConcat('1/2/3/', ''));
        $this->assertEquals("1${ds}2${ds}3", $loader->pathConcat('1/2/3/', '/'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $loader->pathConcat('1/2/3/', '1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3/', '3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3/', '2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3/', '1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3/', '0/1/2/3/4'));

        $this->assertEquals("1${ds}2${ds}3", $loader->pathConcat('1/2/3', '//'));
        $this->assertEquals("1${ds}2${ds}3${ds}1", $loader->pathConcat('1/2/3', '/1'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3', '/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3', '/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3', '/1/2/3/4'));
        $this->assertEquals("1${ds}2${ds}3${ds}0${ds}1${ds}2${ds}3${ds}4", $loader->pathConcat('1/2/3', '/0/1/2/3/4'));
    }


    public function testPathDirname()
    {
        $loader = $this->getLoader();
        $ds = '\\';

        $a = __CLASS__;
        $b = 'A\\B\\C\\D';
        $c = '\\A\\B\\C\\D';

        $this->assertEquals("Gzhegow${ds}Support${ds}Tests", $loader->pathDirname($a));

        $this->assertEquals("A${ds}B${ds}C", $loader->pathDirname($b));

        $this->assertEquals("${ds}A${ds}B", $loader->pathDirname($c, 2));
    }

    public function testPathBasename()
    {
        $loader = $this->getLoader();
        $ds = '\\';

        $a = __CLASS__;
        $b = 'A\\B\\C\\D';
        $c = '\\A\\B\\C\\D';

        $this->assertEquals('Loader', $loader->pathBasename($a, 'Test'));

        $this->assertEquals('D', $loader->pathBasename($b));

        $this->assertEquals("B${ds}C${ds}D", $loader->pathBasename($c, null, 2));
    }

    public function testPathRelative()
    {
        $loader = $this->getLoader();
        $ds = '\\';

        $a = __CLASS__;
        $b = 'A\\B\\C\\D';
        $c = '\\A\\B\\C\\D';

        $this->assertEquals("Support${ds}Tests${ds}LoaderTest", $loader->pathRelative($a, 'Gzhegow'));

        $this->assertEquals("A${ds}B${ds}C${ds}D", $loader->pathRelative($b));

        $this->assertEquals("B${ds}C${ds}D", $loader->pathRelative($b, 'A'));

        $this->assertEquals("B${ds}C${ds}D", $loader->pathRelative($c, '/A'));
        $this->assertEquals(null, $loader->pathRelative($c, 'A'));
    }
}
