<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Env as _Env;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedEnvFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * EnvF
 */
class EnvF extends GeneratedEnvFacade
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
     * @return _Env
     */
    public static function getInstance() : _Env
    {
        return SupportFactory::getInstance()->getEnv();
    }
}
