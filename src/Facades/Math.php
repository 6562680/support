<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Math as _Math;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedMathFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Math
 */
class Math extends GeneratedMathFacade
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
     * @param _Math $instance
     *
     * @return void
     */
    public static function withInstance(_Math $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Math
     */
    public static function getInstance() : _Math
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newMath();
    }


    /**
     * @var _Math[]
     */
    protected static $instance = [];
}
