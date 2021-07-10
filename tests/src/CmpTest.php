<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ZCmp;
use Gzhegow\Support\ICmp;
use Gzhegow\Support\ZCalendar;
use Gzhegow\Support\ICalendar;


class CmpTest extends AbstractTestCase
{
    protected function getCmp() : ICmp
    {
        return ZCmp::getInstance();
    }


    protected function getCalendar() : ICalendar
    {
        return ZCalendar::getInstance();
    }


    public function testCmpDate()
    {
        $cmp = $this->getCmp();

        $calendar = $this->getCalendar();

        $dt[] = $dt1 = $calendar->theDateVal(50);
        $dt[] = $dt3 = $calendar->theDateVal(200);
        $dt[] = $dt2 = $calendar->theDateVal(100);

        usort($dt, [ $cmp, 'cmpdate' ]);

        $this->assertEquals([ $dt1, $dt2, $dt3 ], $dt);
    }
}
