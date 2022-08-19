<?php

namespace Gzhegow\Support\Interfaces\Aware;

use Gzhegow\Support\ICache;


/**
 * Interface
 */
interface CacheAwareInterface
{
    /**
     * @param ICache $cache
     *
     * @return void
     */
    public function setCache(ICache $cache);
}