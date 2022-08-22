<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\Cache\InvalidArgumentException as InvalidArgumentException1;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;

interface ICache
{
    /**
     * @return callable[]
     */
    public function getPoolFactories(): array;

    /**
     * @return XCache[]|\Psr\Cache\CacheItemPoolInterface[]
     */
    public function getPools(): array;

    /**
     * @param string $poolName
     *
     * @return XCache|\Psr\Cache\CacheItemPoolInterface
     */
    public function getPool(string $poolName): object;

    /**
     * @param string $key
     *
     * @return \Psr\Cache\CacheItemInterface
     * @throws CacheInvalidArgumentException
     */
    public function getItem($key);

    /**
     * @param string[] $keys
     *
     * @return array|\Traversable|\Psr\Cache\CacheItemInterface[]
     * @throws CacheInvalidArgumentException
     */
    public function getItems(array $keys = []);

    /**
     * @param string $key
     *
     * @return bool
     * @throws CacheInvalidArgumentException
     */
    public function hasItem($key);

    /**
     * @param null|static[]|\Psr\Cache\CacheItemPoolInterface[]|callable[] $pools
     *
     * @return void
     */
    public function setPools(?array $pools);

    /**
     * @param string                                            $poolName
     * @param static|\Psr\Cache\CacheItemPoolInterface|callable $pool
     *
     * @return void
     */
    public function addPool(string $poolName, $pool): void;

    /**
     * @param null|string $poolName
     *
     * @return null|object|static|\Psr\Cache\CacheItemPoolInterface
     */
    public function selectPool(?string $poolName): ?object;

    /**
     * @param string $poolName
     *
     * @return XCache|\Psr\Cache\CacheItemPoolInterface
     */
    public function resolvePool(string $poolName): object;

    /**
     * @return bool
     */
    public function clear();

    /**
     * @param string $key
     *
     * @return bool
     * @throws CacheInvalidArgumentException
     */
    public function deleteItem($key);

    /**
     * @param string[] $keys
     *
     * @return bool
     * @throws CacheInvalidArgumentException
     */
    public function deleteItems(array $keys);

    /**
     * @param object|\Psr\Cache\CacheItemInterface $item
     *
     * @return bool
     */
    public function save(object $item);

    /**
     * @param object|\Psr\Cache\CacheItemInterface $item
     *
     * @return bool
     */
    public function saveDeferred(object $item);

    /**
     * @return bool
     */
    public function commit();
}
