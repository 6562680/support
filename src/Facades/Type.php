<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Type as _Type;
use Gzhegow\Support\Facades\Generated\GeneratedTypeFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Type
 */
class Type extends GeneratedTypeFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }

    /**
     * @return _Type
     */
    public static function getInstance() : _Type
    {
        return new _Type(
            Filter::getInstance()
        );
    }
}
