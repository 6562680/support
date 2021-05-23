<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Php;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Exceptions\Exception;
use Gzhegow\Support\Exceptions\LogicException;
use Gzhegow\Support\Exceptions\RuntimeException;


class ExceptionTest extends AbstractTestCase
{
    public function getFilter() : Filter
    {
        return new Filter();
    }

    public function getPhp() : Php
    {
        return new Php(
            $this->getFilter()
        );
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
