<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Preg as _Preg;
use Gzhegow\Support\Facades\Generated\GeneratedPregFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Preg
 */
class Preg extends GeneratedPregFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Preg
     */
    public static function getInstance() : _Preg
    {
        return new _Preg(
            Str::getInstance()
        );
    }
}
