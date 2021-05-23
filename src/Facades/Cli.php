<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cli as _Cli;
use Gzhegow\Support\Facades\Generated\GeneratedCliFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Cli
 */
class Cli extends GeneratedCliFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Cli
     */
    public static function getInstance() : _Cli
    {
        return new _Cli(
            Env::getInstance(),
            Php::getInstance()
        );
    }
}
