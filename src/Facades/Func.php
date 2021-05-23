<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Func as _Func;
use Gzhegow\Support\Facades\Generated\GeneratedFuncFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Func
 */
class Func extends GeneratedFuncFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Func
     */
    public static function getInstance() : _Func
    {
        return new _Func();
    }
}
