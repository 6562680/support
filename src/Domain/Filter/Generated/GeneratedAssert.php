<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Domain\Filter\Generated;

use Gzhegow\Support\Domain\Filter\ValueObjects\InvokableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Filter;

/**
 * Gzhegow_Support_Generator_AssertBlueprint
 */
abstract class GeneratedAssert
{
    /** @var Filter */
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
     * @param string $customFilter
     * @param mixed  ...$arguments
     *
     * @return null|mixed
     */
    public function call(string $customFilter, ...$arguments)
    {
        if (\null === ( $filtered = $this->filter->call($customFilter, ...$arguments) )) {
            throw $this->throwableOr(
                new \InvalidArgumentException(
                    $this->messageOr('Invalid ' . $customFilter . ' passed: %s', ...$arguments)
                )
            );
        }

        return $filtered;
    }

    /**
     * @param string|array $text
     * @param mixed        ...$arguments
     *
     * @return null|string|array
     */
    abstract public function message($text, ...$arguments);

    /**
     * @param string|array $text
     * @param mixed        ...$arguments
     *
     * @return null|string|array
     */
    abstract public function messageOr($text, ...$arguments);

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    abstract public function throwable(\Throwable $throwable = null);

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    abstract public function throwableOr(\Throwable $throwable = null);

