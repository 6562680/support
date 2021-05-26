<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Php;
use Gzhegow\Support\Str;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Profiler;
use Gzhegow\Support\Calendar;


class ProfilerTest extends AbstractTestCase
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

    protected function getCalendar() : Calendar
    {
        return new Calendar(
            $this->getFilter(),
            $this->getPhp(),
            $this->getStr()
        );
    }

    protected function getProfiler() : Profiler
    {
        return new Profiler(
            $this->getCalendar()
        );
    }


    public function testProfile()
    {
        $profiler = $this->getProfiler();

        $profiler->tick();
        $profiler->tick();

        $report = $profiler->report();

        $this->assertTrue(0 === strpos($report[ 1 ], '+ 0 | Gzhegow\Support\Tests\ProfilerTest::testProfile'));
    }

    public function testProfileComment()
    {
        $profiler = $this->getProfiler();

        $profiler->tick('Hello');
        $profiler->tick('Hello');
        usleep(500000);
        $profiler->tick('Hello');
        $profiler->tick('Hello');

        $report = $profiler->report(1);

        $expect = [
            "+ 0 | Hello",
            "+ 0.5 | Hello",
            "+ 0 | Hello",
        ];

        $this->assertEquals($expect, array_slice($report, 1));
    }
}
