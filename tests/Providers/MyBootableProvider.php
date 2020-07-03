<?php

namespace Tests\Providers;

use Tests\Services\MyAService;
use Tests\Services\MyServiceInterface;
use Gzhegow\Di\BootableProvider;

/**
 * Class MyBootableProvider
 */
class MyBootableProvider extends BootableProvider
{
	/**
	 * @return MyServiceInterface
	 */
	protected function getMyService() : MyServiceInterface
	{
		return $this->di->getOrFail(MyServiceInterface::class);
	}


	/**
	 * @return void
	 */
	public function register() : void
	{
		$this->di->bind(MyServiceInterface::class, MyAService::class);
	}

	/**
	 * @return void
	 */
	public function boot() : void
	{
		// will be done on $di->boot() method was called

		$testService = $this->getMyService();
		$testService::setStaticOption(1);
		$testService->setDynamicOption(2);
	}
}