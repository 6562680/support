<?php

namespace Gzhegow\Di\Registry;


/**
 * Class ItemRegistry
 */
interface ItemRegistryInterface
{
	/**
	 * @param string $bindName
	 *
	 * @return mixed
	 */
	public function getItem(string $bindName);

	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasItem($bindName) : bool;

	/**
	 * @param string $bindName
	 * @param mixed  $item
	 *
	 * @return ItemRegistry
	 */
	public function setItem(string $bindName, $item);

	/**
	 * @param string          $bindName
	 * @param \Closure|string $item
	 *
	 * @return ItemRegistry
	 */
	public function addItem(string $bindName, $item);
}