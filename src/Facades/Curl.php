<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Curl as _Curl;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedCurlFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Curl
 */
class Curl extends GeneratedCurlFacade
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
     * @return _Curl
     */
    public static function getInstance() : _Curl
    {
        return SupportFactory::getInstance()->getCurl();
    }
}
