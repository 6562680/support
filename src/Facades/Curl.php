<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Curl as _Curl;
use Gzhegow\Support\Facades\Generated\GeneratedCurlFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Curl
 */
class Curl extends GeneratedCurlFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Curl
     */
    public static function getInstance() : _Curl
    {
        return new _Curl(
            Arr::getInstance(),
            Filter::getInstance(),
            Php::getInstance()
        );
    }
}
