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
     * @param _Calendar $instance
     *
     * @return void
     */
    public static function withInstance(_Calendar $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Calendar
     */
    public static function getInstance() : _Calendar
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newCalendar();
    }


    /**
     * @var _Calendar[]
     */
    protected static $instance = [];
}
