<?php

namespace Gzhegow\Di;


use Gzhegow\Di\Exceptions\Error\NotFoundError;

/**
 * Class Di
 */
interface DiInterface
{
	/**
	 * @param string $id
	 *
	 * @return string|\Closure
	 * @throws NotFoundError
	 */
	public function getBind(string $id);

	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public function getItem(string $id);

	/**
	 * @param string $id
	 *
	 * @return array
	 * @throws NotFoundError
	 */
	public function getExtends(string $id) : array;

	/**
	 * @return ProviderInterface[]
	 */
	public function getProviders() : array;

	/**
	 * @return BootableProviderInterface[]
	 */
	public function getProvidersBootable() : array;

	/**
	 * @return DeferableProviderInterface[][]
	 */
	public function getProvidersDeferable() : array;

	/**
	 * @return string
	 */
	public function getDelegateClass() : string;

	/**
	 * @return bool
	 */
	public function isBooted() : bool;

	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasItem($id) : bool;

	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasBind($id) : bool;

	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasDeferableBind($id) : bool;

	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasShared($id) : bool;

	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasExtends($id) : bool;

	/**
	 * @return bool
	 */
	public function hasDelegateClass() : bool;

	/**
	 * @param array $providers
	 *
	 * @return Di
	 */
	public function setProviders(array $providers);

	/**
	 * @param string $delegateClass
	 *
	 * @return Di
	 */
	public function setDelegateClass(string $delegateClass);

	/**
	 * @param array $providers
	 *
	 * @return $this
	 */
	public function addProviders(array $providers);

	/**
	 * @param ProviderInterface $provider
	 *
	 * @return Di
	 */
	public function addProvider(ProviderInterface $provider);

	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public function get($id);

	/**
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function getOrFail(string $id);

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
	 * @return Di
	 */
	public function set(string $id, $item);

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return mixed
	 */
	public function setOrFail(string $id, $item);

	/**
	 * @param mixed $id
	 *
	 * @return Loop
	 */
	public function newLoop($id) : Loop;

	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public function newOrFail(string $id, ...$arguments);

	/**
	 * @param string $id
	 *
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public function new($id, ...$arguments);

	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public function createOrFail(string $id, ...$arguments);

	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public function create(string $id, ...$arguments);

	/**
	 * @param string          $id
	 * @param string|\Closure $item
	 *
	 * @return Di
	 */
	public function replace(string $id, $item);


	/**
	 * @param string          $id
	 * @param string|\Closure $bind
	 * @param bool            $shared
	 *
	 * @return Di
	 */
	public function bind(string $id, $bind, bool $shared = false);

	/**
	 * @param string          $id
	 * @param string|\Closure $bind
	 *
	 * @return Di
	 */
	public function bindShared(string $id, $bind);

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 */
	public function singleton(string $id, $item);


	/**
	 * @param string          $id
	 * @param string|\Closure $bind
	 * @param bool            $shared
	 *
	 * @return Di
	 */
	public function rebind(string $id, $bind, bool $shared = false);

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 */
	public function rebindShared(string $id, $item);


	/**
	 * @param string                   $id
	 * @param string|callable|\Closure $func
	 *
	 * @return Di
	 */
	public function extend(string $id, $func);


	/**
	 * @param mixed $provider
	 *
	 * @return $this
	 */
	public function registerProvider($provider);

	/**
	 * @param mixed $provider
	 *
	 * @return Di
	 */
	public function removeProvider($provider);


	/**
	 * @return Di
	 */
	public function boot();

	/**
	 * @param string $id
	 *
	 * @return Di
	 * @throws NotFoundError
	 */
	public function bootDeferable(string $id);


	/**
	 * @param callable $func
	 * @param array    $arguments
	 *
	 * @return mixed
	 */
	public function handle($func, ...$arguments);

	/**
	 * @param mixed    $newthis
	 * @param callable $func
	 * @param array    $arguments
	 *
	 * @return mixed
	 */
	public function call($newthis, $func, ...$arguments);
}