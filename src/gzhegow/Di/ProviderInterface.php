<?php

namespace Gzhegow\Di;


/**
 * Interface ProviderInterface
 */
interface ProviderInterface
{
	/**
	 * @return bool
	 */
	public function isRegistered() : bool;

	/**
	 * @return void
	 */
	public function register() : void;
}