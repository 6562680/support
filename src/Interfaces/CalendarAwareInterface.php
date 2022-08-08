<?php

namespace Gzhegow\Support\Interfaces;

use Gzhegow\Support\ICalendar;


/**
 * Interface
 */
interface CalendarAwareInterface
{
    /**
     * @param ICalendar $arr
     *
     * @return void
     */
    public function setCalendar(ICalendar $arr);
}