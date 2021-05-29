<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Profiler as _Profiler;
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
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Profiler
     */
    public static function getInstance() : _Profiler
    {
        return ( new SupportFactory() )->newProfiler();
    }
}
