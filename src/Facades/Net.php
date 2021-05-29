<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Net as _Net;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedNetFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Net
 */
class Net extends GeneratedNetFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Net
     */
    public static function getInstance() : _Net
    {
        return ( new SupportFactory() )->newNet();
    }
}
