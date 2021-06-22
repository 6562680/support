<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cli as _Cli;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedCliFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Cli
 */
class Cli extends GeneratedCliFacade
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
     * @param _Cli $instance
     *
     * @return void
     */
    public static function withInstance(_Cli $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Cli
     */
    public static function getInstance() : _Cli
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newCli();
    }


    /**
     * @var _Cli[]
     */
    protected static $instance = [];
}
