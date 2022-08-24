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

use Gzhegow\Support\Exceptions\Exception;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\ILogger;
use Gzhegow\Support\SupportFactory;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\DebugLoadTrait;
use Gzhegow\Support\XLogger;

class Logger
{
    /**
     * @return callable[]
     */
    public static function getChannelFactories(): array
    {
        return static::getInstance()->getChannelFactories();
    }

    /**
     * @return XLogger[]|\Psr\Log\LoggerInterface[]
     */
    public static function getChannels(): array
    {
        return static::getInstance()->getChannels();
    }

    /**
     * @param string $channelName
     *
     * @return XLogger|\Psr\Log\LoggerInterface
     */
    public static function getChannel(string $channelName): object
    {
        return static::getInstance()->getChannel($channelName);
    }

    /**
     * @param null|static[]|\Psr\Log\LoggerInterface[]|callable[] $channels
     *
     * @return void
     */
    public static function setChannels(?array $channels): void
    {
        static::getInstance()->setChannels($channels);
    }

    /**
     * @param string                                   $channelName
     * @param static|\Psr\Log\LoggerInterface|callable $channel
     *
     * @return void
     */
    public static function addChannel(string $channelName, $channel): void
    {
        static::getInstance()->addChannel($channelName, $channel);
    }

    /**
     * @param null|string $channelName
     *
     * @return null|object|static|\Psr\Log\LoggerInterface
     */
    public static function selectChannel(?string $channelName): ?object
    {
        return static::getInstance()->selectChannel($channelName);
    }

    /**
     * @param string $channelName
     *
     * @return XLogger|\Psr\Log\LoggerInterface
     */
    public static function resolveChannel(string $channelName): object
    {
        return static::getInstance()->resolveChannel($channelName);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function emergency($message, array $context = []): void
    {
        static::getInstance()->emergency($message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function alert($message, array $context = []): void
    {
        static::getInstance()->alert($message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function critical($message, array $context = []): void
    {
        static::getInstance()->critical($message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function error($message, array $context = []): void
    {
        static::getInstance()->error($message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function warning($message, array $context = []): void
    {
        static::getInstance()->warning($message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function notice($message, array $context = []): void
    {
        static::getInstance()->notice($message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function info($message, array $context = []): void
    {
        static::getInstance()->info($message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function debug($message, array $context = []): void
    {
        static::getInstance()->debug($message, $context);
    }

    /**
     * @param mixed      $level
     * @param mixed      $message
     * @param null|array $context
     *
     * @return void
     */
    public static function log($level, $message, array $context = null): void
    {
        static::getInstance()->log($level, $message, $context);
    }

    /**
     * @return ILogger
     */
    public static function getInstance(): ILogger
    {
        return SupportFactory::getInstance()->getLogger();
    }
}
