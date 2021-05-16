<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades\Generated;

use Gzhegow\Support\Type as _Type;
use Gzhegow\Support\Domain\Type\CallableInfo;

abstract class Type
{
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
    public static function isIntable($value) : bool
    {
        return static::getInstance()->isIntable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFloatable($value) : bool
    {
        return static::getInstance()->isFloatable($value);
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
    public static function isTheStringable($value) : bool
    {
        return static::getInstance()->isTheStringable($value);
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
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallable($callable, CallableInfo &$callableInfo = null) : bool
    {
        return static::getInstance()->isCallable($callable, $callableInfo);
    }

    /**
     * @param                   $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableString($callable, CallableInfo &$callableInfo = null) : bool
    {
        return static::getInstance()->isCallableString($callable, $callableInfo);
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableStringStatic($callableString, CallableInfo &$callableInfo = null) : bool
    {
        return static::getInstance()->isCallableStringStatic($callableString, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableArray($callable, CallableInfo &$callableInfo = null) : bool
    {
        return static::getInstance()->isCallableArray($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableArrayStatic($callable, CallableInfo &$callableInfo = null) : bool
    {
        return static::getInstance()->isCallableArrayStatic($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isCallableArrayPublic($callable, CallableInfo &$callableInfo = null) : bool
    {
        return static::getInstance()->isCallableArrayPublic($callable, $callableInfo);
    }

    /**
     * @param mixed             $value
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public static function isClosure($value, CallableInfo &$callableInfo = null) : bool
    {
        return static::getInstance()->isClosure($value, $callableInfo);
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
     * @param mixed $value
     *
     * @return bool
     */
    public static function isLink($value) : bool
    {
        return static::getInstance()->isLink($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function isUrl($value) : bool
    {
        return static::getInstance()->isUrl($value);
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


    /**
     * @return _Type
     */
    abstract public static function getInstance() : _Type;
}
