<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Math as _Math;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedMathFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Math
 */
class Math extends GeneratedMathFacade
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
     * @return _Math
     */
    public static function getInstance() : _Math
    {
        return SupportFactory::getInstance()->getMath();
    }
}
