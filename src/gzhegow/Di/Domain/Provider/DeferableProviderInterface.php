<?php

namespace Gzhegow\Di\Domain\Provider;

use Gzhegow\Di\Domain\Provider\Traits\CanSyncInterface;
use Gzhegow\Di\Domain\Provider\Traits\CanBootInterface;

/**
 * DeferableProviderInterface
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
