<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XProf;
use Gzhegow\Support\IProf;


class ProfTest extends AbstractTestCase
{
    protected function getProf() : IProf
    {
        return XProf::getInstance();
    }


    public function testReport()
    {
        $profiler = $this->getProf();

        $profiler->tick(__METHOD__);
        $profiler->tick(__METHOD__);

        $report = $profiler->report(0);
        $reportDecimals = $profiler->report(6);

        $cut = str_replace(' | ' . __METHOD__, '', $report[ 1 ]);

        $cutDecimals = str_replace(' | ' . __METHOD__, '', $reportDecimals[ 1 ]);
        $numberDecimals = ltrim($cutDecimals, '+ ');

        $this->assertEquals('+ 1', $cut);
        $this->assertGreaterThanOrEqual(0.000001, $numberDecimals);
    }

    public function testProfileComment()
    {
        $profiler = $this->getProf();

        $profiler->tick('^ Hello');
        $profiler->tick('$ Hello');

        usleep(500000);

        $profiler->tick('^ Hello');
        $profiler->tick('$ Hello');

        $report = $profiler->report(1);

        $expect = [
            $report[ 0 ],
            "+ 0.1 | $ Hello",
            "+ 0.6 | ^ Hello",
            "+ 0.1 | $ Hello",
        ];

        $this->assertEquals($expect, $report);
    }
}