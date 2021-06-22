<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Uri as _Uri;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedUriFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Uri
 */
class Uri extends GeneratedUriFacade
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
     * @param _Uri $instance
     *
     * @return void
     */
    public static function withInstance(_Uri $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Uri
     */
    public static function getInstance() : _Uri
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newUri();
    }


    /**
     * @var _Uri[]
     */
    protected static $instance = [];
}
