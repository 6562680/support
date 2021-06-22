<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Arr as _Arr;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedArrFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Arr
 */
class Arr extends GeneratedArrFacade
{
    /**
     * Constructor
     */
    final private function __construct()
    {
        throw new BadMethodCallException(
            [ 'Facade should be used statically: %s', static::class ]
        );
    }


    /**
     * @param _Arr $instance
     *
     * @return void
     */
    public static function withInstance(_Arr $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Arr
     */
    public static function getInstance() : _Arr
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newArr();
    }


    /**
     * @var _Arr[]
     */
    protected static $instance = [];
}
