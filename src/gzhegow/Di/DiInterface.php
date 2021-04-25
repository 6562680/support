<?php

namespace Gzhegow\Di;


use Gzhegow\Di\Domain\Delegate\DelegateManager;
use Gzhegow\Di\Domain\Injector\InjectorInterface;
use Gzhegow\Di\Domain\Provider\ProviderManager;
use Gzhegow\Di\App\Exceptions\Runtime\Domain\NotFoundException;
use Psr\Container\ContainerInterface;

/**
 * Di
 */
interface DiInterface extends
    ContainerInterface,
    InjectorInterface
{
    /**
     * @return DiManager
     */
    public function getDiManager() : DiManager;

    /**
     * @return ProviderManager
     */
    public function getProviderManager() : ProviderManager;

    /**
     * @return DelegateManager
     */
    public function getDelegateManager() : DelegateManager;


    /**
     * @param string $id
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function get($id);


    /**
     * @param string $id
     *
     * @return bool
     */
    public function hasBind($id);

    /**
     * @param string $id
     *
     * @return bool
     */
    public function hasItem($id);

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has($id);


    /**
     * @param string $id
     * @param mixed  $item
     *
     * @return static
     */
    public function set(string $id, $item);

    /**
     * @param string          $id
     * @param string|\Closure $item
     *
     * @return static
     */
    public function replace(string $id, $item);


    /**
     * @param string $id
     *
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function new($id, ...$arguments);

    /**
     * @param string $id
     * @param array  $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function create($id, ...$arguments);


    /**
     * @param string $delegateClass
     *
     * @return static
     */
    public function setDelegateClass(string $delegateClass);


    /**
     * @param string          $id
     * @param string|\Closure $bind
     * @param bool            $shared
     *
     * @return static
     */
    public function bind(string $id, $bind, bool $shared = false);

    /**
     * @param string          $id
     * @param string|\Closure $bind
     *
     * @return static
     */
    public function bindShared(string $id, $bind);


    /**
     * @param string          $id
     * @param string|\Closure $bind
     * @param bool            $shared
     *
     * @return static
     */
    public function rebind(string $id, $bind, bool $shared = false);

    /**
     * @param string $id
     * @param mixed  $bind
     *
     * @return static
     */
    public function rebindShared(string $id, $bind);


    /**
     * @param string                   $id
     * @param string|callable|\Closure $func
     *
     * @return static
     */
    public function extend(string $id, $func);


    /**
     * @param mixed $provider
     *
     * @return static
     */
    public function registerProvider($provider);


    /**
     * @return static
     */
    public function boot();


    /**
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function handle($func, ...$arguments);


    /**
     * @param mixed    $newthis
     * @param callable $func
     * @param array    $arguments
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function call($newthis, $func, ...$arguments);
}
