<?php

namespace Tests\Providers;

use Gzhegow\Di\Provider;
use Tests\Services\MyAService;
use Tests\Services\MyBService;
use Tests\Services\MyServiceAInterface;
use Tests\Services\MyServiceBInterface;

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
		$this->di->bind(MyServiceBInterface::class, function () {
			return new MyBService(
				$this->di->get(MyServiceAInterface::class)
			);
		});
	}
}