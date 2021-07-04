<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Cmp;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Calendar;
use Gzhegow\Support\Domain\SupportFactory;


class FilterTest extends AbstractTestCase
{
    protected function getFilter() : Filter
    {
        return SupportFactory::getInstance()->newFilter();
    }

    public function testFilterClass()
    {
        $filter = $this->getFilter();

        $empty = '';
        $class = 'StdClass';
        $currentClass = __CLASS__;
        $globalClass = '\StdClass';
        $currentGlobalClass = '\\' . __CLASS__;

        $this->assertEquals(null, $filter->filterClass(null));
        $this->assertEquals(null, $filter->filterClass(0));
        $this->assertEquals(null, $filter->filterClass(''));
        $this->assertEquals(null, $filter->filterClass('0'));

        $this->assertIsString($filter->filterClass($class));
        $this->assertIsString($filter->filterClass($currentClass));
        $this->assertIsString($filter->filterClass($globalClass));
        $this->assertIsString($filter->filterClass($currentGlobalClass));
    }
}
