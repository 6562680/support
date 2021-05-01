<?php

namespace Gzhegow\Support;


use Gzhegow\Support\Domain\Type\Assert;

/**
 * Filter
 */
class Filter
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
     * @return null|int|float|string|array
     */
    public function filterEmpty($value) // :?null|int|float|string|array
    {
        return ( false !== $this->assert->isEmpty($value) )
            ? $value
            : null;
    }


    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public function filterKey($value) // : ?int|string
    {
        return $this->assert->isKey($value);
    }


    /**
     * @param mixed $value
     *
     * @return null|int
     */
    public function filterInt($value) : ?int
    {
        return $this->assert->isInt($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function filterFloat($value) : ?float
    {
        return $this->assert->isFloat($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|float
     */
    public function filterNan($value) : ?float
    {
        return $this->assert->isNan($value);
    }


    /**
     * @param mixed $value
     *
     * @return null|int|string
     */
    public function filterNumber($value) // : ?null|int|float
    {
        return $this->assert->isNumber($value);
    }


    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterTheString($value) : ?string
    {
        return $this->assert->isTheString($value);
    }


    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public function filterStringOrNumber($value) // : ?null|int|float|string
    {
        return $this->assert->isStringOrNumber($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|int|float|string
     */
    public function filterTheStringOrNumber($value) // : ?null|int|float|string
    {
        return $this->assert->isTheStringOrNumber($value);
    }


    /**
     * @param mixed $value
     *
     * @return null|int|float
     */
    public function filterNumerable($value) // : ?int|float
    {
        return $this->assert->isNumerable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|string
     */
    public function filterStringable($value) : ?string
    {
        return $this->assert->isStringable($value);
    }

    /**
     * @param mixed $value
     *
     * @return null|array
     */
    public function filterArrayable($value) : ?array
    {
        return $this->assert->isArrayable($value);
    }


    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterArray($array, callable $of = null) : ?array
    {
        return $this->assert->isArray($array, $of);
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterList($list, callable $of = null) : ?array
    {
        return $this->assert->isList($list, $of);
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterDict($dict, callable $of = null) : ?array
    {
        return $this->assert->isDict($dict, $of);
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return null|array
     */
    public function filterAssoc($assoc, callable $of = null) : ?array
    {
        return $this->assert->isAssoc($assoc, $of);
    }


    /**
     * @param mixed $callable
     *
     * @return null|callable
     */
    public function filterCallable($callable) // : ?callable
    {
        return $this->assert->isCallable($callable);
    }

    /**
     * @param $callable
     *
     * @return null|callable
     */
    public function filterCallableString($callable) // : ?callable
    {
        return $this->assert->isCallableString($callable);
    }


    /**
     * @param mixed $value
     *
     * @return null|\Closure
     */
    public function filterClosure($value) : ?\Closure
    {
        return $this->assert->isClosure($value);
    }


    /**
     * @param mixed $callable
     *
     * @return null|callable
     */
    public function filterCallableArray($callable) // : ?callable
    {
        return $this->assert->isCallableArray($callable);
    }

    /**
     * @param mixed $callable
     *
     * @return null|callable
     */
    public function filterCallableArrayStatic($callable) // : ?callable
    {
        return $this->assert->isCallableArrayStatic($callable);
    }

    /**
     * @param mixed $callable
     *
     * @return null|callable
     */
    public function filterCallableArrayPublic($callable) // : ?callable
    {
        return $this->assert->isCallableArrayStatic($callable);
    }


    /**
     * @param mixed $handler
     *
     * @return null|callable
     */
    public function filterCallableHandler($handler) // : ?callable
    {
        return $this->assert->isCallableHandler($handler);
    }


    /**
     * @param mixed $class
     *
     * @return null|string
     */
    public function filterClass($class) : ?string
    {
        return $this->assert->isClass($class);
    }


    /**
     * @param mixed $namespacedClass
     *
     * @return null|string
     */
    public function filterValidClass($namespacedClass) : ?string
    {
        return $this->assert->isValidClass($namespacedClass);
    }

    /**
     * @param mixed $className
     *
     * @return null|string
     */
    public function filterValidClassName($className) : ?string
    {
        return $this->assert->isValidClassName($className);
    }


    /**
     * @param mixed $obj
     *
     * @return null|\ReflectionClass
     */
    public function filterReflectionClass($obj) : ?\ReflectionClass
    {
        return $this->assert->isReflectionClass($obj);
    }


    /**
     * @param mixed $value
     *
     * @return null|\SplFileInfo
     */
    public function filterFileInfo($value) : ?\SplFileInfo
    {
        return $this->assert->isFileInfo($value);
    }


    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public function filterOpenedResource($h) // : ?resource
    {
        return $this->assert->isOpenedResource($h);
    }

    /**
     * @param mixed $h
     *
     * @return null|resource
     */
    public function filterClosedResource($h) // : ?resource
    {
        return $this->assert->isClosedResource($h);
    }
}
