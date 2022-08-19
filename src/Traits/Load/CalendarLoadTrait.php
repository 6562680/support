<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\ICalendar;
use Gzhegow\Support\SupportFactory;


/**
 * Trait
 */
trait CalendarLoadTrait
{
    /**
     * @var ICalendar
     */
    protected $calendar;


    /**
     * @param null|ICalendar $calendar
     *
     * @return static
     */
    public function withCalendar(?ICalendar $calendar)
    {
        $this->calendar = $calendar;

        return $this;
    }


    /**
     * @return ICalendar
     */
    protected function loadCalendar() : ICalendar
    {
        return SupportFactory::getInstance()->getCalendar();
    }


    /**
     * @return ICalendar
     */
    public function getCalendar() : ICalendar
    {
        return $this->calendar = $this->calendar
            ?? $this->loadCalendar();
    }
}