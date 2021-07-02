<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Num as _Num;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedNumFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * NumF
 */
class NumF extends GeneratedNumFacade
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
     * @return _Num
     */
    public static function getInstance() : _Num
    {
        return SupportFactory::getInstance()->getNum();
    }
}
