<?php

namespace Tests\Providers;

use Gzhegow\Di\Provider;
use Tests\Services\MyAService;
use Tests\Services\MyBService;
use Tests\Services\MyServiceAInterface;
use Tests\Services\MyServiceBInterface;
use Tests\Services\MyServiceBClosureInterface;

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

		$this->di->bindShared(MyServiceBClosureInterface::class, function () {
			return new MyBService(
				$this->di->get(MyServiceAInterface::class)
			);
		});
	}
}