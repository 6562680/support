<?php

namespace Tests\Providers;

use Tests\Services\MyAService;
use Tests\Services\MyServiceInterface;
use Gzhegow\Di\AbstractProvider;

/**
 * Class MyProvider
 */
class MyProvider extends AbstractProvider
{
	/**
	 * @return void
	 */
	public function register() : void
	{
		$this->di->bind(MyServiceInterface::class, MyAService::class);
	}
}