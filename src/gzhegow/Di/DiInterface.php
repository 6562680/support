<?php

namespace Gzhegow\Di;


use Gzhegow\Di\Exceptions\NotFoundException;
use Gzhegow\Di\Exceptions\OutOfRangeException;

/**
 * Class Di
 */
interface DiInterface
{
	/**
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function getOrFail(string $id);


	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function getItem(string $id);


	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function getBind(string $id);


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
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 * @throws OutOfRangeException()
	 */
	public function setShared(string $id, $item);

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return mixed
	 */
	public function setSharedOrFail(string $id, $item);


	/**
	 * @param array $providers
	 *
	 * @return Di
	 */
	public function setProviders(array $providers);

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
	 * @throws NotFoundException
	 */
	public function get($id);

	/**
	 * @param string $id
	 *
	 * @return bool
	 */
	public function has($id);

	/**
	 * @param string $id
	 * @param mixed  $item
	 * @param bool   $shared
	 *
	 * @return Di
	 * @throws OutOfRangeException()
	 */
	public function set(string $id, $item, bool $shared = false);


	/**
	 * @param string $configPath
	 *
	 * @return $this
	 */
	public function loadConfig(string $configPath);


	/**
	 * @param mixed $provider
	 *
	 * @return $this
	 */
	public function registerProvider($provider);


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
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 * @throws OutOfRangeException()
	 */
	public function singleton(string $id, $item);

	/**
	 * @param string                   $id
	 * @param string|callable|\Closure $func
	 *
	 * @return Di
	 */
	public function extend(string $id, $func);


	/**
	 * @param ProviderInterface $provider
	 *
	 * @return Di
	 */
	public function removeProvider(ProviderInterface $provider);


	/**
	 * @return Di
	 */
	public function boot();

	/**
	 * @param string $id
	 *
	 * @return Di
	 * @throws NotFoundException
	 */
	public function bootDeferable(string $id);


	/**
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function createAutowired(string $id, array $params = []);

	/**
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 */
	public function createAutowiredOrFail(string $id, array $params = []);


	/**
	 * @param callable $func
	 * @param array    $params
	 *
	 * @return mixed
	 */
	public function callAutowired(callable $func, array $params = []);
}