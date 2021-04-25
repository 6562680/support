<?php

namespace Gzhegow\Di\Registry;


/**
 * Class BindRegistry
 */
interface BindRegistryInterface
{
	/**
	 * @param string $bindName
	 *
	 * @return \Closure|string
	 */
	public function getBind(string $bindName);

	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasBind($bindName) : bool;

	/**
	 * @param string          $bindName
	 * @param \Closure|string $bind
	 *
	 * @return BindRegistry
	 */
	public function setBind(string $bindName, $bind);

	/**
	 * @param string          $bindName
	 * @param \Closure|string $bind
	 *
	 * @return BindRegistry
	 */
	public function addBind(string $bindName, $bind);
}