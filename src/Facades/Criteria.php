<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Criteria as _Criteria;
use Gzhegow\Support\Facades\Generated\GeneratedCriteriaFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Criteria
 */
class Criteria extends GeneratedCriteriaFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Criteria
     */
    public static function getInstance() : _Criteria
    {
        return ( new SupportFactory() )->newCriteria();
    }
}
