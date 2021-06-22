<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Debug as _Debug;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedDebugFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Debug
 */
class Debug extends GeneratedDebugFacade
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
     * @param _Debug $instance
     *
     * @return void
     */
    public static function withInstance(_Debug $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Debug
     */
    public static function getInstance() : _Debug
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newDebug();
    }


    /**
     * @var _Debug[]
     */
    protected static $instance = [];
}
