<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Criteria as _Criteria;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Facades\Generated\GeneratedCriteriaFacade;


/**
 * CriteriaF
 */
class CriteriaF extends GeneratedCriteriaFacade
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
     * @return _Criteria
     */
    public static function getInstance() : _Criteria
    {
        return SupportFactory::getInstance()->getCriteria();
    }
}
