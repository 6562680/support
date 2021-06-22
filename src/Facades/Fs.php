<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Fs as _Fs;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedFsFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Fs
 */
class Fs extends GeneratedFsFacade
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
     * @param _Fs $instance
     *
     * @return void
     */
    public static function withInstance(_Fs $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Fs
     */
    public static function getInstance() : _Fs
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newFs();
    }


    /**
     * @var _Fs[]
     */
    protected static $instance = [];
}
