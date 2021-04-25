<?php

namespace Gzhegow\Di\Registry;


/**
 * Class SharedRegistry
 */
interface SharedRegistryInterface
{
	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasLocal($bindName) : bool;

	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasShared($bindName) : bool;


	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function setLocal(string $bindName);

	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function setShared(string $bindName);


	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function addLocal(string $bindName);

	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function addShared(string $bindName);


	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function removeShared(string $bindName);
}