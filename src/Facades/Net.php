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
     * @return _Net
     */
    public static function getInstance() : _Net
    {
        return SupportFactory::getInstance()->getNet();
    }
}
