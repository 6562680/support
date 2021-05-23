<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Uri as _Uri;
use Gzhegow\Support\Facades\Generated\GeneratedUriFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Uri
 */
class Uri extends GeneratedUriFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Uri
     */
    public static function getInstance() : _Uri
    {
        return new _Uri(
            Arr::getInstance(),
            Filter::getInstance(),
            Php::getInstance(),
            Str::getInstance()
        );
    }
}
