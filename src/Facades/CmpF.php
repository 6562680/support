<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cmp as _Cmp;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedCmpFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * CmpF
 */
class CmpF extends GeneratedCmpFacade
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
     * @return _Cmp
     */
    public static function getInstance() : _Cmp
    {
        return SupportFactory::getInstance()->getCmp();
    }
}
