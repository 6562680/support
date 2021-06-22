<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Filter as _Filter;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedFilterFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Filter
 */
class Filter extends GeneratedFilterFacade
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
     * @param _Filter $instance
     *
     * @return void
     */
    public static function withInstance(_Filter $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Filter
     */
    public static function getInstance() : _Filter
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newFilter();
    }


    /**
     * @var _Filter[]
     */
    protected static $instance = [];
}