    /**
     * @param bool|mixed $value
     *
     * @return bool
     */
    public function assertBool($value): ?bool
    {
        if (null === ( $filtered = $this->filter->filterBool($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Bool passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    public function assertInt($value): ?int
    {
        if (null === ( $filtered = $this->filter->filterInt($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Int passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function assertFloat($value): ?float
    {
        if (null === ( $filtered = $this->filter->filterFloat($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Float passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param float|mixed $value
     *
     * @return float
     */
    public function assertNan($value): ?float
    {
        if (null === ( $filtered = $this->filter->filterNan($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Nan passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|mixed $value
     *
     * @return int|float
     */
    public function assertNum($value)
    {
        if (null === ( $filtered = $this->filter->filterNum($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Num passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertIntval($value): ?int
    {
        if (null === ( $filtered = $this->filter->filterIntval($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Intval passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param float|string|mixed $value
     *
     * @return float|string
     */
    public function assertFloatval($value): ?float
    {
        if (null === ( $filtered = $this->filter->filterFloatval($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Floatval passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertNumval($value)
    {
        if (null === ( $filtered = $this->filter->filterNumval($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Numval passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertNumericval($value)
    {
        if (null === ( $filtered = $this->filter->filterNumericval($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Numericval passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertString($value): ?string
    {
        if (null === ( $filtered = $this->filter->filterString($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid String passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertWord($value): ?string
    {
        if (null === ( $filtered = $this->filter->filterWord($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Word passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrInt($value)
    {
        if (null === ( $filtered = $this->filter->filterStringOrInt($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid StringOrInt passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrInt($value)
    {
        if (null === ( $filtered = $this->filter->filterWordOrInt($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid WordOrInt passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrNum($value)
    {
        if (null === ( $filtered = $this->filter->filterStringOrNum($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid StringOrNum passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param int|float|string|mixed $value
     *
     * @return int|float|string
     */
    public function assertWordOrNum($value)
    {
        if (null === ( $filtered = $this->filter->filterWordOrNum($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid WordOrNum passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertStrval($value): ?string
    {
        if (null === ( $filtered = $this->filter->filterStrval($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Strval passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertWordval($value): ?string
    {
        if (null === ( $filtered = $this->filter->filterWordval($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Wordval passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertTrimval($value): ?string
    {
        if (null === ( $filtered = $this->filter->filterTrimval($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Trimval passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * \Generator может передать любой объект в качестве ключа для foreach, пригодится
     *
     * @param int|string|mixed $value
     *
     * @return int|string
     */
    public function assertKey($value)
    {
        if (null === ( $filtered = $this->filter->filterKey($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Key passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed   $array
     * @param null|callable $of
     *
     * @return array
     */
    public function assertArray($array, callable $of = null): ?array
    {
        if (null === ( $filtered = $this->filter->filterArray($array,$of) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Array passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed   $list
     * @param null|callable $of
     *
     * @return array
     */
    public function assertList($list, callable $of = null): ?array
    {
        if (null === ( $filtered = $this->filter->filterList($list,$of) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid List passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed   $dict
     * @param null|callable $of
     *
     * @return array
     */
    public function assertDict($dict, callable $of = null): ?array
    {
        if (null === ( $filtered = $this->filter->filterDict($dict,$of) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Dict passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed   $assoc
     * @param null|callable $of
     *
     * @return array
     */
    public function assertAssoc($assoc, callable $of = null): ?array
    {
        if (null === ( $filtered = $this->filter->filterAssoc($assoc,$of) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Assoc passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed $array
     *
     * @return array
     */
    public function assertPlainArray($array): ?array
    {
        if (null === ( $filtered = $this->filter->filterPlainArray($array) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid PlainArray passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function assertArrval($value)
    {
        if (null === ( $filtered = $this->filter->filterArrval($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Arrval passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertLink($value): ?string
    {
        if (null === ( $filtered = $this->filter->filterLink($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Link passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $value
     *
     * @return string
     */
    public function assertUrl($value): ?string
    {
        if (null === ( $filtered = $this->filter->filterUrl($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Url passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|array|\Closure|callable|mixed $callable
     * @param null|InvokableInfo                   $invokableInfo
     *
     * @return string|array|\Closure|callable
     */
    public function assertCallable($callable, InvokableInfo &$invokableInfo = null)
    {
        if (null === ( $filtered = $this->filter->filterCallable($callable,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Callable passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|array|callable|mixed $callableString
     * @param null|InvokableInfo          $invokableInfo
     *
     * @return string|array|callable
     */
    public function assertCallableString($callableString, InvokableInfo &$invokableInfo = null)
    {
        if (null === ( $filtered = $this->filter->filterCallableString($callableString,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid CallableString passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringFunction($callableString, InvokableInfo &$invokableInfo = null): ?string
    {
        if (null === ( $filtered = $this->filter->filterCallableStringFunction($callableString,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid CallableStringFunction passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|callable|mixed $callableString
     * @param null|InvokableInfo    $invokableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringStatic($callableString, InvokableInfo &$invokableInfo = null): ?string
    {
        if (null === ( $filtered = $this->filter->filterCallableStringStatic($callableString,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid CallableStringStatic passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArray($callableArray, InvokableInfo &$invokableInfo = null): ?array
    {
        if (null === ( $filtered = $this->filter->filterCallableArray($callableArray,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid CallableArray passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayStatic($callableArray, InvokableInfo &$invokableInfo = null): ?array
    {
        if (null === ( $filtered = $this->filter->filterCallableArrayStatic($callableArray,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid CallableArrayStatic passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|callable|mixed $callableArray
     * @param null|InvokableInfo   $invokableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayPublic($callableArray, InvokableInfo &$invokableInfo = null): ?array
    {
        if (null === ( $filtered = $this->filter->filterCallableArrayPublic($callableArray,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid CallableArrayPublic passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \Closure|mixed     $closure
     * @param null|InvokableInfo $invokableInfo
     *
     * @return \Closure
     */
    public function assertClosure($closure, InvokableInfo &$invokableInfo = null): ?\Closure
    {
        if (null === ( $filtered = $this->filter->filterClosure($closure,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Closure passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed $methodArray
     *
     * @return array
     */
    public function assertMethodArray($methodArray): ?array
    {
        if (null === ( $filtered = $this->filter->filterMethodArray($methodArray) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid MethodArray passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param array|mixed        $methodArray
     * @param null|InvokableInfo $invokableInfo
     *
     * @return array
     */
    public function assertMethodArrayReflection($methodArray, InvokableInfo &$invokableInfo = null): ?array
    {
        if (null === ( $filtered = $this->filter->filterMethodArrayReflection($methodArray,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid MethodArrayReflection passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed       $handler
     * @param null|InvokableInfo $invokableInfo
     *
     * @return string|callable
     */
    public function assertHandler($handler, InvokableInfo &$invokableInfo = null): ?string
    {
        if (null === ( $filtered = $this->filter->filterHandler($handler,$invokableInfo) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Handler passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $class
     *
     * @return string
     */
    public function assertClass($class): ?string
    {
        if (null === ( $filtered = $this->filter->filterClass($class) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Class passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param string|mixed $className
     *
     * @return string
     */
    public function assertClassName($className): ?string
    {
        if (null === ( $filtered = $this->filter->filterClassName($className) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ClassName passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertThrowable($value)
    {
        if (null === ( $filtered = $this->filter->filterThrowable($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Throwable passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertException($value)
    {
        if (null === ( $filtered = $this->filter->filterException($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Exception passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertRuntimeException($value)
    {
        if (null === ( $filtered = $this->filter->filterRuntimeException($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid RuntimeException passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertLogicException($value)
    {
        if (null === ( $filtered = $this->filter->filterLogicException($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid LogicException passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param object|mixed $value
     *
     * @return object
     */
    public function assertStdClass($value)
    {
        if (null === ( $filtered = $this->filter->filterStdClass($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid StdClass passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \SplFileInfo|mixed $value
     *
     * @return \SplFileInfo
     */
    public function assertFileInfo($value): ?\SplFileInfo
    {
        if (null === ( $filtered = $this->filter->filterFileInfo($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid FileInfo passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \SplFileObject|mixed $value
     *
     * @return \SplFileObject
     */
    public function assertFileObject($value): ?\SplFileObject
    {
        if (null === ( $filtered = $this->filter->filterFileObject($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid FileObject passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionClass|mixed $value
     *
     * @return \ReflectionClass
     */
    public function assertReflectionClass($value): ?\ReflectionClass
    {
        if (null === ( $filtered = $this->filter->filterReflectionClass($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ReflectionClass passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionFunction|mixed $value
     *
     * @return \ReflectionFunction
     */
    public function assertReflectionFunction($value): ?\ReflectionFunction
    {
        if (null === ( $filtered = $this->filter->filterReflectionFunction($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ReflectionFunction passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionMethod|mixed $value
     *
     * @return \ReflectionMethod
     */
    public function assertReflectionMethod($value): ?\ReflectionMethod
    {
        if (null === ( $filtered = $this->filter->filterReflectionMethod($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ReflectionMethod passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionProperty|mixed $value
     *
     * @return \ReflectionProperty
     */
    public function assertReflectionProperty($value): ?\ReflectionProperty
    {
        if (null === ( $filtered = $this->filter->filterReflectionProperty($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ReflectionProperty passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionParameter|mixed $value
     *
     * @return \ReflectionParameter
     */
    public function assertReflectionParameter($value): ?\ReflectionParameter
    {
        if (null === ( $filtered = $this->filter->filterReflectionParameter($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ReflectionParameter passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param \ReflectionType|mixed $value
     *
     * @return \ReflectionType
     */
    public function assertReflectionType($value): ?\ReflectionType
    {
        if (null === ( $filtered = $this->filter->filterReflectionType($value) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ReflectionType passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertResource($h)
    {
        if (null === ( $filtered = $this->filter->filterResource($h) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid Resource passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertOpenedResource($h)
    {
        if (null === ( $filtered = $this->filter->filterOpenedResource($h) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid OpenedResource passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertClosedResource($h)
    {
        if (null === ( $filtered = $this->filter->filterClosedResource($h) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ClosedResource passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertReadableResource($h)
    {
        if (null === ( $filtered = $this->filter->filterReadableResource($h) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid ReadableResource passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }

    /**
     * @param resource|mixed $h
     *
     * @return resource
     */
    public function assertWritableResource($h)
    {
        if (null === ( $filtered = $this->filter->filterWritableResource($h) )) {
            throw $this->throwableOr(
                new InvalidArgumentException($this->messageOr(
                    [ 'Invalid WritableResource passed: %s', func_get_args() ]
                ))
            );
        }

        return $filtered;
    }
}
