<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Exception;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\DebugLoadTrait;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * XLogger
 */
class XLogger implements ILogger
{
    use ArrLoadTrait;
    use DebugLoadTrait;


    const PSR_LOGGER_INTERFACE = 'Psr\Log\LoggerInterface';


    /**
     * @var callable[]
     */
    protected $channelFactories = [];
    /**
     * @var static[]|\Psr\Log\LoggerInterface[]
     */
    protected $channels = [];
    /**
     * @var static|\Psr\Log\LoggerInterface
     */
    protected $channel;


    /**
     * @return callable[]
     */
    public function getChannelFactories() : array
    {
        return $this->channelFactories;
    }

    /**
     * @return static[]|\Psr\Log\LoggerInterface[]
     */
    public function getChannels() : array
    {
        return $this->channels;
    }


    /**
     * @param string $channelName
     *
     * @return static|\Psr\Log\LoggerInterface
     */
    public function getChannel(string $channelName) : object
    {
        if (! strlen($channelName)) {
            throw new InvalidArgumentException(
                'The `channelName` should be non-empty string'
            );
        }

        return $this->channels[ $channelName ]
            ?? $this->resolveChannel($channelName);
    }


    /**
     * @param null|static[]|\Psr\Log\LoggerInterface[]|callable[] $channels
     *
     * @return void
     */
    public function setChannels(?array $channels)
    {
        $this->channels = [];
        $this->channelFactories = [];

        foreach ( $channels as $channelName => $channel ) {
            $this->addChannel($channelName, $channel);
        }
    }

    /**
     * @param string                                   $channelName
     * @param static|\Psr\Log\LoggerInterface|callable $channel
     *
     * @return void
     */
    public function addChannel(string $channelName, $channel) : void
    {
        if (! strlen($channelName)) {
            throw new InvalidArgumentException(
                'The `channelName` should be non-empty string'
            );
        }

        if (isset($this->channels[ $channelName ])
            || isset($this->channelFactories[ $channelName ])
        ) {
            throw new RuntimeException(
                'Channel is already exists by name: ' . $channelName
            );
        }

        $isFactory = false;
        if (! ( is_a($channel, $interface = static::PSR_LOGGER_INTERFACE)
            || is_a($channel, static::class)
            || ( $isFactory = is_callable($channel) )
        )) {
            throw new InvalidArgumentException([
                'The `channel` should be callable or extends/implements one of: %s / %s',
                $channel,
                [ static::class, $interface ],
            ]);
        }

        $isFactory
            ? $this->channelFactories[ $channelName ] = $channel
            : $this->channels[ $channelName ] = $channel;
    }


    /**
     * @param null|string $channelName
     *
     * @return null|object|static|\Psr\Log\LoggerInterface
     */
    public function selectChannel(?string $channelName) : ?object
    {
        if (null !== $channelName) {
            $channel = $this->getChannel($channelName);
        }

        return $this->channel = $channel ?? null;
    }


    /**
     * @param string $channelName
     *
     * @return static|\Psr\Log\LoggerInterface
     */
    public function resolveChannel(string $channelName) : object
    {
        if (! isset($this->channels[ $channelName ])) {
            $factory = $this->channelFactories[ $channelName ] ?? null;

            if (! $factory) {
                throw new RuntimeException(
                    'Unknown channel: ' . $channelName
                );
            }

            $channel = $factory($this);

            if (! ( is_a($channel, $interface = static::PSR_LOGGER_INTERFACE)
                || is_a($channel, static::class)
            )) {
                throw new RuntimeException([
                    'The `channel` should extends/implements one of: %s / %s',
                    $channel,
                    [ static::class, $interface ],
                ]);
            }

            $this->channels[ $channelName ] = $channel;

            unset($this->channelFactories[ $channelName ]);
        }

        return $this->channels[ $channelName ];
    }


    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }


    /**
     * @param mixed      $level
     * @param mixed      $message
     * @param null|array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = null)
    {
        $context = $context ?? [];

        if (is_string($message) && ( '' !== $message )) {
            $this->channel->{$level}($message, $context);

        } elseif (null !== $this->getArr()->filterList($message)) {
            // @gzhegow > support exception allows passing array with arguments like `sprintf` does, also it prints variable types is needed
            $decorator = new Exception($message);

            $this->channel->{$level}($decorator->getMessage(), $context);

        } else {
            $theDebug = $this->getDebug();

            $this->channel->{$level}(
                $theDebug->printR(
                    $theDebug->args($message), 1
                ),
                $context
            );
        }
    }


    /**
     * @return ILogger
     */
    public static function getInstance() : ILogger
    {
        return SupportFactory::getInstance()->getLogger();
    }
}