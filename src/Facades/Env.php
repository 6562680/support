<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Env as _Env;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedEnvFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Env
 */
class Env extends GeneratedEnvFacade
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
     * @param _Env $instance
     *
     * @return void
     */
    public static function withInstance(_Env $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Env
     */
    public static function getInstance() : _Env
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newEnv();
    }


    /**
     * @var _Env[]
     */
    protected static $instance = [];
}
