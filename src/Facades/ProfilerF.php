<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Profiler as _Profiler;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Facades\Generated\GeneratedProfilerFacade;


/**
 * ProfilerF
 */
class ProfilerF extends GeneratedProfilerFacade
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
     * @return _Profiler
     */
    public static function getInstance() : _Profiler
    {
        return SupportFactory::getInstance()->getProfiler();
    }
}
