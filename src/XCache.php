<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\Cache\InvalidArgumentException;


/**
 * XCache
 */
class XCache implements ICache
{
    const PSR_CACHE_ITEM_INTERFACE      = 'Psr\Cache\CacheItemInterface';
    const PSR_CACHE_ITEM_POOL_INTERFACE = 'Psr\Cache\CacheItemPoolInterface';


    /**
     * @var \Psr\Cache\CacheItemPoolInterface[]
     */
    protected $pools = [];
    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    protected $pool;


    /**
     * @return \Psr\Cache\CacheItemPoolInterface[]
     */
    public function getPools() : array
    {
        return $this->pools;
    }

    /**
     * @param string $poolName
     *
     * @return \Psr\Cache\CacheItemPoolInterface
     */
    public function getPool(string $poolName) : object
    {
        if (! strlen($poolName)) {
            throw new \InvalidArgumentException('The `poolName` should be non-empty string');
        }

        if (! isset($this->pools[ $poolName ])) {
            throw new \InvalidArgumentException('Unknown channel: ' . $poolName);
        }

        return $this->pools[ $poolName ];
    }


    /**
     * @param string $key
     *
     * @return \Psr\Cache\CacheItemInterface
     * @throws InvalidArgumentException
     */
    public function getItem($key)
    {
        /**
         * @var \Psr\Cache\CacheItemInterface $result
         */

        try {
            $result = $this->pool->getItem($key);
        }
        catch ( \Psr\Cache\InvalidArgumentException $e ) {
            throw new InvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }

    /**
     * @param string[] $keys
     *
     * @return array|\Traversable|\Psr\Cache\CacheItemInterface[]
     * @throws InvalidArgumentException
     */
    public function getItems(array $keys = [])
    {
        /**
         * @var array|\Traversable|\Psr\Cache\CacheItemInterface[] $result
         */

        try {
            $result = $this->pool->getItems($keys);
        }
        catch ( \Psr\Cache\InvalidArgumentException $e ) {
            throw new InvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }


    /**
     * @param string $key
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function hasItem($key)
    {
        try {
            $result = $this->pool->hasItem($key);
        }
        catch ( \Psr\Cache\InvalidArgumentException $e ) {
            throw new InvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }


    /**
     * @param null|array $pools
     *
     * @return void
     */
    public function setPools(?array $pools)
    {
        $this->pools = [];

        foreach ( $pools as $poolName => $pool ) {
            $this->addPool($poolName, $pool);
        }
    }

    /**
     * @param string                                   $poolName
     * @param object|\Psr\Cache\CacheItemPoolInterface $pool
     *
     * @return void
     */
    public function addPool(string $poolName, object $pool) : void
    {
        if (! strlen($poolName)) {
            throw new \InvalidArgumentException('The `poolName` should be non-empty string');
        }

        if (! is_a($pool, $interface = static::PSR_CACHE_ITEM_POOL_INTERFACE)) {
            throw new RuntimeException('The `pool` should implements ' . $interface);
        }

        if (isset($this->pools[ $poolName ])) {
            throw new \InvalidArgumentException('Pool is already exists by name: ' . $poolName);
        }

        $this->pools[ $poolName ] = $pool;
    }


    /**
     * @param null|string $poolName
     *
     * @return null|object|\Psr\Cache\CacheItemPoolInterface
     */
    public function selectPool(?string $poolName) : ?object
    {
        if ('' !== $poolName) {
            $pool = $this->getPool($poolName);
        }

        return $this->pool = $pool ?? null;
    }


    /**
     * @return bool
     */
    public function clear()
    {
        return $this->pool->clear();
    }


    /**
     * @param string $key
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteItem($key)
    {
        try {
            $result = $this->pool->deleteItem($key);
        }
        catch ( \Psr\Cache\InvalidArgumentException $e ) {
            throw new InvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }

    /**
     * @param string[] $keys
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteItems(array $keys)
    {
        try {
            $result = $this->pool->deleteItems($keys);
        }
        catch ( \Psr\Cache\InvalidArgumentException $e ) {
            throw new InvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }


    /**
     * @param object|\Psr\Cache\CacheItemInterface $item
     *
     * @return bool
     */
    public function save(object $item)
    {
        if (! is_a($item, $interface = static::PSR_CACHE_ITEM_INTERFACE)) {
            throw new RuntimeException('The `item` should implements ' . $interface);
        }

        return $this->pool->save($item);
    }

    /**
     * @param object|\Psr\Cache\CacheItemInterface $item
     *
     * @return bool
     */
    public function saveDeferred(object $item)
    {
        if (! is_a($item, $interface = static::PSR_CACHE_ITEM_INTERFACE)) {
            throw new RuntimeException('The `item` should implements ' . $interface);
        }

        return $this->pool->saveDeferred($item);
    }


    /**
     * @return bool
     */
    public function commit()
    {
        return $this->pool->commit();
    }


    /**
     * @return ICache
     */
    public static function getInstance() : ICache
    {
        return SupportFactory::getInstance()->getCache();
    }
}