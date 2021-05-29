<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Filter as _Filter;
use Gzhegow\Support\Facades\Generated\GeneratedFilterFacade;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Filter
 */
class Filter extends GeneratedFilterFacade
{
    /**
     * Constructor
     */
    protected function __construct()
    {
        throw new BadMethodCallException('Class should be used statically: ' . __CLASS__);
    }


    /**
     * @return _Filter
     */
    public static function getInstance() : _Filter
    {
        return ( new SupportFactory() )->newFilter();
    }
}
