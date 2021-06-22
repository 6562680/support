<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Format as _Format;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedFormatFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Format
 */
class Format extends GeneratedFormatFacade
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
     * @param _Format $instance
     *
     * @return void
     */
    public static function withInstance(_Format $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Format
     */
    public static function getInstance() : _Format
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newFormat();
    }


    /**
     * @var _Format[]
     */
    protected static $instance = [];
}
