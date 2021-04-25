<?php

namespace Gzhegow\Di;

use Psr\Container\ContainerInterface;

/**
 * Interface InjectorInterface
 */
interface InjectorInterface extends ContainerInterface
{
	/**
	 * @param string $id
	 * @param mixed  ...$arguments
	 *
	 * @return mixed
	 */
	public function create($id, ...$arguments);

	/**
	 * @param string $id
	 * @param mixed  ...$arguments
	 *
	 * @return mixed
	 */
	public function new($id, ...$arguments);


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