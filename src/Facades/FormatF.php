<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Format as _Format;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedFormatFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * FormatF
 */
class FormatF extends GeneratedFormatFacade
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
     * @return _Format
     */
    public static function getInstance() : _Format
    {
        return SupportFactory::getInstance()->getFormat();
    }
}