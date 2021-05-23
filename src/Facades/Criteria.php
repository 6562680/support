<?php

namespace Gzhegow\Support\Facades;

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
        return new _Criteria(
            Calendar::getInstance(),
            Cmp::getInstance(),
            Filter::getInstance(),
            Str::getInstance()
        );
    }
}
