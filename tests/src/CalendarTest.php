<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ZCalendar;
use Gzhegow\Support\ICalendar;


class CalendarTest extends AbstractTestCase
{
    protected function getCalendar() : ICalendar
    {
        return ZCalendar::getInstance();
    }


    public function testDateval()
    {
        $calendar = $this->getCalendar();

        $dateTime = new \DateTime();
        $dateTimezone = new \DateTimeZone('America/Los_Angeles');

        $this->assertEquals(1, $calendar->dateVal(1)->getTimestamp());
        $this->assertEquals(1, $calendar->dateVal(1.0)->getTimestamp());
        $this->assertEquals('1.100000', $calendar->dateVal(1.1)->format('U.u'));
        $this->assertEquals(1, $calendar->dateVal('1')->getTimestamp());
        $this->assertEquals(1, $calendar->dateVal('1.0')->getTimestamp());
        $this->assertEquals('1.100000', $calendar->dateVal('1.1')->format('U.u'));

        $this->assertEquals(
            date_create('now', $dateTimezone)
                ->format('Ymd'),

            $calendar->dateVal('now', $dateTimezone)->format('Ymd')
        );

        $this->assertEquals(
            date_create('now', $dateTimezone)
                ->add(new \DateInterval('PT86400S'))
                ->format('Ymd'),

            $calendar->dateVal('+1 day', $dateTimezone)->format('Ymd')
        );

        $this->assertEquals(
            date_create_from_format('Y-m-d H:i:s', '2020-01-01 00:00:00', $dateTimezone)
                ->format('Ymd'),

            $calendar->dateVal('2020-01-01 00:00:00', $dateTimezone)->format('Ymd')
        );

        $this->assertEquals($dateTime, $calendar->dateVal($dateTime));
    }

    public function testTimezoneval()
    {
        $calendar = $this->getCalendar();

        $calendar->setDefaultTimezone('UTC');

        $this->assertEquals('Africa/Algiers', $calendar->timezoneVal(1)->getName());
        $this->assertEquals('Africa/Algiers', $calendar->timezoneVal(2.0)->getName());
        $this->assertEquals('Africa/Addis_Ababa', $calendar->timezoneVal(3.1)->getName());
        $this->assertEquals('Atlantic/Madeira', $calendar->timezoneVal('-1')->getName());
        $this->assertEquals('America/Pangnirtung', $calendar->timezoneVal('-2.0')->getName());
        $this->assertEquals('America/Blanc-Sablon', $calendar->timezoneVal('-3.1')->getName());
        $this->assertEquals('America/Blanc-Sablon', $calendar->timezoneVal('America/Blanc-Sablon')->getName());
    }

    public function testInterval()
    {
        $calendar = $this->getCalendar();

        $this->assertEquals(1, $calendar->intervalVal(1, 'day')->d);
    }


    public function testIsSame()
    {
        $calendar = $this->getCalendar();

        $nowSame1 = $calendar->now();
        $nowSame2 = $calendar->now();

        $this->assertEquals(true, $calendar->isSame($nowSame1, $nowSame2));
    }

    public function testIsBefore()
    {
        $calendar = $this->getCalendar();

        $now = $calendar->nowInstant();
        $nowSame = $calendar->now();

        $this->assertEquals(true, $calendar->isBefore($now, $nowSame));
    }

    public function testIsBeforeOrSame()
    {
        $calendar = $this->getCalendar();

        $now = $calendar->nowInstant();
        $nowSame1 = $calendar->now();
        $nowSame2 = $calendar->now();

        $this->assertEquals(true, $calendar->isBeforeOrSame($now, $nowSame1));
        $this->assertEquals(true, $calendar->isBeforeOrSame($nowSame1, $nowSame2));
    }

    public function testIsAfter()
    {
        $calendar = $this->getCalendar();

        $now = $calendar->nowInstant();
        $nowSame = $calendar->now();

        $this->assertEquals(true, $calendar->isAfter($nowSame, $now));
    }

    public function testIsAfterOrSame()
    {
        $calendar = $this->getCalendar();

        $now = $calendar->nowInstant();
        $nowSame1 = $calendar->now();
        $nowSame2 = $calendar->now();

        $this->assertEquals(true, $calendar->isAfterOrSame($nowSame1, $now));
        $this->assertEquals(true, $calendar->isAfterOrSame($nowSame1, $nowSame2));
    }


    public function testIsBetween()
    {
        $calendar = $this->getCalendar();

        $now1 = $calendar->nowInstant();
        $now2 = $calendar->nowInstant();
        $now3 = $calendar->nowInstant();
        $now4 = $calendar->nowInstant();

        $this->assertEquals(true, $calendar->isBetween($now2, [ $now1, $now3, $now4 ]));
    }

    public function testIsIntersect()
    {
        $calendar = $this->getCalendar();

        $now1 = $calendar->nowInstant();
        $now2 = $calendar->nowInstant();
        $now3 = $calendar->nowInstant();
        $now4 = $calendar->nowInstant();

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
        $calendar->dateAdd($now2, 1, 'day');

        $this->assertEquals(86400, $calendar->diff($now2, $now1));
    }

    public function testSub()
    {
        $calendar = $this->getCalendar();

        $now1 = $calendar->now();
        $now2 = $calendar->now();
        $calendar->dateSub($now2, 1, 'day');

        $this->assertEquals(-86400, $calendar->diff($now2, $now1));
    }


    public function testDiff()
    {
        $calendar = $this->getCalendar();

        $now1 = $calendar->now();
        $now2 = $calendar->now();
        $now2->add(new \DateInterval('P1D'));

        $this->assertEquals(-86400, $calendar->diff($now1, $now2));
    }


    public function testNow()
    {
        $calendar = $this->getCalendar();

        $now = date_create();
        $nowSame1 = $calendar->now();
        $nowSame2 = $calendar->now();

        $this->assertGreaterThan($now, $nowSame1);
        $this->assertGreaterThan($now, $nowSame2);
        $this->assertEquals($nowSame1, $nowSame2);
    }

    public function testNowInstant()
    {
        $calendar = $this->getCalendar();

        $now0 = date_create();
        $now1 = $calendar->nowInstant();
        $now2 = $calendar->nowInstant();

        $this->assertGreaterThan($now0, $now1);
        $this->assertGreaterThan($now0, $now2);
        $this->assertGreaterThan($now1, $now2);
    }
}