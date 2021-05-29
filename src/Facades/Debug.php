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
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Debug
     */
    public static function getInstance() : _Debug
    {
        return ( new SupportFactory() )->newDebug();
    }
}
