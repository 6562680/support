<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ZFilter;
use Gzhegow\Support\IFilter;


class FilterTest extends AbstractTestCase
{
    protected function getFilter() : IFilter
    {
        return ZFilter::getInstance();
    }


    public function testFilterClass()
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
}
