<?php

namespace Gzhegow\Di\Interfaces;


/**
 * Interface CanRegisterInterface
 */
interface CanRegisterInterface
{
	/**
	 * @return bool
	 */
	public function isRegistered() : bool;

	/**
	 * @param bool|null $registered
	 *
	 * @return void
	 */
	public function markAsRegistered(bool $registered = null) : void;

	/**
	 * @return void
	 */
	public function register() : void;
}