<?php

namespace Tests;

use Gzhegow\Di\Di;
use Tests\Services\MyAService;
use Tests\Services\MyCService;
use PHPUnit\Framework\TestCase;
use Tests\Providers\MyProvider;
use Tests\Services\MyLoopService;
use Tests\Services\MyLoopAService;
use Tests\Services\MyServiceInterface;
use Tests\Providers\MyBootableProvider;
use Tests\Providers\MyDeferableProvider;
use Gzhegow\Di\Exceptions\Runtime\AutowireLoopException;

/**
 * Class Test
 */
class Test extends TestCase
{
	/**
	 * @return void
	 */
	public function testDecorate()
	{
		/** @var MyServiceInterface $testService */

		$case = $this;

		$di = new Di();
		$di->bind(MyServiceInterface::class, MyAService::class);

		$decorationService = $testService = $di->getOrFail(MyServiceInterface::class);

		$di->call($testService, function (MyServiceInterface $testService) use ($case, $decorationService) {
			$case->assertEquals($decorationService, $this);
			$case->assertEquals($decorationService, $testService);

			// dynamicOption is protected, we used dynamic this
			// to allow make properties readonly filled with factory/builder classes
			$testService = $this;
			$testService->dynamicOption = 123;
		});

		$this->assertEquals(123, $testService->getDynamicOption());
	}


	/**
	 * @return void
	 */
	public function testPass()
	{
		/** @var MyServiceInterface $testService */

		$case = $this;

		$di = new Di();
		$di->bind(MyServiceInterface::class, MyAService::class);

		$decorationService = $testService = $di->getOrFail(MyServiceInterface::class);

		$data = [
			MyServiceInterface::class => $decorationService,

			'$var2' => 'world',

			0 => 'hello',
		];

		$di->handle(function ($var, $var2, $var3 = null, MyServiceInterface $testService = null) use ($case, $decorationService) {
			$case->assertEquals([
				0 => 'hello',
				1 => 'world',
				2 => null,
				3 => $decorationService,
			], func_get_args());
		}, $data);
	}

	/**
	 * @return void
	 */
	public function testPassString()
	{
		/** @var MyServiceInterface $testService */

		$case = $this;

		$di = new Di();
		$di->bind(MyServiceInterface::class, MyAService::class);

		$decorationService = $testService = $di->getOrFail(MyServiceInterface::class);

		$data = [
			MyServiceInterface::class => $decorationService,
		];

		$di->handle(function () use ($case, $decorationService) {
			$case->assertEquals([ $decorationService ], func_get_args());
		}, $data);
	}


	/**
	 * @return void
	 */
	public function testNormal()
	{
		/** @var MyServiceInterface $testService */

		$di = new Di();
		$di->registerProvider(MyProvider::class);

		$testService = $di->getOrFail(MyServiceInterface::class);

		$this->assertEquals(null, $testService->getStaticOption());
	}

	/**
	 * @return void
	 */
	public function testBootable()
	{
		/** @var MyServiceInterface $testService */

		$di = new Di();
		$di->registerProvider(MyBootableProvider::class);

		$testService = $di->getOrFail(MyServiceInterface::class);

		$this->assertEquals(null, $testService->getDynamicOption()); // registered, not booted
		$this->assertEquals(null, $testService->getStaticOption());  // registered, not booted

		$di->boot();

		$this->assertEquals(null, $testService->getDynamicOption()); // not a singleton
		$this->assertEquals(1, $testService->getStaticOption());     // shared for all classes
	}

	/**
	 * @return void
	 */
	public function testDeferable()
	{
		/** @var MyServiceInterface $testService */

		$di = new Di();
		$di->registerProvider(MyDeferableProvider::class);

		$testService = $di->getOrFail(MyServiceInterface::class);

		$this->assertEquals(null, $testService->getDynamicOption());
		$this->assertEquals(1, $testService->getStaticOption()); // booted on create, so - already booted

		$di->boot(); // nothing happens, because of deferable boot

		$this->assertEquals(null, $testService->getDynamicOption());
		$this->assertEquals(1, $testService->getStaticOption()); // same result
	}


	/**
	 * @return void
	 */
	public function testSame()
	{
		// both of dependent services required same service, its normal behavior

		$di = new Di();
		$instance = $di->getOrFail(MyCService::class);

		$this->assertInstanceOf(MyCService::class, $instance);
	}


	/**
	 * @return void
	 */
	public function testBadLoop()
	{
		// service requires itself
		$this->expectException(AutowireLoopException::class);

		$di = new Di();
		$di->getOrFail(MyLoopService::class);
	}

	/**
	 * @return void
	 */
	public function testBadLoopAB()
	{
		// service A requires B, and service B requires service A
		$this->expectException(AutowireLoopException::class);

		$di = new Di();
		$di->getOrFail(MyLoopAService::class);
	}
}