<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Exceptions\Exception;
use Gzhegow\Support\Exceptions\LogicException;
use Gzhegow\Support\Exceptions\RuntimeException;


Class ExceptionTest extends AbstractTestCase
{
	public function testException()
	{
		$this->expectException(Exception::class);

		try {
			throw $e = new Exception('hello', [ 'world' ]);
		}
		catch ( Exception $e ) {
			static::assertEquals(str_replace('\\', '.', get_class($e)), $e->getName());
			static::assertEquals('hello', $e->getMsg());
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
			static::assertEquals('hello', $e->getMsg());
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
			static::assertEquals('hello', $e->getMsg());
			static::assertEquals([ 'world' ], $e->getPayload());

			throw $e;
		}
	}
}
