<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Arr as _Arr;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedArrFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * ArrF
 */
class ArrF extends GeneratedArrFacade
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
     * @return _Arr
     */
    public static function getInstance() : _Arr
    {
        return SupportFactory::getInstance()->getArr();
    }
}
