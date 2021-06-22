<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Profiler as _Profiler;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Facades\Generated\GeneratedProfilerFacade;


/**
 * Profiler
 */
class Profiler extends GeneratedProfilerFacade
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
     * @param _Profiler $instance
     *
     * @return void
     */
    public static function withInstance(_Profiler $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Profiler
     */
    public static function getInstance() : _Profiler
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newProfiler();
    }


    /**
     * @var _Profiler[]
     */
    protected static $instance = [];
}
