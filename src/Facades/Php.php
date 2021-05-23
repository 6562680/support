<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Php as _Php;
use Gzhegow\Support\Facades\Generated\GeneratedPhpFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Php
 */
class Php extends GeneratedPhpFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Php
     */
    public static function getInstance() : _Php
    {
        return new _Php(
            Filter::getInstance()
        );
    }
}
