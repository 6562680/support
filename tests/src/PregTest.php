<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Preg;
use Gzhegow\Support\Type;

Class PregTest extends AbstractTestCase
{
	public function testNew()
	{
		$preg = new Preg(new Type());

		$this->assertEquals('/hello(world)+/', $preg->new([ 'hello', '(', [ 'world' ], ')+' ]));
		$this->assertEquals('/\//', $preg->new([ [ '/' ] ]));
	}
}