<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Debug as _Debug;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedDebugFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * DebugF
 */
class DebugF extends GeneratedDebugFacade
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
     * @return _Debug
     */
    public static function getInstance() : _Debug
    {
        return SupportFactory::getInstance()->getDebug();
    }
}
