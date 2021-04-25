<?php

namespace Gzhegow\Di\Domain\Injector;


/**
 * InjectorInterface
 */
interface InjectorInterface
{
    /**
     * @param string $id
     * @param mixed  ...$arguments
     *
     * @return mixed
     */
    public function new(string $id, ...$arguments);

    /**
     * @param string $id
     * @param mixed  ...$arguments
     *
     * @return mixed
     */
    public function create(string $id, ...$arguments);


    /**
     * @param callable $func
     * @param mixed    ...$arguments
     *
     * @return mixed
     */
    public function handle($func, ...$arguments);


    /**
     * @param object   $newthis
     * @param callable $func
     * @param mixed    ...$arguments
     *
     * @return mixed
     */
    public function call($newthis, $func, ...$arguments);
}
