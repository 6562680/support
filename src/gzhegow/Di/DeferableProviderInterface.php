<?php

namespace Gzhegow\Di;


/**
 * Interface DeferableProviderInterface
 */
interface DeferableProviderInterface extends BootProviderInterface
{
	/**
	 * @return array
	 */
	public function provides() : array;
}