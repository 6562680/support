<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Assert as _Assert;
use Gzhegow\Support\Facades\Generated\GeneratedAssertFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Assert
 */
class Assert extends GeneratedAssertFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }

    /**
     * @return _Assert
     */
    public static function getInstance() : _Assert
    {
        return new _Assert(
            Filter::getInstance()
        );
    }
}
