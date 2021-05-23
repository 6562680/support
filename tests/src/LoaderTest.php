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
        $this->assertEquals([ '\\A\\B\\C', 'D' ], $loader->nsClass($d));
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
        $this->assertEquals('\\A\\B\\C', $loader->namespace($d));
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


    public function testBasename()
    {
        $loader = $this->getLoader();

        $a = LoaderTest::class;
        $b = $this->getLoader();
        $c = 'A\\B\\C\\D';
        $d = '\\A\\B\\C\\D';

        $this->assertEquals('Loader', $loader->basename($a, 'Test'));
        $this->assertEquals('Loader', $loader->basename($b));

        $this->assertEquals('D', $loader->basename($c));
        $this->assertEquals('D', $loader->basename($c, null, 0));

        $this->assertEquals('B\\C\\D', $loader->basename($d, null, 2));
    }

    public function testBasepath()
    {
        $loader = $this->getLoader();

        $a = LoaderTest::class;
        $b = $this->getLoader();
        $c = 'A\\B\\C\\D';
        $d = '\\A\\B\\C\\D';

        $this->assertEquals('Support\\Tests\\LoaderTest', $loader->basepath($a, 'Gzhegow'));
        $this->assertEquals('Support\\Loader', $loader->basepath($b, 'Gzhegow'));

        $this->assertEquals('B\\C\\D', $loader->basepath($c, 'A'));

        $this->assertEquals('C\\D', $loader->basepath($d, '\\A\\B'));
        $this->assertEquals(null, $loader->basepath($d, 'D'));
    }
}
