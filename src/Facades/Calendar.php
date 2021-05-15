<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Calendar as _Calendar;
use Gzhegow\Support\Facades\Generated\Calendar as CalendarGenerated;

class Calendar extends CalendarGenerated
{
    public static function getInstance() : _Calendar
    {
        return new _Calendar(
            Filter::getInstance()
        );
    }
}
