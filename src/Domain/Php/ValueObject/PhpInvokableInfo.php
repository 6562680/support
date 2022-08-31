<?php

namespace Gzhegow\Support\Domain\Php\ValueObject;


/**
 * PhpInvokableInfo
 */
class PhpInvokableInfo
{
    /**
     * @var callable
     */
    protected $callable;
    /**
     * @var string|class-string
     */
    protected $class;
    /**
     * @var \Closure
     */
    protected $closure;
    /**
     * @var string
     */
    protected $function;
    /**
     * @var string
     */
    protected $method;
    /**
     * @var object
     */
    protected $object;


    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * @return string|class-string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return \Closure
     */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }


    /**
     * @param callable $callable
     *
     * @return static
     */
    public function setCallable(callable $callable)
    {
        $this->callable = $callable;

        return $this;
    }

    /**
     * @param string|class-string $class
     *
     * @return static
     */
    public function setClass(string $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param \Closure $closure
     *
     * @return static
     */
    public function setClosure(\Closure $closure)
    {
        $this->closure = $closure;

        return $this;
    }

    /**
     * @param string $function
     *
     * @return static
     */
    public function setFunction(string $function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * @param string $method
     *
     * @return static
     */
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param object $object
     *
     * @return static
     */
    public function setObject(object $object)
    {
        $this->object = $object;

        return $this;
    }
}