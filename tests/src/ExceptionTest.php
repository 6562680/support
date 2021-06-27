<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Php;
use Gzhegow\Support\Debug;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Exceptions\Exception;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\LogicException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Tests\Exceptions\MyException;
use Gzhegow\Support\Tests\Exceptions\MyChildException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class ExceptionTest extends AbstractTestCase
{
    public function getDebug() : Debug
    {
        return SupportFactory::getInstance()->newDebug();
    }

    public function getFilter() : Filter
    {
        return SupportFactory::getInstance()->newFilter();
    }

    public function getPhp() : Php
    {
        return SupportFactory::getInstance()->newPhp();
    }


    public function testFilter()
    {
        $this->assertException(InvalidArgumentException::class, function () {
            $this->getFilter()
                ->assert()
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
            throw $e = new Exception('hello', [ 'world' ]);
        }
        catch ( Exception $e ) {
            $nameExpected = str_replace('\\', '.', get_class($e));
            $codeExpected = -1;

            static::assertEquals('hello', $e->getMessage());
            static::assertEquals($codeExpected, $e->getCode());
            static::assertEquals($nameExpected, $e->getName());
            static::assertEquals([ 'world' ], $e->getPayload());

            throw $e;
        }
    }

    public function testLogicException()
    {
        $this->expectException(LogicException::class);

        try {
            throw $e = new LogicException('hello', [ 'world' ]);
        }
        catch ( LogicException $e ) {
            $nameExpected = str_replace('\\', '.', get_class($e));
            $codeExpected = -1;

            static::assertEquals('hello', $e->getMessage());
            static::assertEquals($codeExpected, $e->getCode());
            static::assertEquals($nameExpected, $e->getName());
            static::assertEquals([ 'world' ], $e->getPayload());

            throw $e;
        }
    }

    public function testRuntimeException()
    {
        $this->expectException(RuntimeException::class);

        try {
            throw $e = new RuntimeException('hello', [ 'world' ]);
        }
        catch ( RuntimeException $e ) {
            $nameExpected = str_replace('\\', '.', get_class($e));
            $codeExpected = -1;

            static::assertEquals('hello', $e->getMessage());
            static::assertEquals($codeExpected, $e->getCode());
            static::assertEquals($nameExpected, $e->getName());
            static::assertEquals([ 'world' ], $e->getPayload());

            throw $e;
        }
    }


    public function testMyException()
    {
        $this->expectException(Exception::class);

        try {
            throw $e = new MyException('hello', [ 'world' ]);
        }
        catch ( Exception $e ) {
            $nameExpected = str_replace('\\', '.', get_class($e));
            $codeExpected = 1;

            static::assertEquals('hello', $e->getMessage());
            static::assertEquals($codeExpected, $e->getCode());
            static::assertEquals($nameExpected, $e->getName());
            static::assertEquals([ 'world' ], $e->getPayload());

            throw $e;
        }
    }

    public function testMyChildException()
    {
        $this->expectException(Exception::class);

        try {
            throw $e = new MyChildException('hello', [ 'world' ]);
        }
        catch ( Exception $e ) {
            $nameExpected = str_replace('\\', '.', get_class($e));
            $codeExpected = 2;

            static::assertEquals('hello', $e->getMessage());
            static::assertEquals($codeExpected, $e->getCode());
            static::assertEquals($nameExpected, $e->getName());
            static::assertEquals([ 'world' ], $e->getPayload());

            throw $e;
        }
    }


    public function testExceptionPlaceholders()
    {
        $this->expectException(Exception::class);

        try {
            throw $e = new Exception([ 'hello: %d, %.1F, %s', 1, 1.1, 'hello' ], [ 'world' ]);
        }
        catch ( Exception $e ) {
            static::assertEquals(str_replace('\\', '.', get_class($e)), $e->getName());
            static::assertEquals('hello: 1, 1.1, hello', $e->getMessage());
            static::assertEquals([ 'world' ], $e->getPayload());

            throw $e;
        }
    }

    public function testExceptionNesting()
    {
        $debug = $this->getDebug();

        $this->expectException(Exception::class);

        try {
            $e = new Exception([ 'hello: %d', 1 ], [ 'world' ]);
            $ee = new Exception([ 'hello: %d, %.1F', 1, 1.1 ], [ 'world' ], $e);
            throw new Exception([ 'hello: %d, %.1F, %s', 1, 1.1, 'hello' ], [ 'world' ], $ee);
        }
        catch ( Exception $e ) {
            static::assertEquals(str_replace('\\', '.', get_class($e)), $e->getName());
            static::assertEquals('hello: 1, 1.1, hello', $e->getMessage());
            static::assertEquals([ 'world' ], $e->getPayload());

            static::assertEquals([
                "Gzhegow\Support\Exceptions\Exception" => [
                    0 => "hello: 1, 1.1, hello",
                    1 => "hello: 1, 1.1",
                    2 => "hello: 1",
                ],
            ], $debug->throwableMessages($e));

            throw $e;
        }
    }


    public function testExceptionPipeline()
    {
        $self = null;
        $inc = 0;

        $pipe = function ($exception, $carry) use (&$self, &$inc) {
            $this->assertEquals($self, $exception);
            $this->assertEquals($inc, $carry);

            return ++$inc;
        };

        $parent = new Exception('Parent');
        $self = new Exception('Child', $payload = new \StdClass(), $pipe, $parent);

        try {
            throw $self;
        }
        catch ( Exception $e ) {
            $result = $self->process(0);
        }

        $this->assertEquals(1, $inc);
        $this->assertEquals(1, $result);
        $this->assertEquals($parent, $e->getPrevious());

        $self = new Exception('Child', $payload = new \StdClass(), $parent, $pipe);

        try {
            throw $self;
        }
        catch ( Exception $e ) {
            $result = $self->process($inc);
        }

        $this->assertEquals(2, $inc);
        $this->assertEquals(2, $result);
        $this->assertEquals($parent, $e->getPrevious());
    }

    public function testBadExceptionPipeline()
    {
        $this->assertException(\InvalidArgumentException::class, function () {
            $previous = new Exception('Parent');

            throw new Exception('Child', $payload = new \StdClass(),
                $previous,
                $previous
            );
        });
    }
}
