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

use Gzhegow\Support\Exceptions\Exception;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\DebugLoadTrait;

interface ILogger
{
    /**
     * @return callable[]
     */
    public function getChannelFactories(): array;

    /**
     * @return XLogger[]|\Psr\Log\LoggerInterface[]
     */
    public function getChannels(): array;

    /**
     * @param string $channelName
     *
     * @return XLogger|\Psr\Log\LoggerInterface
     */
    public function getChannel(string $channelName): object;

    /**
     * @param null|static[]|\Psr\Log\LoggerInterface[]|callable[] $channels
     *
     * @return void
     */
    public function setChannels(?array $channels);

    /**
     * @param string                                   $channelName
     * @param static|\Psr\Log\LoggerInterface|callable $channel
     *
     * @return void
     */
    public function addChannel(string $channelName, $channel): void;

    /**
     * @param null|string $channelName
     *
     * @return null|object|static|\Psr\Log\LoggerInterface
     */
    public function selectChannel(?string $channelName): ?object;

    /**
     * @param string $channelName
     *
     * @return XLogger|\Psr\Log\LoggerInterface
     */
    public function resolveChannel(string $channelName): object;

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = []);

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = []);

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = []);

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = []);

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = []);

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = []);

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = []);

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = []);

    /**
     * @param mixed      $level
     * @param mixed      $message
     * @param null|array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = null);
}
