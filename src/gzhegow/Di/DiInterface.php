<?php

namespace Gzhegow\Di;


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
	public function hasItem($id) : bool;


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
	 * @param string $id
	 *
	 * @return mixed
	 * @throws OutOfRangeException
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
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 * @throws OutOfRangeException
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
	 * @param string $id
	 * @param mixed  $bind
	 * @param bool   $shared
	 *
	 * @return Di
	 */
	public function bind(string $id, $bind, bool $shared = false);

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 */
	public function bindShared(string $id, $item);


	/**
	 * @param string $id
	 * @param mixed  $bind
	 * @param bool   $shared
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
	 * @param string   $id
	 * @param \Closure $func
	 *
	 * @return Di
	 */
	public function extend(string $id, \Closure $func);


	/**
	 * @param callable $func
	 * @param array    $params
	 *
	 * @return mixed
	 */
	public function callAutowired(callable $func, array $params = []);

	/**
	 * @param callable $func
	 * @param array    $params
	 *
	 * @return mixed
	 */
	public function callAutowiredOrFail(callable $func, array &$params = []);
}