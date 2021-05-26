<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support\Generated;

use Gzhegow\Support\Domain\Filter\CallableInfo;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Filter;

abstract class GeneratedAssert
{
    /**
     * @var Filter
     */
    public $filter;

    /**
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param string $customFilter
     * @param mixed ...$arguments
     *
     * @return null|mixed
     */
    public function call(string $customFilter, ...$arguments)
    {
        if (null === ($filtered = $this->filter->call($customFilter, ...$arguments))) {
            throw new InvalidArgumentException('Invalid ' . $customFilter . ' passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return int|string
     */
    public function assertKey($value)
    {
        if (null === ($filtered = $this->filter->filterKey($value))) {
            throw new InvalidArgumentException('Invalid Key passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    public function assertInt($value): ?int
    {
        if (null === ($filtered = $this->filter->filterInt($value))) {
            throw new InvalidArgumentException('Invalid Int passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public function assertFloat($value): ?float
    {
        if (null === ($filtered = $this->filter->filterFloat($value))) {
            throw new InvalidArgumentException('Invalid Float passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public function assertNan($value): ?float
    {
        if (null === ($filtered = $this->filter->filterNan($value))) {
            throw new InvalidArgumentException('Invalid Nan passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return int|string
     */
    public function assertNumber($value)
    {
        if (null === ($filtered = $this->filter->filterNumber($value))) {
            throw new InvalidArgumentException('Invalid Number passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function assertTheString($value): ?string
    {
        if (null === ($filtered = $this->filter->filterTheString($value))) {
            throw new InvalidArgumentException('Invalid TheString passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return int|float|string
     */
    public function assertStringOrNumber($value)
    {
        if (null === ($filtered = $this->filter->filterStringOrNumber($value))) {
            throw new InvalidArgumentException('Invalid StringOrNumber passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return int|float|string
     */
    public function assertTheStringOrNumber($value)
    {
        if (null === ($filtered = $this->filter->filterTheStringOrNumber($value))) {
            throw new InvalidArgumentException('Invalid TheStringOrNumber passed');
        }

        return $filtered;
    }

    /**
     * @param mixed         $array
     * @param null|callable $of
     *
     * @return array
     */
    public function assertArray($array, callable $of = null): ?array
    {
        if (null === ($filtered = $this->filter->filterArray($array, $of))) {
            throw new InvalidArgumentException('Invalid Array passed');
        }

        return $filtered;
    }

    /**
     * @param mixed         $list
     * @param null|callable $of
     *
     * @return array
     */
    public function assertList($list, callable $of = null): ?array
    {
        if (null === ($filtered = $this->filter->filterList($list, $of))) {
            throw new InvalidArgumentException('Invalid List passed');
        }

        return $filtered;
    }

    /**
     * @param mixed         $dict
     * @param null|callable $of
     *
     * @return array
     */
    public function assertDict($dict, callable $of = null): ?array
    {
        if (null === ($filtered = $this->filter->filterDict($dict, $of))) {
            throw new InvalidArgumentException('Invalid Dict passed');
        }

        return $filtered;
    }

    /**
     * @param mixed         $assoc
     * @param null|callable $of
     *
     * @return array
     */
    public function assertAssoc($assoc, callable $of = null): ?array
    {
        if (null === ($filtered = $this->filter->filterAssoc($assoc, $of))) {
            throw new InvalidArgumentException('Invalid Assoc passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $array
     *
     * @return array
     */
    public function assertPlainArray($array): ?array
    {
        if (null === ($filtered = $this->filter->filterPlainArray($array))) {
            throw new InvalidArgumentException('Invalid PlainArray passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function assertLink($value): ?string
    {
        if (null === ($filtered = $this->filter->filterLink($value))) {
            throw new InvalidArgumentException('Invalid Link passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function assertUrl($value): ?string
    {
        if (null === ($filtered = $this->filter->filterUrl($value))) {
            throw new InvalidArgumentException('Invalid Url passed');
        }

        return $filtered;
    }

    /**
     * @param mixed             $callable
     * @param null|CallableInfo $callableInfo
     *
     * @return string|array|\Closure|callable
     */
    public function assertCallable($callable, CallableInfo &$callableInfo = null)
    {
        if (null === ($filtered = $this->filter->filterCallable($callable, $callableInfo))) {
            throw new InvalidArgumentException('Invalid Callable passed');
        }

        return $filtered;
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return string|array|callable
     */
    public function assertCallableString($callableString, CallableInfo &$callableInfo = null)
    {
        if (null === ($filtered = $this->filter->filterCallableString($callableString, $callableInfo))) {
            throw new InvalidArgumentException('Invalid CallableString passed');
        }

        return $filtered;
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringFunction($callableString, CallableInfo &$callableInfo = null): ?string
    {
        if (null === ($filtered = $this->filter->filterCallableStringFunction($callableString, $callableInfo))) {
            throw new InvalidArgumentException('Invalid CallableStringFunction passed');
        }

        return $filtered;
    }

    /**
     * @param mixed             $callableString
     * @param null|CallableInfo $callableInfo
     *
     * @return string|callable
     */
    public function assertCallableStringStatic($callableString, CallableInfo &$callableInfo = null): ?string
    {
        if (null === ($filtered = $this->filter->filterCallableStringStatic($callableString, $callableInfo))) {
            throw new InvalidArgumentException('Invalid CallableStringStatic passed');
        }

        return $filtered;
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return array|callable
     */
    public function assertCallableArray($callableArray, CallableInfo &$callableInfo = null): ?array
    {
        if (null === ($filtered = $this->filter->filterCallableArray($callableArray, $callableInfo))) {
            throw new InvalidArgumentException('Invalid CallableArray passed');
        }

        return $filtered;
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayStatic($callableArray, CallableInfo &$callableInfo = null): ?array
    {
        if (null === ($filtered = $this->filter->filterCallableArrayStatic($callableArray, $callableInfo))) {
            throw new InvalidArgumentException('Invalid CallableArrayStatic passed');
        }

        return $filtered;
    }

    /**
     * @param mixed             $callableArray
     * @param null|CallableInfo $callableInfo
     *
     * @return array|callable
     */
    public function assertCallableArrayPublic($callableArray, CallableInfo &$callableInfo = null): ?array
    {
        if (null === ($filtered = $this->filter->filterCallableArrayPublic($callableArray, $callableInfo))) {
            throw new InvalidArgumentException('Invalid CallableArrayPublic passed');
        }

        return $filtered;
    }

    /**
     * @param mixed             $closure
     * @param null|CallableInfo $callableInfo
     *
     * @return \Closure
     */
    public function assertClosure($closure, CallableInfo &$callableInfo = null): ?\Closure
    {
        if (null === ($filtered = $this->filter->filterClosure($closure, $callableInfo))) {
            throw new InvalidArgumentException('Invalid Closure passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $class
     *
     * @return string
     */
    public function assertClass($class): ?string
    {
        if (null === ($filtered = $this->filter->filterClass($class))) {
            throw new InvalidArgumentException('Invalid Class passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $className
     *
     * @return string
     */
    public function assertClassName($className): ?string
    {
        if (null === ($filtered = $this->filter->filterClassName($className))) {
            throw new InvalidArgumentException('Invalid ClassName passed');
        }

        return $filtered;
    }

    /**
     * @param object $value
     *
     * @return object
     */
    public function assertStdClass($value)
    {
        if (null === ($filtered = $this->filter->filterStdClass($value))) {
            throw new InvalidArgumentException('Invalid StdClass passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return \SplFileInfo
     */
    public function assertFileInfo($value): ?\SplFileInfo
    {
        if (null === ($filtered = $this->filter->filterFileInfo($value))) {
            throw new InvalidArgumentException('Invalid FileInfo passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return \SplFileObject
     */
    public function assertFileObject($value): ?\SplFileObject
    {
        if (null === ($filtered = $this->filter->filterFileObject($value))) {
            throw new InvalidArgumentException('Invalid FileObject passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionClass
     */
    public function assertReflectionClass($value): ?\ReflectionClass
    {
        if (null === ($filtered = $this->filter->filterReflectionClass($value))) {
            throw new InvalidArgumentException('Invalid ReflectionClass passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionFunction
     */
    public function assertReflectionFunction($value): ?\ReflectionFunction
    {
        if (null === ($filtered = $this->filter->filterReflectionFunction($value))) {
            throw new InvalidArgumentException('Invalid ReflectionFunction passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionMethod
     */
    public function assertReflectionMethod($value): ?\ReflectionMethod
    {
        if (null === ($filtered = $this->filter->filterReflectionMethod($value))) {
            throw new InvalidArgumentException('Invalid ReflectionMethod passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionProperty
     */
    public function assertReflectionProperty($value): ?\ReflectionProperty
    {
        if (null === ($filtered = $this->filter->filterReflectionProperty($value))) {
            throw new InvalidArgumentException('Invalid ReflectionProperty passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionParameter
     */
    public function assertReflectionParameter($value): ?\ReflectionParameter
    {
        if (null === ($filtered = $this->filter->filterReflectionParameter($value))) {
            throw new InvalidArgumentException('Invalid ReflectionParameter passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return \ReflectionType
     */
    public function assertReflectionType($value): ?\ReflectionType
    {
        if (null === ($filtered = $this->filter->filterReflectionType($value))) {
            throw new InvalidArgumentException('Invalid ReflectionType passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public function assertResource($h)
    {
        if (null === ($filtered = $this->filter->filterResource($h))) {
            throw new InvalidArgumentException('Invalid Resource passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public function assertOpenedResource($h)
    {
        if (null === ($filtered = $this->filter->filterOpenedResource($h))) {
            throw new InvalidArgumentException('Invalid OpenedResource passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public function assertClosedResource($h)
    {
        if (null === ($filtered = $this->filter->filterClosedResource($h))) {
            throw new InvalidArgumentException('Invalid ClosedResource passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public function assertReadableResource($h)
    {
        if (null === ($filtered = $this->filter->filterReadableResource($h))) {
            throw new InvalidArgumentException('Invalid ReadableResource passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $h
     *
     * @return resource
     */
    public function assertWritableResource($h)
    {
        if (null === ($filtered = $this->filter->filterWritableResource($h))) {
            throw new InvalidArgumentException('Invalid WritableResource passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    public function assertIntval($value): ?int
    {
        if (null === ($filtered = $this->filter->filterIntval($value))) {
            throw new InvalidArgumentException('Invalid Intval passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public function assertFloatval($value): ?float
    {
        if (null === ($filtered = $this->filter->filterFloatval($value))) {
            throw new InvalidArgumentException('Invalid Floatval passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return int|float
     */
    public function assertNumval($value)
    {
        if (null === ($filtered = $this->filter->filterNumval($value))) {
            throw new InvalidArgumentException('Invalid Numval passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function assertStrval($value): ?string
    {
        if (null === ($filtered = $this->filter->filterStrval($value))) {
            throw new InvalidArgumentException('Invalid Strval passed');
        }

        return $filtered;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function assertTheStrval($value): ?string
    {
        if (null === ($filtered = $this->filter->filterTheStrval($value))) {
            throw new InvalidArgumentException('Invalid TheStrval passed');
        }

        return $filtered;
    }
}
