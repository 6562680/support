<?php

namespace Gzhegow\Di;


/**
 * Interface BootProviderInterface
 */
interface BootProviderInterface extends ProviderInterface
{
	/**
	 * @return bool
	 */
	public function isBooted() : bool;

	/**
	 * @return void
	 */
	public function boot() : void;
}