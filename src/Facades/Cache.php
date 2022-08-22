<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Exceptions\Logic\Cache\InvalidArgumentException as InvalidArgumentException1;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\ICache;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\XCache;

class Cache
{
    /**
     * @return callable[]
     */
    public static function getPoolFactories(): array
    {
        return static::getInstance()->getPoolFactories();
    }

    /**
     * @return XCache[]|\Psr\Cache\CacheItemPoolInterface[]
     */
    public static function getPools(): array
    {
        return static::getInstance()->getPools();
    }

    /**
     * @param string $poolName
     *
     * @return XCache|\Psr\Cache\CacheItemPoolInterface
     */
    public static function getPool(string $poolName): object
    {
        return static::getInstance()->getPool($poolName);
    }

    /**
     * @param string $key
     *
     * @return \Psr\Cache\CacheItemInterface
     * @throws CacheInvalidArgumentException
     */
    public static function getItem($key)
    {
        return static::getInstance()->getItem($key);
    }

    /**
     * @param string[] $keys
     *
     * @return array|\Traversable|\Psr\Cache\CacheItemInterface[]
     * @throws CacheInvalidArgumentException
     */
    public static function getItems(array $keys = [])
    {
        return static::getInstance()->getItems($keys);
    }

    /**
     * @param string $key
     *
     * @return bool
     * @throws CacheInvalidArgumentException
     */
    public static function hasItem($key)
    {
        return static::getInstance()->hasItem($key);
    }

    /**
     * @param null|static[]|\Psr\Cache\CacheItemPoolInterface[]|callable[] $pools
     *
     * @return void
     */
    public static function setPools(?array $pools)
    {
        return static::getInstance()->setPools($pools);
    }

    /**
     * @param string                                            $poolName
     * @param static|\Psr\Cache\CacheItemPoolInterface|callable $pool
     *
     * @return void
     */
    public static function addPool(string $poolName, $pool): void
    {
        static::getInstance()->addPool($poolName, $pool);
    }

    /**
     * @param null|string $poolName
     *
     * @return null|object|static|\Psr\Cache\CacheItemPoolInterface
     */
    public static function selectPool(?string $poolName): ?object
    {
        return static::getInstance()->selectPool($poolName);
    }

    /**
     * @param string $poolName
     *
     * @return XCache|\Psr\Cache\CacheItemPoolInterface
     */
    public static function resolvePool(string $poolName): object
    {
        return static::getInstance()->resolvePool($poolName);
    }

    /**
     * @return bool
     */
    public static function clear()
    {
        return static::getInstance()->clear();
    }

    /**
     * @param string $key
     *
     * @return bool
     * @throws CacheInvalidArgumentException
     */
    public static function deleteItem($key)
    {
        return static::getInstance()->deleteItem($key);
    }

    /**
     * @param string[] $keys
     *
     * @return bool
     * @throws CacheInvalidArgumentException
     */
    public static function deleteItems(array $keys)
    {
        return static::getInstance()->deleteItems($keys);
    }

    /**
     * @param object|\Psr\Cache\CacheItemInterface $item
     *
     * @return bool
     */
    public static function save(object $item)
    {
        return static::getInstance()->save($item);
    }

    /**
     * @param object|\Psr\Cache\CacheItemInterface $item
     *
     * @return bool
     */
    public static function saveDeferred(object $item)
    {
        return static::getInstance()->saveDeferred($item);
    }

    /**
     * @return bool
     */
    public static function commit()
    {
        return static::getInstance()->commit();
    }

    /**
     * @return ICache
     */
    public static function getInstance(): ICache
    {
        return SupportFactory::getInstance()->getCache();
    }
}
