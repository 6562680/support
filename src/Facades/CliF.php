<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cli as _Cli;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedCliFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * CliF
 */
class CliF extends GeneratedCliFacade
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
     * @return _Cli
     */
    public static function getInstance() : _Cli
    {
        return SupportFactory::getInstance()->getCli();
    }
}
