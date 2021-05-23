<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Math as _Math;
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
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Math
     */
    public static function getInstance() : _Math
    {
        return new _Math(
            Php::getInstance(),
            Type::getInstance(),
        );
    }
}
