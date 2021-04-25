<?php

namespace Gzhegow\Di\Registry;


/**
 * Class DeferableRegistry
 */
interface DeferableRegistryInterface
{
	/**
	 * @param string $bindName
	 *
	 * @return \Closure|string
	 */
	public function getDeferable(string $bindName);


	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasDeferable($bindName) : bool;


	/**
	 * @param array $deferables
	 *
	 * @return DeferableRegistry
	 */
	public function setDeferables(array $deferables);


	/**
	 * @param array $deferables
	 *
	 * @return DeferableRegistry
	 */
	public function addDeferables(array $deferables);

	/**
	 * @param string          $bindName
	 * @param \Closure|string $provider
	 *
	 * @return DeferableRegistry
	 */
	public function addDeferable(string $bindName, $provider);
}