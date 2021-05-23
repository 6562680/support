<?php

namespace Gzhegow\Support;


use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Func
 */
class Func
{
    /**
     * @param callable $callable
     *
     * @return \ReflectionFunction
     */
    protected function newReflectionFunction($callable) : \ReflectionFunction
    {
        try {
            $rf = new \ReflectionFunction($callable);
        }
        catch ( \ReflectionException $e ) {
            throw new RuntimeException(
                [ 'Unable to reflect function: %s', $callable ],
                null,
                $e
            );
        }

        return $rf;
    }


    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return bool
     */
    public function isFactory(\Closure $func, string $returnType) : bool
    {
        return null !== $this->filterFactory($func, $returnType);
    }

    /**
     * проверяет возвращаемый тип у замыкания
     *
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return null|\Closure
     */
    public function filterFactory(\Closure $func, string $returnType) : ?\Closure
    {
        $rf = $this->newReflectionFunction($func);

        $rt = $rf->getReturnType();

        if (null === $rt) {
            return null;
        }

        if (class_exists('ReflectionNamedType') && is_a($rt, 'ReflectionNamedType')) {
            if ($rt->getName() !== $returnType) {
                return null;
            }
        }

        if (class_exists('ReflectionUnionType') && is_a($rt, 'ReflectionUnionType')) {
            return null;
        }

        return $func;
    }

    /**
     * @param \Closure $func
     * @param string   $returnType
     *
     * @return \Closure
     */
    public function assertFactory(\Closure $func, string $returnType) : \Closure
    {
        if (null === $this->filterFactory($func, $returnType)) {
            throw new InvalidArgumentException('\Closure should have returnType ' . $returnType);
        }

        return $func;
    }


    /**
     * выполняет функцию как шаг array_filter
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return bool|array
     */
    public function filter(?callable $func, $arg, ...$arguments) : bool
    {
        if (! $func) {
            return empty($arg);
        }

        $result = (bool) call_user_func(
            $this->bind($func, $arg, ...$arguments)
        );

        return $result;
    }

    /**
     * выполняет функцию как шаг array_map
     *
     * @param null|callable $func
     * @param               $arg
     * @param array         $arguments
     *
     * @return mixed
     */
    public function map(?callable $func, $arg, ...$arguments) // : mixed
    {
        if (! $func) {
            return $arg;
        }

        $result = call_user_func(
            $this->bind($func, $arg, ...$arguments)
        );

        return $result;
    }

    /**
     * выполняет функцию как шаг array_reduce
     *
     * @param null|callable $func
     * @param               $arg
     * @param null          $carry
     * @param array         $arguments
     *
     * @return mixed
     */
    public function reduce(?callable $func, $arg, $carry = null, ...$arguments) // : mixed
    {
        if (! $func) {
            return $carry;
        }

        $result = call_user_func(
            $this->bind($func, $carry, $arg, ...$arguments)
        );

        return $result;
    }


    /**
     * bind
     * копирует тело функции и присваивает аргументы на их места в переданном порядке
     * bind('is_array', [], 1, 2) -> Closure of (function is_array($var = []))
     *
     * @param callable $func
     * @param mixed    ...$arguments
     *
     * @return \Closure
     */
    public function bind(callable $func, ...$arguments) : \Closure
    {
        // string
        if (is_string($func)) {
            $bind = [];

            $rf = $this->newReflectionFunction($func);

            $requiredCnt = $rf->getNumberOfRequiredParameters();

            while ( $requiredCnt-- ) {
                $bind[] = null !== key($arguments)
                    ? current($arguments)
                    : null;

                next($arguments);
            }

            $func = \Closure::fromCallable($func);

        } else {
            $bind = $arguments;

        }

        $result = function (...$args) use ($func, $bind) {
            $bind = array_replace(
                $bind,
                array_slice($args, 0, count($bind))
            );

            return call_user_func_array($func, $bind);
        };

        return $result;
    }


    /**
     * call
     * шорткат для call_user_func с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function call(callable $func, ...$arguments) // : mixed
    {
        return call_user_func($this->bind($func, ...$arguments));
    }

    /**
     * apply
     * шорткат для call_user_func_array с рефлексией, чтобы передать в функцию ожидаемое число аргументов
     * для \Closure не имеет смысла, а для string callable вполне
     *
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     */
    public function apply(callable $func, array $arguments) // : mixed
    {
        return call_user_func($this->bind($func, ...$arguments));
    }
}
