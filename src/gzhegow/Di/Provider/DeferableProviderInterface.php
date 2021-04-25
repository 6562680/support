<?php

namespace Gzhegow\Di\Provider;

use Gzhegow\Di\Provider\Traits\CanSyncInterface;
use Gzhegow\Di\Provider\Traits\CanBootInterface;

/**
 * Interface DeferableProviderInterface
 */
interface DeferableProviderInterface extends
	ProviderInterface,
	CanSyncInterface,
	CanBootInterface
{
	/**
	 * @return array
	 */
	public function provides() : array;
}