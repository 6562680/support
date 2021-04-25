<?php

namespace Gzhegow\Di\Tests\Providers;

use Gzhegow\Di\Domain\Provider\Provider;
use Gzhegow\Di\Tests\Services\MyAService;
use Gzhegow\Di\Tests\Services\MyServiceAInterface;

/**
 * Class MyProvider
 */
class MyProvider extends Provider
{
	/**
	 * @return void
	 */
	public function register() : void
	{
		$this->di->bind(MyServiceAInterface::class, MyAService::class);
	}
}
