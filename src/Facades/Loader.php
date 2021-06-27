<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Loader as _Loader;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedLoaderFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Loader
 */
class Loader extends GeneratedLoaderFacade
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
     * @return _Loader
     */
    public static function getInstance() : _Loader
    {
        return SupportFactory::getInstance()->getLoader();
    }
}
