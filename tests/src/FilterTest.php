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

        $this->assertEquals(null, $filter->filterClassFQN(null));
        $this->assertEquals(null, $filter->filterClassFQN(0));
        $this->assertEquals(null, $filter->filterClassFQN(''));
        $this->assertEquals(null, $filter->filterClassFQN('0'));

        $this->assertIsString($filter->filterClassFQN($class));
        $this->assertIsString($filter->filterClassFQN($currentClass));
        $this->assertIsString($filter->filterClassFQN($globalClass));
        $this->assertIsString($filter->filterClassFQN($currentGlobalClass));
    }
}
