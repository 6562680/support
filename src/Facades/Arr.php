<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Facades\Generated\GeneratedArrFacade;
use Gzhegow\Support\Arr as _Arr;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Arr
 */
class Arr extends GeneratedArrFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Arr
     */
    public static function getInstance() : _Arr
    {
        return new _Arr(
            Filter::getInstance(),
            Php::getInstance(),
            Str::getInstance()
        );
    }
}
