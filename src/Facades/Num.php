<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Num as _Num;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Facades\Generated\GeneratedNumFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Num
 */
class Num extends GeneratedNumFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Num
     */
    public static function getInstance() : _Num
    {
        return ( new SupportFactory() )->newNum();
    }
}
