<?php

namespace Gzhegow\Support;


use Gzhegow\Support\Exceptions\RuntimeException;

/**
 * Func
 */
class Func
{
    /**
     * filter
     * выполняет функцию как array_filter. Если передать null, преобразует все аргументы к булеву типу
     * отталкивается от аргумента arg, работает над ним если null
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
            return is_array($arg)
                ? array_map(function ($val) {
                    return empty($val);
                }, $arg)
                : empty($arg);
        }

        $result = (bool) call_user_func(
            $this->bind($func, $arg, ...$arguments)
        );

        return $result;
    }


    /**
     * map
     * выполняет функцию как array_map. Если передать null, возвращает исходные аргументы
     * отталкивается от аргумента arg, работает над ним если null
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

            try {
                $rf = new \ReflectionFunction($func);
            }
            catch ( \ReflectionException $e ) {
                throw new RuntimeException('Unable to reflect function', func_get_args());
            }

            $cnt = $rf->getNumberOfRequiredParameters();

            while ( $cnt-- ) {
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
