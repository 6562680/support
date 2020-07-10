<?php

namespace Tests\Providers;

use Gzhegow\Di\Provider;
use Tests\Services\MyAService;
use Tests\Services\MyServiceInterface;

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
		$this->di->bind(MyServiceInterface::class, MyAService::class);
	}
}