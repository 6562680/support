<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\Logic\Cache\InvalidArgumentException as CacheInvalidArgumentException;


/**
 * XCache
 */
class XCache implements ICache
{
    const PSR_CACHE_ITEM_INTERFACE      = 'Psr\Cache\CacheItemInterface';
    const PSR_CACHE_ITEM_POOL_INTERFACE = 'Psr\Cache\CacheItemPoolInterface';


    /**
     * @var callable[]
     */
    protected $poolFactories = [];
    /**
     * @var static[]|\Psr\Cache\CacheItemPoolInterface[]
     */
    protected $pools = [];
    /**
     * @var static|\Psr\Cache\CacheItemPoolInterface
     */
    protected $pool;


    /**
     * @return callable[]
     */
    public function getPoolFactories() : array
    {
        return $this->poolFactories;
    }

    /**
     * @return static[]|\Psr\Cache\CacheItemPoolInterface[]
     */
    public function getPools() : array
    {
        return $this->pools;
    }


    /**
     * @param string $poolName
     *
     * @return static|\Psr\Cache\CacheItemPoolInterface
     */
    public function getPool(string $poolName) : object
    {
        if (! strlen($poolName)) {
            throw new InvalidArgumentException(
                'The `poolName` should be non-empty string'
            );
        }

        return $this->pools[ $poolName ]
            ?? $this->resolvePool($poolName);
    }


    /**
     * @param string $key
     *
     * @return \Psr\Cache\CacheItemInterface
     * @throws CacheInvalidArgumentException
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
            throw new CacheInvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }

    /**
     * @param string[] $keys
     *
     * @return array|\Traversable|\Psr\Cache\CacheItemInterface[]
     * @throws CacheInvalidArgumentException
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
            throw new CacheInvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }


    /**
     * @param string $key
     *
     * @return bool
     * @throws CacheInvalidArgumentException
     */
    public function hasItem($key)
    {
        try {
            $result = $this->pool->hasItem($key);
        }
        catch ( \Psr\Cache\InvalidArgumentException $e ) {
            throw new CacheInvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }


    /**
     * @param null|static[]|\Psr\Cache\CacheItemPoolInterface[]|callable[] $pools
     *
     * @return void
     */
    public function setPools(?array $pools)
    {
        $this->pools = [];
        $this->poolFactories = [];

        foreach ( $pools as $poolName => $pool ) {
            $this->addPool($poolName, $pool);
        }
    }

    /**
     * @param string                                            $poolName
     * @param static|\Psr\Cache\CacheItemPoolInterface|callable $pool
     *
     * @return void
     */
    public function addPool(string $poolName, $pool) : void
    {
        if (! strlen($poolName)) {
            throw new InvalidArgumentException(
                'The `poolName` should be non-empty string'
            );
        }

        if (isset($this->pools[ $poolName ])
            || isset($this->poolFactories[ $poolName ])
        ) {
            throw new RuntimeException(
                'Pool is already exists by name: ' . $poolName
            );
        }

        $isFactory = false;
        if (! ( is_a($pool, $interface = static::PSR_CACHE_ITEM_POOL_INTERFACE)
            || is_a($pool, static::class)
            || ( $isFactory = is_callable($pool) )
        )) {
            throw new InvalidArgumentException([
                'The `pool` should be callable or extends/implements one of: %s / %s',
                $pool,
                [ static::class, $interface ],
            ]);
        }

        $isFactory
            ? $this->poolFactories[ $poolName ] = $pool
            : $this->pools[ $poolName ] = $pool;
    }


    /**
     * @param null|string $poolName
     *
     * @return null|object|static|\Psr\Cache\CacheItemPoolInterface
     */
    public function selectPool(?string $poolName) : ?object
    {
        if (null !== $poolName) {
            $pool = $this->getPool($poolName);
        }

        return $this->pool = $pool ?? null;
    }


    /**
     * @param string $poolName
     *
     * @return static|\Psr\Cache\CacheItemPoolInterface
     */
    public function resolvePool(string $poolName) : object
    {
        if (! isset($this->pools[ $poolName ])) {
            $factory = $this->poolFactories[ $poolName ] ?? null;

            if (! $factory) {
                throw new RuntimeException(
                    'Unknown pool: ' . $poolName
                );
            }

            $pool = $factory($this);

            if (! ( is_a($pool, $interface = static::PSR_CACHE_ITEM_POOL_INTERFACE)
                || is_a($pool, static::class)
            )) {
                throw new RuntimeException([
                    'The `pool` should extends/implements one of: %s / %s',
                    $pool,
                    [ static::class, $interface ],
                ]);
            }

            $this->pools[ $poolName ] = $pool;

            unset($this->poolFactories[ $poolName ]);
        }

        return $this->pools[ $poolName ];
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
     * @throws CacheInvalidArgumentException
     */
    public function deleteItem($key)
    {
        try {
            $result = $this->pool->deleteItem($key);
        }
        catch ( \Psr\Cache\InvalidArgumentException $e ) {
            throw new CacheInvalidArgumentException($e->getMessage(), null, $e);
        }

        return $result;
    }

    /**
     * @param string[] $keys
     *
     * @return bool
     * @throws CacheInvalidArgumentException
     */
    public function deleteItems(array $keys)
    {
        try {
            $result = $this->pool->deleteItems($keys);
        }
        catch ( \Psr\Cache\InvalidArgumentException $e ) {
            throw new CacheInvalidArgumentException($e->getMessage(), null, $e);
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
            throw new InvalidArgumentException(
                'The `item` should implements ' . $interface
            );
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
            throw new InvalidArgumentException(
                'The `item` should implements ' . $interface
            );
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