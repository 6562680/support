<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Cmp;
use Gzhegow\Support\Php;
use Gzhegow\Support\Str;
use Gzhegow\Support\Type;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Calendar;


class CmpTest extends AbstractTestCase
{
    protected function getFilter() : Filter
    {
        return new Filter();
    }

    protected function getType() : Type
    {
        return new Type(
            $this->getFilter()
        );
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

    protected function getCmp() : Cmp
    {
        return new Cmp(
            $this->getCalendar(),
            $this->getType(),
        );
    }


    public function testCmpDate()
    {
        $calendar = $this->getCalendar();
        $cmp = $this->getCmp();

        $dt[] = $dt1 = $calendar->theDate(50);
        $dt[] = $dt3 = $calendar->theDate(200);
        $dt[] = $dt2 = $calendar->theDate(100);

        usort($dt, [ $cmp, 'cmpdate' ]);

        $this->assertEquals([ $dt1, $dt2, $dt3 ], $dt);
    }
}
