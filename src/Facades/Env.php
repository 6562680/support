<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Env as _Env;
use Gzhegow\Support\Facades\Generated\GeneratedEnvFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Env
 */
class Env extends GeneratedEnvFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Env
     */
    public static function getInstance() : _Env
    {
        return new _Env();
    }
}
