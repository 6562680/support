<?php

namespace Gzhegow\Support\Traits\Aware;

use Gzhegow\Support\ICache;


/**
 * Trait
 */
trait CacheAwareTrait
{
    /**
     * @var ICache
     */
    protected $cache;


    /**
     * @param ICache $cache
     *
     * @return void
     */
    public function setCache(ICache $cache)
    {
        $this->cache = $cache;
    }
}