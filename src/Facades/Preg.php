<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Preg as _Preg;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedPregFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Preg
 */
class Preg extends GeneratedPregFacade
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
     * @param _Preg $instance
     *
     * @return void
     */
    public static function withInstance(_Preg $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Preg
     */
    public static function getInstance() : _Preg
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newPreg();
    }


    /**
     * @var _Preg[]
     */
    protected static $instance = [];
}
