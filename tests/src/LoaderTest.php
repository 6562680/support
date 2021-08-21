<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ZLoader;
use Gzhegow\Support\ILoader;


class LoaderTest extends AbstractTestCase
{
    protected function getLoader() : ILoader
    {
        return ZLoader::getInstance();
    }


    public function testClassVal()
    {
        $loader = $this->getLoader();

        $class = 'stdClass';
        $object = new \StdClass();
        $globalClass = '\\' . $class;

        $currentClass = __CLASS__;
        $currentGlobalClass = '\\' . __CLASS__;
        $currentReflectionClass = new \ReflectionClass($this);

        $this->assertEquals($globalClass, $loader->classVal($class));
        $this->assertEquals($globalClass, $loader->classVal($object));
        $this->assertEquals($globalClass, $loader->classVal($globalClass));

        $this->assertEquals($currentGlobalClass, $loader->classVal($currentClass));
        $this->assertEquals($currentGlobalClass, $loader->classVal($currentGlobalClass));
        $this->assertEquals($currentGlobalClass, $loader->classVal($currentReflectionClass));
    }

    public function testUseClassVal()
    {
        $loader = $this->getLoader();

        $class = ZLoader::class;
        $rootClass = '\\' . $class;
        $object = $loader;
        $reflectionClass = new \ReflectionClass($loader);
        $className = 'ZLoader';

        $this->assertEquals($rootClass, $loader->useClassVal($class, __CLASS__));
        $this->assertEquals($rootClass, $loader->useClassVal($object, __CLASS__));
        $this->assertEquals($rootClass, $loader->useClassVal($rootClass, __CLASS__));
        $this->assertEquals($rootClass, $loader->useClassVal($reflectionClass, __CLASS__));
        $this->assertEquals($rootClass, $loader->useClassVal($className, __CLASS__));
    }


    public function testIsClassOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };
        $c = 'StdClass';

        $this->assertEquals(true, $loader->isClassOneOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(true, $loader->isClassOneOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(true, $loader->isClassOneOf($c, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testIsSubclassOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };
        $c = 'StdClass';

        $this->assertEquals(true, $loader->isSubclassOneOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(true, $loader->isSubclassOneOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(false, $loader->isSubclassOneOf($c, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testIsInstanceOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };

        $this->assertEquals(true, $loader->isInstanceOneOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(true, $loader->isInstanceOneOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testIsContract()
    {
        $loader = $this->getLoader();

        $loader->addContract('myContract', \StdClass::class);
        $loader->addContract('myContract', \SplPriorityQueue::class);

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };

        $this->assertEquals(true, $loader->isContract($a, 'myContract'));
        $this->assertEquals(true, $loader->isContract($b, 'myContract'));
    }


    public function testFilterClassOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };
        $c = 'StdClass';

        $this->assertEquals($a, $loader->filterClassOneOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals($b, $loader->filterClassOneOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals($c, $loader->filterClassOneOf($c, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testFilterSubclassOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };
        $c = 'StdClass';

        $this->assertEquals($a, $loader->filterSubclassOneOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals($b, $loader->filterSubclassOneOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals(null, $loader->filterSubclassOneOf($c, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testFilterInstanceOf()
    {
        $loader = $this->getLoader();

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };

        $this->assertEquals($a, $loader->filterInstanceOneOf($a, [ \StdClass::class, \SplPriorityQueue::class ]));
        $this->assertEquals($b, $loader->filterInstanceOneOf($b, [ \StdClass::class, \SplPriorityQueue::class ]));
    }

    public function testFilterContract()
    {
        $loader = $this->getLoader();

        $loader->addContract('myContract', \StdClass::class);
        $loader->addContract('myContract', \SplPriorityQueue::class);

        $a = new class extends \StdClass {
        };
        $b = new class extends \SplPriorityQueue {
        };

        $this->assertEquals($a, $loader->filterContract($a, 'myContract'));
        $this->assertEquals($b, $loader->filterContract($b, 'myContract'));
    }


    public function testNsClass()
    {
        $loader = $this->getLoader();

        $a = LoaderTest::class;
        $b = $this->getLoader();
        $c = 'A\\B\\C\\D';
        $d = '\\A\\B\\C\\D';

        $this->assertEquals([ 'Gzhegow\Support\Tests', 'LoaderTest' ], $loader->namespaceClass($a));
        $this->assertEquals([ 'Gzhegow\Support', 'ZLoader' ], $loader->namespaceClass($b));
        $this->assertEquals([ 'A\\B\\C', 'D' ], $loader->namespaceClass($c));
        $this->assertEquals([ 'A\\B\\C', 'D' ], $loader->namespaceClass($d));
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
        $this->assertEquals('ZLoader', $loader->className($b));
        $this->assertEquals('D', $loader->className($c));
        $this->assertEquals('D', $loader->className($d));
    }


    public function testPathSplit()
    {
        $loader = $this->getLoader();
        $ds = '\\';

        $this->assertEquals([ "${ds}" ], $loader->pathSplit('/', '/'));
        $this->assertEquals([ "${ds}" ], $loader->pathSplit('/', '/\\'));
        $this->assertEquals([ "${ds}${ds}" ], $loader->pathSplit('/\\', '/'));
        $this->assertEquals([ "${ds}${ds}" ], $loader->pathSplit('/\\', '/\\'));
        $this->assertEquals([ 'aa', 'aa', 'aa', 'aa' ], $loader->pathSplit('aa/aa\\aa/aa'));
        $this->assertEquals([ "${ds}aa", 'aa', 'aa', 'aa' ], $loader->pathSplit('/aa/aa\\aa/aa\\'));
        $this->assertEquals([ "${ds}${ds}aa", 'aa', 'aa', 'aa' ], $loader->pathSplit('//aa/aa\\aa/aa\\'));
        $this->assertEquals([ "${ds}${ds}${ds}aa", 'aa', 'aa', 'aa' ], $loader->pathSplit('/\\/aa/aa\\aa/aa\\'));
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

        $this->assertEquals("${ds}", $loader->pathJoin('/', [ '/' ]));

        $this->assertEquals("a${ds}a", $loader->pathJoin('a', [ 'a' ]));
        $this->assertEquals(",a${ds},a", $loader->pathJoin(',a', [ ',a' ]));

        $this->assertEquals("${ds}a${ds}a", $loader->pathJoin('/a', [ '/a' ]));
        $this->assertEquals("${ds}a", $loader->pathJoin('/', [ '/a' ]));

        $parts = [ '', ',', "${ds}", 'a', ',a', "${ds}a", [ '', ',', "${ds}", 'a', ',a', "${ds}a" ] ];

        $this->assertEquals(",${ds}a${ds},a${ds}a${ds},${ds}a${ds},a${ds}a", $loader->pathJoin(...$parts));
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
