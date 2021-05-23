<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Fs as _Fs;
use Gzhegow\Support\Facades\Generated\GeneratedFsFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Fs
 */
class Fs extends GeneratedFsFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Fs
     */
    public static function getInstance() : _Fs
    {
        return new _Fs(
            Filter::getInstance(),
            Path::getInstance(),
            Php::getInstance()
        );
    }
}
