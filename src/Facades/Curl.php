<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Curl as _Curl;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedCurlFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Curl
 */
class Curl extends GeneratedCurlFacade
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
     * @param _Curl $instance
     *
     * @return void
     */
    public static function withInstance(_Curl $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Curl
     */
    public static function getInstance() : _Curl
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newCurl();
    }


    /**
     * @var _Curl[]
     */
    protected static $instance = [];
}
