<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Assert;
use Gzhegow\Support\Domain\Type\CallableInfo;


/**
 * Type
 */
class Type
{
    /**
     * @var Assert
     */
    protected $assert;


    /**
     * Constructor
     *
     * @param Assert $assert
     */
    public function __construct(Assert $assert)
    {
        $this->assert = $assert;
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isEmpty($value) : bool
    {
        return false !== $this->assert->isEmpty($value)
            ? $value
            : false;
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isKey($value) : bool
    {
        return null !== $this->assert->isKey($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isInt($value) : bool
    {
        return null !== $this->assert->isInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFloat($value) : bool
    {
        return null !== $this->assert->isFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNan($value) : bool
    {
        return null !== $this->assert->isNan($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNumber($value) : bool
    {
        return null !== $this->assert->isNumber($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isTheString($value) : bool
    {
        return null !== $this->assert->isTheString($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isStringOrNumber($value) : bool
    {
        return null !== $this->assert->isStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isTheStringOrNumber($value) : bool
    {
        return null !== $this->assert->isTheStringOrNumber($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNumerable($value) : bool
    {
        return null !== $this->assert->isNumerable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isStringable($value) : bool
    {
        return null !== $this->assert->isStringable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isArrayable($value) : bool
    {
        return null !== $this->assert->isArrayable($value);
    }


    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return bool
     */
    public function isArray($array, callable $of = null) : bool
    {
        return null !== $this->assert->isArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return bool
     */
    public function isList($list, callable $of = null) : bool
    {
        return null !== $this->assert->isList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public function isDict($dict, callable $of = null) : bool
    {
        return null !== $this->assert->isDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public function isAssoc($assoc, callable $of = null) : bool
    {
        return null !== $this->assert->isAssoc($assoc, $of);
    }


    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallable($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->assert->isCallable($callable, $callableInfo);
    }

    /**
     * @param                   $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableString($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->assert->isCallableString($callable, $callableInfo);
    }


    /**
     * @param mixed             $value
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isClosure($value, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->assert->isClosure($value, $callableInfo);
    }


    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableArray($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->assert->isCallableArray($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableArrayStatic($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->assert->isCallableArrayStatic($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableArrayPublic($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->assert->isCallableArrayStatic($callable, $callableInfo);
    }


    /**
     * @param mixed             $handler
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableHandler($handler, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->assert->isCallableHandler($handler, $callableInfo);
    }


    /**
     * @param mixed $class
     *
     * @return bool
     */
    public function isClass($class) : bool
    {
        return null !== $this->assert->isClass($class);
    }


    /**
     * @param mixed $namespacedClass
     *
     * @return bool
     */
    public function isValidClass($namespacedClass) : bool
    {
        return null !== $this->assert->isValidClass($namespacedClass);
    }

    /**
     * @param mixed $className
     *
     * @return bool
     */
    public function isValidClassName($className) : bool
    {
        return null !== $this->assert->isValidClassName($className);
    }


    /**
     * @param mixed $obj
     *
     * @return bool
     */
    public function isReflectionClass($obj) : bool
    {
        return null !== $this->assert->isReflectionClass($obj);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFileInfo($value) : bool
    {
        return null !== $this->assert->isFileInfo($value);
    }


    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isOpenedResource($h) : bool
    {
        return null !== $this->assert->isOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isClosedResource($h) : bool
    {
        return null !== $this->assert->isClosedResource($h);
    }
}
