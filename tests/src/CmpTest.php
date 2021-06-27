<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Cmp;
use Gzhegow\Support\Calendar;
use Gzhegow\Support\Domain\SupportFactory;


class CmpTest extends AbstractTestCase
{
    protected function getCalendar() : Calendar
    {
        return SupportFactory::getInstance()->newCalendar();
    }

    protected function getCmp() : Cmp
    {
        return SupportFactory::getInstance()->newCmp();
    }


    public function testCmpDate()
    {
        $calendar = $this->getCalendar();
        $cmp = $this->getCmp();

        $dt[] = $dt1 = $calendar->theDateVal(50);
        $dt[] = $dt3 = $calendar->theDateVal(200);
        $dt[] = $dt2 = $calendar->theDateVal(100);

        usort($dt, [ $cmp, 'cmpdate' ]);

        $this->assertEquals([ $dt1, $dt2, $dt3 ], $dt);
    }
}
