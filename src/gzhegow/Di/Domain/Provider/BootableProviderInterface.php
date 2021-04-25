<?php

namespace Gzhegow\Di\Domain\Provider;

use Gzhegow\Di\Domain\Provider\Traits\CanSyncInterface;
use Gzhegow\Di\Domain\Provider\Traits\CanBootInterface;

/**
 * BootableProviderInterface
 */
interface BootableProviderInterface extends
	ProviderInterface,
	CanSyncInterface,
	CanBootInterface
{
}
