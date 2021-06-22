<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Net as _Net;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedNetFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Net
 */
class Net extends GeneratedNetFacade
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
     * @param _Net $instance
     *
     * @return void
     */
    public static function withInstance(_Net $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Net
     */
    public static function getInstance() : _Net
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newNet();
    }


    /**
     * @var _Net[]
     */
    protected static $instance = [];
}
