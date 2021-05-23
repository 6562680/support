<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Str as _Str;
use Gzhegow\Support\Facades\Generated\GeneratedStrFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Str
 */
class Str extends GeneratedStrFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Str
     */
    public static function getInstance() : _Str
    {
        return new _Str(
            Filter::getInstance()
        );
    }
}
