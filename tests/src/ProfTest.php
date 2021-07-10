<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Prof;
use Gzhegow\Support\IProf;


class ProfTest extends AbstractTestCase
{
    protected function getProf() : IProf
    {
        return Prof::getInstance();
    }


    public function testReport()
    {
        $profiler = $this->getProf();

        $profiler->tick();
        $profiler->tick();

        $report = $profiler->report(0);

        $this->assertTrue(0 === strpos($report[ 1 ], '+ 0 | ' . __METHOD__));
    }

    public function testProfileComment()
    {
        $profiler = $this->getProf();

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
