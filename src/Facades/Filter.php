<?php

/**
 * This file is auto-generated.
 *
 * * @noinspection PhpUnhandledExceptionInspection
 * * @noinspection PhpDocMissingThrowsInspection
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Filter as _Filter;
use Gzhegow\Support\Domain\Type\CallableInfo;

class Filter
{
    /**
     * @return _Filter
     */
    public static function getInstance() : _Filter
    {
        return new _Filter();
    }


    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public static function filterKey($value)
    {
        return static::getInstance()->filterKey($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public static function filterInt($value) : ?int
    {
        return static::getInstance()->filterInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function filterFloat($value) : ?float
    {
        return static::getInstance()->filterFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public static function filterNan($value) : ?float
    {
        return static::getInstance()->filterNan($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public static function filterNumber($value)
    {
        return static::getInstance()->filterNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function filterTheString($value) : ?string
    {
        return static::getInstance()->filterTheString($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterStringOrNumber($value)
    {
        return static::getInstance()->filterStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public static function filterTheStringOrNumber($value)
    {
        return static::getInstance()->filterTheStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function filterIntable($value) : ?int
    {
        return static::getInstance()->filterIntable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function filterFloatable($value) : ?float
    {
        return static::getInstance()->filterFloatable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public static function filterNumerable($value)
    {
        return static::getInstance()->filterNumerable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public static function filterStringable($value) : ?string
    {
        return static::getInstance()->filterStringable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public static function filterArrayable($value) : ?array
    {
        return static::getInstance()->filterArrayable($value);
    }

    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterArray($array, callable $of = null) : ?array
    {
        return static::getInstance()->filterArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterList($list, callable $of = null) : ?array
    {
        return static::getInstance()->filterList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterDict($dict, callable $of = null) : ?array
    {
        return static::getInstance()->filterDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public static function filterAssoc($assoc, callable $of = null) : ?array
    {
        return static::getInstance()->filterAssoc($assoc, $of);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function filterCallable($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->filterCallable($callable, $callableInfo);
    }

    /**
     * @param                   $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function filterCallableString($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->filterCallableString($callable, $callableInfo);
    }

    /**
     * @param mixed             $value
     * @param null|CallableInfo $callableInfo
     *
     * @return null|\Closure
     */
    public static function filterClosure($value, CallableInfo &$callableInfo = null) : ?\Closure
    {
        return static::getInstance()->filterClosure($value, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function filterCallableArray($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->filterCallableArray($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function filterCallableArrayStatic($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->filterCallableArrayStatic($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function filterCallableArrayPublic($callable, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->filterCallableArrayPublic($callable, $callableInfo);
    }

    /**
     * @param mixed             $handler
     * @param null|CallableInfo $callableInfo
     *
     * @return null|callable
     */
    public static function filterCallableHandler($handler, CallableInfo &$callableInfo = null)
    {
        return static::getInstance()->filterCallableHandler($handler, $callableInfo);
    }

    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public static function filterClass($class) : ?string
    {
        return static::getInstance()->filterClass($class);
    }

    /**
     * @param mixed $namespacedClass
     *
     * @return null|string
     */
    public static function filterValidClass($namespacedClass) : ?string
    {
        return static::getInstance()->filterValidClass($namespacedClass);
    }

    /**
     * @param mixed $className
     *
     * @return null|string
     */
    public static function filterValidClassName($className) : ?string
    {
        return static::getInstance()->filterValidClassName($className);
    }

    /**
     * @param mixed $obj
     *
     * @return null|\ReflectionClass
     */
    public static function filterReflectionClass($obj) : ?\ReflectionClass
    {
        return static::getInstance()->filterReflectionClass($obj);
    }

    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public static function filterFileInfo($value) : ?\SplFileInfo
    {
        return static::getInstance()->filterFileInfo($value);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function filterOpenedResource($h)
    {
        return static::getInstance()->filterOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public static function filterClosedResource($h)
    {
        return static::getInstance()->filterClosedResource($h);
    }
}
