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
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Format
     */
    public static function getInstance() : _Format
    {
        return ( new SupportFactory() )->newFormat();
    }
}
