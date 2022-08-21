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

use Gzhegow\Support\Exceptions\Logic\Cache\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;

interface ICache
{
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
     * @throws InvalidArgumentException
     */
    public function getItem($key);

    /**
     * @param string[] $keys
     *
     * @return array|\Traversable|\Psr\Cache\CacheItemInterface[]
     * @throws InvalidArgumentException
     */
    public function getItems(array $keys = []);

    /**
     * @param string $key
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function hasItem($key);

    /**
     * @param null|static[]|\Psr\Cache\CacheItemPoolInterface[] $pools
     *
     * @return void
     */
    public function setPools(?array $pools);

    /**
     * @param string                                          $poolName
     * @param object|static|\Psr\Cache\CacheItemPoolInterface $pool
     *
     * @return void
     */
    public function addPool(string $poolName, object $pool): void;

    /**
     * @param null|string $poolName
     *
     * @return null|object|static|\Psr\Cache\CacheItemPoolInterface
     */
    public function selectPool(?string $poolName): ?object;

    /**
     * @return bool
     */
    public function clear();

    /**
     * @param string $key
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteItem($key);

    /**
     * @param string[] $keys
     *
     * @return bool
     * @throws InvalidArgumentException
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
