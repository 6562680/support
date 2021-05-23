<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Loader as _Loader;
use Gzhegow\Support\Facades\Generated\GeneratedLoaderFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Loader
 */
class Loader extends GeneratedLoaderFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Loader
     */
    public static function getInstance() : _Loader
    {
        return new _Loader(
            Str::getInstance(),
        );
    }
}
