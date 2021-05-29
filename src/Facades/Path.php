<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Path as _Path;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedPathFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Path
 */
class Path extends GeneratedPathFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Path
     */
    public static function getInstance() : _Path
    {
        return ( new SupportFactory() )->newPath();
    }
}
