<?php

namespace Gzhegow\Di\Provider;

use Gzhegow\Di\Provider\Traits\CanSyncInterface;
use Gzhegow\Di\Provider\Traits\CanBootInterface;

/**
 * Interface BootableProviderInterface
 */
interface BootableProviderInterface extends
	ProviderInterface,
	CanSyncInterface,
	CanBootInterface
{
}