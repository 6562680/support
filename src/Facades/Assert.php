<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Assert as _Assert;
use Gzhegow\Support\Facades\Generated\GeneratedAssertFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Assert
 */
class Assert extends GeneratedAssertFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return bool
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([ static::getInstance(), $method ], $arguments);
    }


    /**
     * @return _Assert
     */
    public static function getInstance() : _Assert
    {
        return new _Assert(
            Filter::getInstance()
        );
    }
}
