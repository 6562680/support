<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Preg;
use Gzhegow\Support\Type;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

Class PregTest extends AbstractTestCase
{
	public function testNew()
	{
		$preg = new Preg(new Type());

		$this->assertEquals('/\//', $preg->new([ [ '/' ] ]));
		$this->assertEquals('/hello(world)+/', $preg->new([ 'hello', '(', [ 'world' ], ')+' ]));
	}


	public function testNewBad()
	{
		$this->expectException(InvalidArgumentException::class);

		$preg = new Preg(new Type());

		$preg->new([ '/hello/iu' ]);
	}
}