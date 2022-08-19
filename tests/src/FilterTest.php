<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XFilter;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class FilterTest extends AbstractTestCase
{
    protected function getFilter() : XFilter
    {
        return XFilter::getInstance();
    }


    public function testFilterClassFullname()
    {
        $filter = $this->getFilter();

        $empty = '';
        $class = 'StdClass';
        $currentClass = __CLASS__;
        $globalClass = '\StdClass';
        $currentGlobalClass = '\\' . __CLASS__;

        $this->assertEquals(null, $filter->filterClassFullname(null));
        $this->assertEquals(null, $filter->filterClassFullname(0));
        $this->assertEquals(null, $filter->filterClassFullname(''));
        $this->assertEquals(null, $filter->filterClassFullname('0'));

        $this->assertIsString($filter->filterClassFullname($class));
        $this->assertIsString($filter->filterClassFullname($currentClass));
        $this->assertIsString($filter->filterClassFullname($globalClass));
        $this->assertIsString($filter->filterClassFullname($currentGlobalClass));
    }


    public function testAssertMessage()
    {
        $this->assertException(InvalidArgumentException::class,
            $try = function () {
                $this->getFilter()
                    ->assert('Hello %s')
                    ->assertNum('world');
            },
            $catch = function (InvalidArgumentException $e) {
                $this->assertEquals('Hello world', $e->getMessage());
            }
        );

        $this->assertException(InvalidArgumentException::class,
            $try = function () {
                $this->getFilter()
                    ->assert([ 'Hello %s', 'world' ])
                    ->assertNum('world');
            },
            $catch = function (InvalidArgumentException $e) {
                $this->assertEquals('Hello world', $e->getMessage());
            }
        );

        $this->assertException(InvalidArgumentException::class,
            $try = function () {
                $this->getFilter()
                    ->assert('Hello %s', 'world')
                    ->assertNum('world');
            },
            $catch = function (InvalidArgumentException $e) {
                $this->assertEquals('Hello world', $e->getMessage());
            }
        );
    }

    public function testAssertThrowable()
    {
        $this->assertException(InvalidArgumentException::class,
            $try = function () {
                $this->getFilter()
                    ->assert(new InvalidArgumentException([ 'Hello %s', 'world' ]))
                    ->assertNum('world');
            },
            $catch = function (InvalidArgumentException $e) {
                $this->assertEquals('Hello world', $e->getMessage());
            }
        );
    }
}