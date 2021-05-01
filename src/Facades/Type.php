<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Type as _Type;
use Gzhegow\Support\Domain\Type\Assert;

class Type
{
    /**
     * @return _Type
     */
    public static function getInstance() : _Type
    {
        return new _Type(
            new Assert()
        );
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
     * @return bool
     */
    public static function isKey($value) : bool
    {
        return static::getInstance()->isKey($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isInt($value) : bool
    {
        return static::getInstance()->isInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFloat($value) : bool
    {
        return static::getInstance()->isFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isNan($value) : bool
    {
        return static::getInstance()->isNan($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isNumber($value) : bool
    {
        return static::getInstance()->isNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isTheString($value) : bool
    {
        return static::getInstance()->isTheString($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isStringOrNumber($value) : bool
    {
        return static::getInstance()->isStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isTheStringOrNumber($value) : bool
    {
        return static::getInstance()->isTheStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isNumerable($value) : bool
    {
        return static::getInstance()->isNumerable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isStringable($value) : bool
    {
        return static::getInstance()->isStringable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isArrayable($value) : bool
    {
        return static::getInstance()->isArrayable($value);
    }

    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isArray($array, callable $of = null) : bool
    {
        return static::getInstance()->isArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isList($list, callable $of = null) : bool
    {
        return static::getInstance()->isList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isDict($dict, callable $of = null) : bool
    {
        return static::getInstance()->isDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public static function isAssoc($assoc, callable $of = null) : bool
    {
        return static::getInstance()->isAssoc($assoc, $of);
    }

    /**
     * @param mixed $callable
     *
     * @return bool
     */
    public static function isCallable($callable) : bool
    {
        return static::getInstance()->isCallable($callable);
    }

    /**
     * @param $callable
     *
     * @return bool
     */
    public static function isCallableString($callable) : bool
    {
        return static::getInstance()->isCallableString($callable);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isClosure($value) : bool
    {
        return static::getInstance()->isClosure($value);
    }

    /**
     * @param mixed $callable
     *
     * @return bool
     */
    public static function isCallableArray($callable) : bool
    {
        return static::getInstance()->isCallableArray($callable);
    }

    /**
     * @param mixed $callable
     *
     * @return bool
     */
    public static function isCallableArrayStatic($callable) : bool
    {
        return static::getInstance()->isCallableArrayStatic($callable);
    }

    /**
     * @param mixed $callable
     *
     * @return bool
     */
    public static function isCallableArrayPublic($callable) : bool
    {
        return static::getInstance()->isCallableArrayPublic($callable);
    }

    /**
     * @param mixed $handler
     *
     * @return bool
     */
    public static function isCallableHandler($handler) : bool
    {
        return static::getInstance()->isCallableHandler($handler);
    }

    /**
     * @param mixed $class
     *
     * @return bool
     */
    public static function isClass($class) : bool
    {
        return static::getInstance()->isClass($class);
    }

    /**
     * @param mixed $namespacedClass
     *
     * @return bool
     */
    public static function isValidClass($namespacedClass) : bool
    {
        return static::getInstance()->isValidClass($namespacedClass);
    }

    /**
     * @param mixed $className
     *
     * @return bool
     */
    public static function isValidClassName($className) : bool
    {
        return static::getInstance()->isValidClassName($className);
    }

    /**
     * @param mixed $obj
     *
     * @return bool
     */
    public static function isReflectionClass($obj) : bool
    {
        return static::getInstance()->isReflectionClass($obj);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFileInfo($value) : bool
    {
        return static::getInstance()->isFileInfo($value);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public static function isOpenedResource($h) : bool
    {
        return static::getInstance()->isOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public static function isClosedResource($h) : bool
    {
        return static::getInstance()->isClosedResource($h);
    }
}
