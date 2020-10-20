<?php

namespace Gzhegow\Di;

use Gzhegow\Di\Interfaces\CanBootInterface;
use Gzhegow\Di\Interfaces\CanSyncInterface;

/**
 * Interface BootableProviderInterface
 */
interface BootableProviderInterface extends ProviderInterface, CanSyncInterface, CanBootInterface
{
}