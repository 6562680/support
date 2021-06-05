<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Php;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Exceptions\Exception;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\LogicException;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


class ExceptionTest extends AbstractTestCase
{
    public function getFilter() : Filter
    {
        return ( new SupportFactory() )->newFilter();
    }

    public function getPhp() : Php
    {
        return ( new SupportFactory() )->newPhp();
    }


    public function testFilter()
    {
        $this->assertException(InvalidArgumentException::class, function () {
            $filter = $this->getFilter();
            $filter->assert()->assertPositive(-1);
        });

        $this->assertException(InvalidArgumentException::class, function () {
            $filter = $this->getFilter();
            $filter->assert([ 'Hello, %s', 'World' ])
                ->assertPositive(-1);
        });

        $this->assertException(RuntimeException::class, function () {
            $filter = $this->getFilter();
            $filter->assert(new RuntimeException([ 'Hello, %s', 'World' ]))
                ->assertPositive(-1);
        });
    }


    public function testException()
    {
        $this->expectException(Exception::class);

        try {
            throw $e = new Exception('hello', [ 'world' ]);
        }
        catch ( Exception $e ) {
            static::assertEquals(str_replace('\\', '.', get_class($e)), $e->getName());
            static::assertEquals('hello', $e->getMessage());
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
            static::assertEquals(str_replace('\\', '.', get_class($e)), $e->getName());
            static::assertEquals('hello', $e->getMessage());
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
            static::assertEquals(str_replace('\\', '.', get_class($e)), $e->getName());
            static::assertEquals('hello', $e->getMessage());
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
        $php = $this->getPhp();

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
            ], $php->throwableMessages($e));

            throw $e;
        }
    }
}
