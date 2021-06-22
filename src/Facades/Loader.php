<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Loader as _Loader;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedLoaderFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Loader
 */
class Loader extends GeneratedLoaderFacade
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
     * @param _Loader $instance
     *
     * @return void
     */
    public static function withInstance(_Loader $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Loader
     */
    public static function getInstance() : _Loader
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newLoader();
    }


    /**
     * @var _Loader[]
     */
    protected static $instance = [];
}
