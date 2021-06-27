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
     * @return _Fs
     */
    public static function getInstance() : _Fs
    {
        return SupportFactory::getInstance()->getFs();
    }
}
