<?php

namespace Gzhegow\Support\Domain\Filter;


/**
 * CallableInfo
 */
class CallableInfo
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


    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'callable' => $this->callable,
            'class'    => $this->class,
            'closure'  => $this->closure,
            'function' => $this->function,
            'method'   => $this->method,
            'object'   => $this->object,
        ];
    }
}
