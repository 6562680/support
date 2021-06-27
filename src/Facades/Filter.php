<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Filter as _Filter;
use Gzhegow\Support\Domain\SupportFactory;
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
    final private function __construct()
    {
        throw new BadMethodCallException(
            [ 'Facade should be used statically: %s', static::class ]
        );
    }


    /**
     * @return _Filter
     */
    public static function getInstance() : _Filter
    {
        return SupportFactory::getInstance()->getFilter();
    }
}
