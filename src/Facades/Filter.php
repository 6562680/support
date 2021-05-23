<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Filter as _Filter;
use Gzhegow\Support\Facades\Generated\GeneratedFilterFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Filter
 */
class Filter extends GeneratedFilterFacade
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
     * @return _Filter
     */
    public static function getInstance() : _Filter
    {
        return new _Filter();
    }
}
