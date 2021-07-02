<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Str as _Str;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedStrFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * StrF
 */
class StrF extends GeneratedStrFacade
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
     * @return _Str
     */
    public static function getInstance() : _Str
    {
        return SupportFactory::getInstance()->getStr();
    }
}
