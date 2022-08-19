<?php

namespace Gzhegow\Support\Traits\Aware;

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