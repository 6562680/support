<?php

namespace Tests\Providers;

use Tests\Services\MyAService;
use Tests\Services\MyServiceInterface;
use Gzhegow\Di\DeferableProvider;

/**
 * Class MyDeferableProvider
 */
class MyDeferableProvider extends DeferableProvider
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
		// will be done when you try to get element from container

		$testService = $this->getMyService();
		$testService::setStaticOption(1);
		$testService->setDynamicOption(2);
	}


	/**
	 * @return array
	 */
	public function provides() : array
	{
		return [
			MyServiceInterface::class,
		];
	}
}