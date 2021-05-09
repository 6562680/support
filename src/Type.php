<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Type\CallableInfo;


/**
 * Type
 *
 * Module just wraps Filter
 * Module is required to work with array_filter function (that prefers correct boolean to filter values)
 * Also module makes easier to use filters by way of ommiting null-coalesce check everywhere
 *
 * It contains only one different method - `isEmpty`, because 'null' is empty too
 */
class Type
{
    /**
     * @var Filter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isEmpty($value) : bool
    {
        if (empty($value)) {
            return true;
        }

        if (is_object($value) && is_countable($value)) {
            return ! count($value);
        }

        return false;
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isKey($value) : bool
    {
        return null !== $this->filter->filterKey($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isInt($value) : bool
    {
        return null !== $this->filter->filterInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFloat($value) : bool
    {
        return null !== $this->filter->filterFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNan($value) : bool
    {
        return null !== $this->filter->filterNan($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNumber($value) : bool
    {
        return null !== $this->filter->filterNumber($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isTheString($value) : bool
    {
        return null !== $this->filter->filterTheString($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isStringOrNumber($value) : bool
    {
        return null !== $this->filter->filterStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isTheStringOrNumber($value) : bool
    {
        return null !== $this->filter->filterTheStringOrNumber($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isIntable($value) : bool
    {
        return null !== $this->filter->filterIntable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFloatable($value) : bool
    {
        return null !== $this->filter->filterFloatable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isNumerable($value) : bool
    {
        return null !== $this->filter->filterNumerable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isStringable($value) : bool
    {
        return null !== $this->filter->filterStringable($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isArrayable($value) : bool
    {
        return null !== $this->filter->filterArrayable($value);
    }


    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return bool
     */
    public function isArray($array, callable $of = null) : bool
    {
        return null !== $this->filter->filterArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return bool
     */
    public function isList($list, callable $of = null) : bool
    {
        return null !== $this->filter->filterList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return bool
     */
    public function isDict($dict, callable $of = null) : bool
    {
        return null !== $this->filter->filterDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return bool
     */
    public function isAssoc($assoc, callable $of = null) : bool
    {
        return null !== $this->filter->filterAssoc($assoc, $of);
    }


    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallable($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->filter->filterCallable($callable, $callableInfo);
    }

    /**
     * @param                   $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableString($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->filter->filterCallableString($callable, $callableInfo);
    }


    /**
     * @param mixed             $value
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isClosure($value, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->filter->filterClosure($value, $callableInfo);
    }


    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableArray($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->filter->filterCallableArray($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableArrayStatic($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->filter->filterCallableArrayStatic($callable, $callableInfo);
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableArrayPublic($callable, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->filter->filterCallableArrayStatic($callable, $callableInfo);
    }


    /**
     * @param mixed             $handler
     * @param null|CallableInfo $callableInfo
     *
     * @return bool
     */
    public function isCallableHandler($handler, CallableInfo &$callableInfo = null) : bool
    {
        return null !== $this->filter->filterCallableHandler($handler, $callableInfo);
    }


    /**
     * @param mixed $class
     *
     * @return bool
     */
    public function isClass($class) : bool
    {
        return null !== $this->filter->filterClass($class);
    }


    /**
     * @param mixed $namespacedClass
     *
     * @return bool
     */
    public function isValidClass($namespacedClass) : bool
    {
        return null !== $this->filter->filterValidClass($namespacedClass);
    }

    /**
     * @param mixed $className
     *
     * @return bool
     */
    public function isValidClassName($className) : bool
    {
        return null !== $this->filter->filterValidClassName($className);
    }


    /**
     * @param mixed $obj
     *
     * @return bool
     */
    public function isReflectionClass($obj) : bool
    {
        return null !== $this->filter->filterReflectionClass($obj);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isLink($value) : bool
    {
        return null !== $this->filter->filterLink($value);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isUrl($value) : bool
    {
        return null !== $this->filter->filterUrl($value);
    }


    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isFileInfo($value) : bool
    {
        return null !== $this->filter->filterFileInfo($value);
    }


    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isOpenedResource($h) : bool
    {
        return null !== $this->filter->filterOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return bool
     */
    public function isClosedResource($h) : bool
    {
        return null !== $this->filter->filterClosedResource($h);
    }
}
