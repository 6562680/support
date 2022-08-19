<?php

namespace Gzhegow\Support\Traits\Load;

use Gzhegow\Support\ICache;


/**
 * Trait
 */
trait CacheLoadTrait
{
    /**
     * @var ICache
     */
    protected $cache;


    /**
     * @param null|ICache $cache
     *
     * @return static
     */
    public function withCache(?ICache $cache)
    {
        $this->cache = $cache;

        return $this;
    }


    /**
     * @return ICache
     */
    protected function getCache() : ICache
    {
        return $this->cache = $this->cache
            ?? $this->loadCache();
    }


    /**
     * @return ICache
     */
    abstract public function loadCache() : ICache;
}