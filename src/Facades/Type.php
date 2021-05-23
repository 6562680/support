<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Type as _Type;
use Gzhegow\Support\Facades\Generated\GeneratedTypeFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Type
 */
class Type extends GeneratedTypeFacade
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
     * @return _Type
     */
    public static function getInstance() : _Type
    {
        return new _Type(
            Filter::getInstance()
        );
    }
}
