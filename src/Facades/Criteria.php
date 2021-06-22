<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Criteria as _Criteria;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;
use Gzhegow\Support\Facades\Generated\GeneratedCriteriaFacade;


/**
 * Criteria
 */
class Criteria extends GeneratedCriteriaFacade
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
     * @param _Criteria $instance
     *
     * @return void
     */
    public static function withInstance(_Criteria $instance) : void
    {
        static::$instance[ static::class ] = $instance;
    }

    /**
     * @return _Criteria
     */
    public static function getInstance() : _Criteria
    {
        return static::$instance[ static::class ] = null
            ?? static::$instance[ static::class ]
            ?? ( new SupportFactory() )->newCriteria();
    }


    /**
     * @var _Criteria[]
     */
    protected static $instance = [];
}
