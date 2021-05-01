<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Filter;
use Gzhegow\Support\Calendar;
use Gzhegow\Support\Profiler;
use Gzhegow\Support\Domain\Type\Assert;


class ProfilerTest extends AbstractTestCase
{
    protected function getAssert() : Assert
    {
        return new Assert();
    }

    protected function getFilter() : Filter
    {
        return new Filter(
            $this->getAssert()
        );
    }

    protected function getCalendar() : Calendar
    {
        return new Calendar(
            $this->getFilter()
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
