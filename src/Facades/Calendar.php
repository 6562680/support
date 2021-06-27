<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Domain\SupportFactory;
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
    final private function __construct()
    {
        throw new BadMethodCallException(
            [ 'Facade should be used statically: %s', static::class ]
        );
    }


    /**
     * @return _Calendar
     */
    public static function getInstance() : _Calendar
    {
        return SupportFactory::getInstance()->getCalendar();
    }
}
