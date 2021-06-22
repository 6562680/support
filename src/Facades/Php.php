<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Php as _Php;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedPhpFacade;


/**
 * Php
 */
class Php extends GeneratedPhpFacade
{
    /**
     * @return _Php
     */
    public static function getInstance() : _Php
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newPhp();
    }


    /**
     * @var _Php[]
     */
    protected static $instance = [];
}
