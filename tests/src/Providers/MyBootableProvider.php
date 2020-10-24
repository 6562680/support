<?php

namespace Gzhegow\Di\Tests\Providers;

use Gzhegow\Di\BootableProvider;
use Gzhegow\Di\Tests\Services\MyAService;
use Gzhegow\Di\Tests\Services\MyServiceAInterface;

/**
 * Class MyBootableProvider
 */
class MyBootableProvider extends BootableProvider
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
	 * @return array
	 */
	public function sync() : array
	{
		return [
			// copy
			__DIR__ . '/../../../config/tests/src/file.conf' => __DIR__ . '/../../../config/tests/dest/file.conf',
			__DIR__ . '/../../../config/tests/src/dir'       => __DIR__ . '/../../../config/tests/dest/dir',

			// require
			__DIR__ . '/../../../config/tests/src/bootstrap.php',
		];
	}

	/**
	 * @return void
	 */
	public function boot() : void
	{
		// will be done on $di->boot() method was called

		$myAService = $this->getMyAService();

		$myAService::setStaticOption(1);
		$myAService->setDynamicOption(2);
	}
}