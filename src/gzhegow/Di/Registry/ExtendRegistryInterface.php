<?php

namespace Gzhegow\Di\Registry;


/**
 * Class ExtendRegistry
 */
interface ExtendRegistryInterface
{
	/**
	 * @param string $bindName
	 *
	 * @return \Closure[]
	 */
	public function getExtends(string $bindName) : array;

	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasExtends($bindName) : bool;

	/**
	 * @param array $extends
	 *
	 * @return ExtendRegistry
	 */
	public function setExtends(array $extends = []);

	/**
	 * @param array $extends
	 *
	 * @return ExtendRegistry
	 */
	public function addExtends(array $extends = []);

	/**
	 * @param string          $bindName
	 * @param \Closure|string $extend
	 *
	 * @return ExtendRegistry
	 */
	public function addExtend(string $bindName, $extend);
}