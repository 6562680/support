<?php

namespace Tests\Providers;

use Tests\Services\MyAService;
use Gzhegow\Di\DeferableProvider;
use Tests\Services\MyServiceAInterface;

/**
 * Class MyDeferableProvider
 */
class MyDeferableProvider extends DeferableProvider
{
	/**
	 * @return MyServiceAInterface
	 */
	protected function getMyAService() : MyServiceAInterface
	{
		return $this->di->getOrFail(MyServiceAInterface::class);
	}


	/**
	 * @return void
	 */
	public function register() : void
	{
		$this->di->bind(MyServiceAInterface::class, MyAService::class);
	}

	/**
	 * @return void
	 */
	public function boot() : void
	{
		// will be done when you try to get element from container

		$myAService = $this->getMyAService();

		$myAService::setStaticOption(1);
		$myAService->setDynamicOption(2);
	}


	/**
	 * @return array
	 */
	public function provides() : array
	{
		return [
			MyServiceAInterface::class,
		];
	}
}