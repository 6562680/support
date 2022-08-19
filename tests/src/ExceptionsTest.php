<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XPhp;
use Gzhegow\Support\IPhp;
use Gzhegow\Support\XDebug;
use Gzhegow\Support\IDebug;
use Gzhegow\Support\XFilter;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\Exceptions\Exception;
use Gzhegow\Support\Exceptions\LogicException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class ExceptionsTest extends AbstractTestCase
{
    public function getDebug() : IDebug
    {
        return XDebug::getInstance();
    }

    public function getFilter() : IFilter
    {
        return XFilter::getInstance();
    }

    public function getPhp() : IPhp
    {
        return XPhp::getInstance();
    }


    public function testFilter()
    {
        $this->assertException(InvalidArgumentException::class, function () {
            $this->getFilter()
                ->assertWordval('');
        });

        $this->assertException(InvalidArgumentException::class, function () {
            $this->getFilter()
                ->assert([ 'Hello, %s', 'World' ])
                ->assertWordval('');
        });

        $this->assertException(RuntimeException::class, function () {
            $this->getFilter()
                ->assert(new RuntimeException([ 'Hello, %s', 'World' ]))
                ->assertWordval('');
        });
    }


    public function testException()
    {
        $this->expectException(Exception::class);

        try {
            throw $e = new Exception($payloadExpected = [ $messageExpected = 'hello', [ 'world' ] ]);
        }
        catch ( Exception $e ) {
            $codeExpected = -1;

            static::assertEquals($messageExpected, $e->getMessage());
            static::assertEquals($codeExpected, $e->getCode());
            static::assertEquals($payloadExpected, $e->getPayload());

            throw $e;
        }
    }

    public function testLogicException()
    {
        $this->expectException(LogicException::class);

        try {
            throw $e = new LogicException($payloadExpected = [ $messageExpected = 'hello', [ 'world' ] ]);
        }
        catch ( LogicException $e ) {
            $codeExpected = -1;

            static::assertEquals($messageExpected, $e->getMessage());
            static::assertEquals($codeExpected, $e->getCode());
            static::assertEquals($payloadExpected, $e->getPayload());

            throw $e;
        }
    }

    public function testRuntimeException()
    {
        $this->expectException(RuntimeException::class);

        try {
            throw $e = new RuntimeException($payloadExpected = [ $messageExpected = 'hello', [ 'world' ] ]);
        }
        catch ( LogicException $e ) {
            $codeExpected = -1;

            static::assertEquals($messageExpected, $e->getMessage());
            static::assertEquals($codeExpected, $e->getCode());
            static::assertEquals($payloadExpected, $e->getPayload());

            throw $e;
        }
    }


    public function testExceptionPlaceholders()
    {
        $this->expectException(Exception::class);

        try {
            throw $e = new Exception($payloadExpected = [
                $messageOriginal = 'hello: %d, %.1F, %s',
                1,
                1.1,
                'hello',
                'world',
            ]);
        }
        catch ( Exception $e ) {
            static::assertEquals('hello: 1, 1.1, hello', $e->getMessage());
            static::assertEquals($messageOriginal, $e->getTextOriginal());
            static::assertEquals($payloadExpected, $e->getPayload());

            throw $e;
        }
    }

    public function testExceptionNesting()
    {
        $debug = $this->getDebug();

        $this->expectException(Exception::class);

        $e = new Exception([
            'hello: %d',
            1,
            'world',
        ]);

        $ee = new Exception([
            'hello: %d, %.1F',
            1,
            1.1,
            'world',
        ], null, $e);

        $eee = new Exception($expectedPayload = [
            'hello: %d, %.1F, %s',
            1,
            1.1,
            'hello',
            'world',
        ], null, $ee);

        try {
            throw $eee;
        }
        catch ( Exception $e ) {
            static::assertEquals('hello: 1, 1.1, hello', $e->getMessage());
            static::assertEquals($expectedPayload, $e->getPayload());

            static::assertEquals([
                "Gzhegow\Support\Exceptions\Exception" => [
                    0 => "hello: 1, 1.1, hello",
                    1 => "hello: 1, 1.1",
                    2 => "hello: 1",
                ],
            ], $debug->extractThrowableMessages($e));

            throw $e;
        }
    }
}