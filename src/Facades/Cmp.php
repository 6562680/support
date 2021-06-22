<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cmp as _Cmp;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedCmpFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Cmp
 */
class Cmp extends GeneratedCmpFacade
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
     * @param _Cmp $instance
     *
     * @return void
     */
    public static function withInstance(_Cmp $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Cmp
     */
    public static function getInstance() : _Cmp
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newCmp();
    }


    /**
     * @var _Cmp[]
     */
    protected static $instance = [];
}
