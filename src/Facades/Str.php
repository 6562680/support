<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Str as _Str;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedStrFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Str
 */
class Str extends GeneratedStrFacade
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
     * @param _Str $instance
     *
     * @return void
     */
    public static function withInstance(_Str $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Str
     */
    public static function getInstance() : _Str
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newStr();
    }


    /**
     * @var _Str[]
     */
    protected static $instance = [];
}
