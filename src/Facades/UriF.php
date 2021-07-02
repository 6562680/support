<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Uri as _Uri;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedUriFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * UriF
 */
class UriF extends GeneratedUriFacade
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
     * @return _Uri
     */
    public static function getInstance() : _Uri
    {
        return SupportFactory::getInstance()->getUri();
    }
}
