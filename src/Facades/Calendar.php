<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Calendar as _Calendar;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Facades\Generated\GeneratedCalendarFacade;


/**
 * Calendar
 */
class Calendar extends GeneratedCalendarFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Calendar
     */
    public static function getInstance() : _Calendar
    {
        return new _Calendar(
            Filter::getInstance(),
            Php::getInstance(),
            Str::getInstance()
        );
    }
}
