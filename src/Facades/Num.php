<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Num as _Num;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedNumFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Num
 */
class Num extends GeneratedNumFacade
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
     * @param _Num $instance
     *
     * @return void
     */
    public static function withInstance(_Num $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Num
     */
    public static function getInstance() : _Num
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newNum();
    }


    /**
     * @var _Num[]
     */
    protected static $instance = [];
}
