<?php

namespace Gzhegow\Di\Tests\Providers;

use Gzhegow\Di\Provider;
use Gzhegow\Di\Tests\Services\MyAService;
use Gzhegow\Di\Tests\Services\MyBService;
use Gzhegow\Di\Tests\Services\MyServiceAInterface;
use Gzhegow\Di\Tests\Services\MyServiceBInterface;
use Gzhegow\Di\Tests\Services\MyServiceBClosureInterface;
use Gzhegow\Di\Tests\Services\MyServiceBDelegateInterface;

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

		$this->di->bind(MyServiceBInterface::class, MyBService::class);
		$this->di->bindShared(MyServiceBDelegateInterface::class, MyBService::class);
		$this->di->bindShared(MyServiceBClosureInterface::class, function () {
			return new MyBService(
				$this->di->get(MyServiceAInterface::class)
			);
		});
	}
}