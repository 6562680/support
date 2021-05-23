<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Facades\Generated\GeneratedBcmathFacade;
use Gzhegow\Support\Bcmath as _Bcmath;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Bcmath
 */
class Bcmath extends GeneratedBcmathFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Bcmath
     */
    public static function getInstance() : _Bcmath
    {
        return new _Bcmath();
    }
}
