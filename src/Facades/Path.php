<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Path as _Path;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedPathFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Path
 */
class Path extends GeneratedPathFacade
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
     * @param _Path $instance
     *
     * @return void
     */
    public static function withInstance(_Path $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Path
     */
    public static function getInstance() : _Path
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newPath();
    }


    /**
     * @var _Path[]
     */
    protected static $instance = [];
}
