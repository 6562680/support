<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Calendar;
use Gzhegow\Support\Domain\SupportFactory;


class CalendarTest extends AbstractTestCase
{
    protected function getCalendar() : Calendar
    {
        return ( new SupportFactory() )->newCalendar();
    }


    public function testIsSame()
    {
        $calendar = $this->getCalendar();

        $today1 = $calendar->today();
        $today2 = $calendar->today();

        $this->assertEquals(true, $calendar->isSame($today1, $today2));
    }


    public function testIsBefore()
    {
        $calendar = $this->getCalendar();

        $now = $calendar->now();
        $today = $calendar->today();

        $this->assertEquals(true, $calendar->isBefore($now, $today));
    }

    public function testIsBeforeOrSame()
    {
        $calendar = $this->getCalendar();

        $now = $calendar->now();
        $today1 = $calendar->today();
        $today2 = $calendar->today();

        $this->assertEquals(true, $calendar->isBeforeOrSame($now, $today1));
        $this->assertEquals(true, $calendar->isBeforeOrSame($today1, $today2));
    }


    public function testIsAfter()
    {
        $calendar = $this->getCalendar();

        $now = $calendar->now();
        $today = $calendar->today();

        $this->assertEquals(true, $calendar->isAfter($today, $now));
    }

    public function testIsAfterOrSame()
    {
        $calendar = $this->getCalendar();

        $now = $calendar->now();
        $today1 = $calendar->today();
        $today2 = $calendar->today();

        $this->assertEquals(true, $calendar->isAfterOrSame($today1, $now));
        $this->assertEquals(true, $calendar->isAfterOrSame($today1, $today2));
    }


    public function testIsBetween()
    {
        $calendar = $this->getCalendar();

        $now1 = $calendar->now();
        $now2 = $calendar->now();
        $now3 = $calendar->now();
        $now4 = $calendar->now();

        $this->assertEquals(true, $calendar->isBetween($now2, [ $now1, $now3, $now4 ]));
    }

    public function testIsIntersect()
    {
        $calendar = $this->getCalendar();

        $now1 = $calendar->now();
        $now2 = $calendar->now();
        $now3 = $calendar->now();
        $now4 = $calendar->now();

        $this->assertEquals(true, $calendar->isIntersect(
            [ $now1, $now3 ],
            [ $now2, $now4 ]
        ));
    }


    public function testAdd()
    {
        $calendar = $this->getCalendar();

        $now1 = $calendar->now();
        $now2 = $calendar->now();
        $calendar->add($now2, '1', 'day');

        $this->assertEquals(1, $now2->diff($now1)->d);
    }

    public function testDiff()
    {
        $calendar = $this->getCalendar();

        $now1 = $calendar->today();
        $now2 = $calendar->today();
        $now2->add(new \DateInterval('P1D'));

        $this->assertEquals(-86400, $calendar->diff($now1, $now2));
    }


    public function testDateval()
    {
        $calendar = $this->getCalendar();

        $dateTime = new \DateTime();
        $dateTimezone = new \DateTimeZone('America/Los_Angeles');

        $this->assertEquals(1, $calendar->dateval(1)->getTimestamp());
        $this->assertEquals(1, $calendar->dateval(1.0)->getTimestamp());
        $this->assertEquals('1.100000', $calendar->dateval(1.1)->format('U.u'));
        $this->assertEquals(1, $calendar->dateval('1')->getTimestamp());
        $this->assertEquals(1, $calendar->dateval('1.0')->getTimestamp());
        $this->assertEquals('1.100000', $calendar->dateval('1.1')->format('U.u'));

        $this->assertEquals(
            date_create('now', $dateTimezone)
                ->format('Ymd'),

            $calendar->dateval('now', $dateTimezone)->format('Ymd')
        );

        $this->assertEquals(
            date_create('now', $dateTimezone)
                ->add(new \DateInterval('PT86400S'))
                ->format('Ymd'),

            $calendar->dateval('+1 day', $dateTimezone)->format('Ymd')
        );

        $this->assertEquals(
            date_create_from_format('Y-m-d H:i:s', '2020-01-01 00:00:00', $dateTimezone)
                ->format('Ymd'),

            $calendar->dateval('2020-01-01 00:00:00', $dateTimezone)->format('Ymd')
        );

        $this->assertEquals($dateTime, $calendar->dateval($dateTime));
    }

    public function testTimezoneval()
    {
        $calendar = $this->getCalendar();

        $calendar->setDefaultTimezone('UTC');

        $this->assertEquals('Africa/Algiers', $calendar->timezoneval(1)->getName());
        $this->assertEquals('Africa/Algiers', $calendar->timezoneval(2.0)->getName());
        $this->assertEquals('Africa/Addis_Ababa', $calendar->timezoneval(3.1)->getName());
        $this->assertEquals('Atlantic/Madeira', $calendar->timezoneval('-1')->getName());
        $this->assertEquals('America/Pangnirtung', $calendar->timezoneval('-2.0')->getName());
        $this->assertEquals('America/Blanc-Sablon', $calendar->timezoneval('-3.1')->getName());
        $this->assertEquals('America/Blanc-Sablon', $calendar->timezoneval('America/Blanc-Sablon')->getName());
    }

    public function testInterval()
    {
        $calendar = $this->getCalendar();

        $this->assertEquals(1, $calendar->interval(1, 'day')->d);
    }


    public function testNow()
    {
        $calendar = $this->getCalendar();

        $now0 = date_create();
        $now1 = $calendar->now();
        $now2 = $calendar->now();

        $this->assertGreaterThan($now0, $now1);
        $this->assertGreaterThan($now0, $now2);
        $this->assertGreaterThan($now1, $now2);
    }

    public function testToday()
    {
        $calendar = $this->getCalendar();

        $now = date_create();
        $today1 = $calendar->today();
        $today2 = $calendar->today();

        $this->assertGreaterThan($now, $today1);
        $this->assertGreaterThan($now, $today2);
        $this->assertEquals($today1, $today2);
    }
}
