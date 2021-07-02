<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Preg as _Preg;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedPregFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * PregF
 */
class PregF extends GeneratedPregFacade
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
     * @return _Preg
     */
    public static function getInstance() : _Preg
    {
        return SupportFactory::getInstance()->getPreg();
    }
}
