<?php

namespace Gzhegow\Support\Traits;

use Gzhegow\Support\ICalendar;


/**
 * Trait
 */
trait CalendarAwareTrait
{
    /**
     * @var ICalendar
     */
    protected $calendar;


    /**
     * @param ICalendar $calendar
     *
     * @return void
     */
    public function setCalendar(ICalendar $calendar)
    {
        $this->calendar = $calendar;
    }
}