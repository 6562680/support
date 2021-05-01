<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use ReflectionClass;
use Gzhegow\Support\Assert as _Assert;
use Gzhegow\Support\Domain\Type\CallableInfo;

class Assert
{
    /**
     * @return _Assert
     */
    public static function getInstance() : _Assert
    {
        return new _Assert();
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isEmpty($value) : bool
    {
        return static::getInstance()->isEmpty($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public static function isKey($value)
    {
        return static::getInstance()->isKey($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public static function isInt($value) : ?int
    {
        return static::getInstance()->isInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function isFloat($value) : ?float
    {
        return static::getInstance()->isFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function isNan($value) : ?float
    {
        return static::getInstance()->isNan($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public static function isNumber($value)
    {
        return static::getInstance()->isNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function isTheString($value) : ?string
    {
        return static::getInstance()->isTheString($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function isStringOrNumber($value)
    {
        return static::getInstance()->isStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function isTheStringOrNumber($value)
    {
        return static::getInstance()->isTheStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public static function isIntable($value) : ?int
    {
        return static::getInstance()->isIntable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function isFloatable($value) : ?float
    {
        return static::getInstance()->isFloatable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public static function isNumerable($value)
    {
        return static::getInstance()->isNumerable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function isStringable($value) : ?string
    {
        return static::getInstance()->isStringable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public static function isArrayable($value) : ?array
    {
        return static::getInstance()->isArrayable($value);
    }

    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function isArray($array, callable $of = null) : ?array
    {
        return static::getInstance()->isArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function isList($list, callable $of = null) : ?array
    {
        return static::getInstance()->isList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function isDict($dict, callable $of = null) : ?array
    {
        return static::getInstance()->isDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function isAssoc($assoc, callable $of = null) : ?array
    {
        return static::getInstance()->isAssoc($assoc, $of);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function isCallable($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->isCallable($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function isCallableString($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->isCallableString($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function isCallableArray($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->isCallableArray($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function isCallableArrayStatic($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->isCallableArrayStatic($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function isCallableArrayPublic($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->isCallableArrayPublic($callable, $callableInfo);
    }

    /**
     * @param mixed             $closure
     * @param null|CallableInfo $callableInfo
     *
     * @return null|\Closure
     */
    public static function isClosure($closure, CallableInfo &$callableInfo = null) : ?\Closure
    {
        return static::getInstance()->isClosure($closure, $callableInfo);
    }

    /**
     * @param mixed             $handler
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function isCallableHandler($handler, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->isCallableHandler($handler, $callableInfo);
    }

    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public static function isClass($class) : ?string
    {
        return static::getInstance()->isClass($class);
    }

    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public static function isValidClass($class) : ?string
    {
        return static::getInstance()->isValidClass($class);
    }

    /**
     * @param mixed $className
     *
     * @return null|string
     */
    public static function isValidClassName($className) : ?string
    {
        return static::getInstance()->isValidClassName($className);
    }

    /**
     * @param \ReflectionClass  $reflectionClass
     * @param string|null      &$class
     *
     * @return null|\ReflectionClass
     */
    public static function isReflectionClass($reflectionClass, string &$class = null) : ?ReflectionClass
    {
        return static::getInstance()->isReflectionClass($reflectionClass, $class);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function isFileInfo($value) : ?\SplFileInfo
    {
        return static::getInstance()->isFileInfo($value);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function isOpenedResource($h)
    {
        return static::getInstance()->isOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function isClosedResource($h)
    {
        return static::getInstance()->isClosedResource($h);
    }
}
