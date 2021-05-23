<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cmp as _Cmp;
use Gzhegow\Support\Facades\Generated\GeneratedCmpFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Cmp
 */
class Cmp extends GeneratedCmpFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Cmp
     */
    public static function getInstance() : _Cmp
    {
        return new _Cmp(
            Calendar::getInstance(),
            Type::getInstance()
        );
    }
}
