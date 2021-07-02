<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Path as _Path;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedPathFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * PathF
 */
class PathF extends GeneratedPathFacade
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
     * @return _Path
     */
    public static function getInstance() : _Path
    {
        return SupportFactory::getInstance()->getPath();
    }
}
