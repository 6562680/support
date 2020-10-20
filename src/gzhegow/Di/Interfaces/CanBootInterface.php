<?php

namespace Gzhegow\Di\Interfaces;


/**
 * Interface CanBootInterface
 */
interface CanBootInterface
{
	/**
	 * @return bool
	 */
	public function isBooted() : bool;

	/**
	 * @param bool|null $booted
	 *
	 * @return void
	 */
	public function setBooted(bool $booted = null) : void;

	/**
	 * @return void
	 */
	public function boot() : void;
}