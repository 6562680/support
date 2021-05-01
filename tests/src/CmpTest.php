<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Cmp;
use Gzhegow\Support\Type;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Calendar;
use Gzhegow\Support\Domain\Type\Assert;


class CmpTest extends AbstractTestCase
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

    protected function getType() : Type
    {
        return new Type(
            $this->getAssert()
        );
    }

    protected function getCalendar() : Calendar
    {
        return new Calendar(
            $this->getFilter()
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

        $dt[] = $dt1 = $calendar->date(50);
        $dt[] = $dt3 = $calendar->date(200);
        $dt[] = $dt2 = $calendar->date(100);

        usort($dt, [ $cmp, 'cmpdate' ]);

        $this->assertEquals([ $dt1, $dt2, $dt3 ], $dt);
    }
}
