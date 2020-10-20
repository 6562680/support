<?php

namespace Gzhegow\Di;


use Gzhegow\Di\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Di\Exceptions\Exception\NotFoundException;

/**
 * Class Di
 */
interface DiInterface
{
	/**
	 * @return Di
	 */
	public function boot();
	/**
	 * @return bool
	 */
	public function isBooted() : bool;


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
	 * @throws OutOfRangeException
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
	 * Alias for bindShared
	 *
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 * @throws OutOfRangeException
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
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function create(string $id, ...$arguments);

	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public function createOrFail(string $id, ...$arguments);


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