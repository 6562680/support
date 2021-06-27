<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Php as _Php;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedPhpFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Php
 */
class Php extends GeneratedPhpFacade
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
     * @return _Php
     */
    public static function getInstance() : _Php
    {
        return SupportFactory::getInstance()->getPhp();
    }
}
