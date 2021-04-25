<?php

namespace Gzhegow\Di;

use Gzhegow\Di\Interfaces\CanBootInterface;
use Gzhegow\Di\Interfaces\CanSyncInterface;

/**
 * Interface DeferableProviderInterface
 */
interface DeferableProviderInterface extends ProviderInterface, CanSyncInterface, CanBootInterface
{
	/**
	 * @return array
	 */
	public function provides() : array;
}