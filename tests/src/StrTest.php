<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Str;

Class StrTest extends AbstractTestCase
{
	public function testSnake()
	{
		$str = new Str();

		static::assertEquals('helloworld', $str->snake('helloworld'));
		static::assertEquals('hello_world', $str->snake('HelloWorld'));
		static::assertEquals('hello_world', $str->snake('hello-world'));
		static::assertEquals('hello_world', $str->snake('hello_world'));
		static::assertEquals('hello_world', $str->snake('Hello-World'));
		static::assertEquals('hello_world', $str->snake('Hello World'));
		static::assertEquals('hello_world', $str->snake('Hello_World'));
		static::assertEquals('hello.world', $str->snake('hello.world'));
		static::assertEquals('hello._world', $str->snake('Hello.World'));
		static::assertEquals('helloworld.foo', $str->snake('helloworld.foo'));
		static::assertEquals('hello_world.foo', $str->snake('HelloWorld.foo'));
		static::assertEquals('hello_world.foo', $str->snake('hello world.foo'));
		static::assertEquals('hello_world.foo', $str->snake('hello-world.foo'));
		static::assertEquals('hello_world.foo', $str->snake('hello_world.foo'));
		static::assertEquals('hello_world.foo', $str->snake('Hello-World.foo'));
		static::assertEquals('hello_world.foo', $str->snake('Hello World.foo'));
		static::assertEquals('hello_world.foo', $str->snake('Hello_World.foo'));
		static::assertEquals('hello.world', $str->snake('hello.world', '.'));
		static::assertEquals('hello.world', $str->snake('Hello.World', '.'));
		static::assertEquals('helloworld.foo', $str->snake('helloworld.foo', '.'));
		static::assertEquals('hello.world.foo', $str->snake('HelloWorld.foo', '.'));
		static::assertEquals('hello.world.foo', $str->snake('hello world.foo', '.'));
		static::assertEquals('hello.world.foo', $str->snake('hello-world.foo', '.'));
		static::assertEquals('hello.world.foo', $str->snake('hello_world.foo', '.'));
		static::assertEquals('hello.world.foo', $str->snake('Hello-World.foo', '.'));
		static::assertEquals('hello.world.foo', $str->snake('Hello World.foo', '.'));
		static::assertEquals('hello.world.foo', $str->snake('Hello_World.foo', '.'));
	}

	public function testUsnake()
	{
		$str = new Str();

		static::assertEquals('Helloworld', $str->usnake('helloworld'));
		static::assertEquals('Hello_World', $str->usnake('HelloWorld'));
		static::assertEquals('Hello_World', $str->usnake('hello-world'));
		static::assertEquals('Hello_World', $str->usnake('hello_world'));
		static::assertEquals('Hello_World', $str->usnake('Hello-World'));
		static::assertEquals('Hello_World', $str->usnake('Hello World'));
		static::assertEquals('Hello_World', $str->usnake('Hello_World'));
		static::assertEquals('Hello.world', $str->usnake('hello.world'));
		static::assertEquals('Hello._World', $str->usnake('Hello.World'));
		static::assertEquals('Helloworld.foo', $str->usnake('helloworld.foo'));
		static::assertEquals('Hello_World.foo', $str->usnake('HelloWorld.foo'));
		static::assertEquals('Hello_World.foo', $str->usnake('hello world.foo'));
		static::assertEquals('Hello_World.foo', $str->usnake('hello-world.foo'));
		static::assertEquals('Hello_World.foo', $str->usnake('hello_world.foo'));
		static::assertEquals('Hello_World.foo', $str->usnake('Hello-World.foo'));
		static::assertEquals('Hello_World.foo', $str->usnake('Hello World.foo'));
		static::assertEquals('Hello_World.foo', $str->usnake('Hello_World.foo'));
		static::assertEquals('Hello.World', $str->usnake('hello.world', '.'));
		static::assertEquals('Hello.World', $str->usnake('Hello.World', '.'));
		static::assertEquals('Helloworld.Foo', $str->usnake('helloworld.foo', '.'));
		static::assertEquals('Hello.World.Foo', $str->usnake('HelloWorld.foo', '.'));
		static::assertEquals('Hello.World.Foo', $str->usnake('hello world.foo', '.'));
		static::assertEquals('Hello.World.Foo', $str->usnake('hello-world.foo', '.'));
		static::assertEquals('Hello.World.Foo', $str->usnake('hello_world.foo', '.'));
		static::assertEquals('Hello.World.Foo', $str->usnake('Hello-World.foo', '.'));
		static::assertEquals('Hello.World.Foo', $str->usnake('Hello World.foo', '.'));
		static::assertEquals('Hello.World.Foo', $str->usnake('Hello_World.foo', '.'));
	}

	public function testKebab()
	{
		$str = new Str();

		static::assertEquals('helloworld', $str->kebab('helloworld'));
		static::assertEquals('hello-world', $str->kebab('HelloWorld'));
		static::assertEquals('hello-world', $str->kebab('hello-world'));
		static::assertEquals('hello-world', $str->kebab('hello_world'));
		static::assertEquals('hello-world', $str->kebab('Hello-World'));
		static::assertEquals('hello-world', $str->kebab('Hello World'));
		static::assertEquals('hello-world', $str->kebab('Hello_World'));
		static::assertEquals('hello.world', $str->kebab('hello.world'));
		static::assertEquals('hello.-world', $str->kebab('Hello.World'));
		static::assertEquals('helloworld.foo', $str->kebab('helloworld.foo'));
		static::assertEquals('hello-world.foo', $str->kebab('HelloWorld.foo'));
		static::assertEquals('hello-world.foo', $str->kebab('hello world.foo'));
		static::assertEquals('hello-world.foo', $str->kebab('hello-world.foo'));
		static::assertEquals('hello-world.foo', $str->kebab('hello_world.foo'));
		static::assertEquals('hello-world.foo', $str->kebab('Hello-World.foo'));
		static::assertEquals('hello-world.foo', $str->kebab('Hello World.foo'));
		static::assertEquals('hello-world.foo', $str->kebab('Hello_World.foo'));
	}

	public function testUkebab()
	{
		$str = new Str();

		static::assertEquals('Helloworld', $str->ukebab('helloworld'));
		static::assertEquals('Hello-World', $str->ukebab('HelloWorld'));
		static::assertEquals('Hello-World', $str->ukebab('hello-world'));
		static::assertEquals('Hello-World', $str->ukebab('hello_world'));
		static::assertEquals('Hello-World', $str->ukebab('Hello-World'));
		static::assertEquals('Hello-World', $str->ukebab('Hello World'));
		static::assertEquals('Hello-World', $str->ukebab('Hello_World'));
		static::assertEquals('Hello.world', $str->ukebab('hello.world'));
		static::assertEquals('Hello.-World', $str->ukebab('Hello.World'));
		static::assertEquals('Helloworld.foo', $str->ukebab('helloworld.foo'));
		static::assertEquals('Hello-World.foo', $str->ukebab('HelloWorld.foo'));
		static::assertEquals('Hello-World.foo', $str->ukebab('hello world.foo'));
		static::assertEquals('Hello-World.foo', $str->ukebab('hello-world.foo'));
		static::assertEquals('Hello-World.foo', $str->ukebab('hello_world.foo'));
		static::assertEquals('Hello-World.foo', $str->ukebab('Hello-World.foo'));
		static::assertEquals('Hello-World.foo', $str->ukebab('Hello World.foo'));
		static::assertEquals('Hello-World.foo', $str->ukebab('Hello_World.foo'));
	}

	public function testPascal()
	{
		$str = new Str();

		static::assertEquals('Helloworld', $str->pascal('helloworld'));
		static::assertEquals('HelloWorld', $str->pascal('HelloWorld'));
		static::assertEquals('HelloWorld', $str->pascal('hello-world'));
		static::assertEquals('HelloWorld', $str->pascal('hello_world'));
		static::assertEquals('HelloWorld', $str->pascal('Hello-World'));
		static::assertEquals('HelloWorld', $str->pascal('Hello World'));
		static::assertEquals('HelloWorld', $str->pascal('Hello_World'));
		static::assertEquals('Hello.world', $str->pascal('hello.world'));
		static::assertEquals('Hello.World', $str->pascal('Hello.World'));
		static::assertEquals('Helloworld.foo', $str->pascal('helloworld.foo'));
		static::assertEquals('HelloWorld.foo', $str->pascal('HelloWorld.foo'));
		static::assertEquals('HelloWorld.foo', $str->pascal('hello world.foo'));
		static::assertEquals('HelloWorld.foo', $str->pascal('hello-world.foo'));
		static::assertEquals('HelloWorld.foo', $str->pascal('hello_world.foo'));
		static::assertEquals('HelloWorld.foo', $str->pascal('Hello-World.foo'));
		static::assertEquals('HelloWorld.foo', $str->pascal('Hello World.foo'));
		static::assertEquals('HelloWorld.foo', $str->pascal('Hello_World.foo'));
	}

	public function testCamel()
	{
		$str = new Str();

		static::assertEquals('helloworld', $str->camel('helloworld'));
		static::assertEquals('helloWorld', $str->camel('HelloWorld'));
		static::assertEquals('helloWorld', $str->camel('hello-world'));
		static::assertEquals('helloWorld', $str->camel('hello_world'));
		static::assertEquals('helloWorld', $str->camel('Hello-World'));
		static::assertEquals('helloWorld', $str->camel('Hello World'));
		static::assertEquals('helloWorld', $str->camel('Hello_World'));
		static::assertEquals('hello.world', $str->camel('hello.world'));
		static::assertEquals('hello.World', $str->camel('Hello.World'));
		static::assertEquals('helloworld.foo', $str->camel('helloworld.foo'));
		static::assertEquals('helloWorld.foo', $str->camel('HelloWorld.foo'));
		static::assertEquals('helloWorld.foo', $str->camel('hello world.foo'));
		static::assertEquals('helloWorld.foo', $str->camel('hello-world.foo'));
		static::assertEquals('helloWorld.foo', $str->camel('hello_world.foo'));
		static::assertEquals('helloWorld.foo', $str->camel('Hello-World.foo'));
		static::assertEquals('helloWorld.foo', $str->camel('Hello World.foo'));
		static::assertEquals('helloWorld.foo', $str->camel('Hello_World.foo'));
	}
}