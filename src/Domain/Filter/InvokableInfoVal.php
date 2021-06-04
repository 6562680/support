<?php

namespace Gzhegow\Support\Domain\Filter;


/**
 * InvokableInfoVal
 */
class InvokableInfoVal
{
    /**
     * @var callable
     */
    public $callable;
    /**
     * @var string
     */
    public $class;
    /**
     * @var \Closure
     */
    public $closure;
    /**
     * @var string
     */
    public $function;
    /**
     * @var string
     */
    public $method;
    /**
     * @var object
     */
    public $object;
}
