<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ILogger;
use Gzhegow\Support\XLogger;
use Monolog\Handler\NullHandler;
use Monolog\Logger as MonologLogger;
use Gzhegow\Support\Exceptions\RuntimeException;


class LoggerTest extends AbstractTestCase
{
    protected function getLogger() : ILogger
    {
        return XLogger::getInstance();
    }


    public function testLogger()
    {
        $theLogger = $this->getLogger();

        $theLogger->addChannel($channelName1 = 'channel', $channel1 = new MonologLogger($channelName1, [ new NullHandler() ]));
        $theLogger->addChannel($channelName2 = 'channel2', $channel2 = function () use ($channel1) {
            return $channel1;
        });
        $theLogger->addChannel($channelName3 = 'channel3', $channel3 = function () {
            return new \StdClass();
        });

        $this->assertEquals([
            'channel' => $channel1,
        ], $theLogger->getChannels());

        $this->assertEquals([
            'channel2' => $channel2,
            'channel3' => $channel3,
        ], $theLogger->getChannelFactories());

        $this->assertException(RuntimeException::class, function () use ($theLogger, $channelName1) {
            $theLogger->addChannel($channelName1, function () { });
        });

        $this->assertEquals($channel1, $theLogger->getChannel($channelName2));

        $this->assertException(RuntimeException::class, function () use ($theLogger, $channelName3) {
            $theLogger->getChannel($channelName3);
        });
    }
}