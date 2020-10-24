<?php

namespace Gzhegow\Di\Tests;

use Gzhegow\Di\Di;
use Gzhegow\Di\Tests\Services\MyAService;
use Gzhegow\Di\Tests\Services\MyCService;
use Gzhegow\Di\Tests\Services\MyBService;
use Gzhegow\Di\Tests\Providers\MyProvider;
use Gzhegow\Di\Tests\Services\MyLoopService;
use Gzhegow\Di\Tests\Services\MyLoopAService;
use Gzhegow\Di\Tests\Services\MyServiceAInterface;
use Gzhegow\Di\Tests\Providers\MyBootableProvider;
use Gzhegow\Di\Tests\Services\MyServiceBInterface;
use Gzhegow\Di\Tests\Providers\MyDeferableProvider;
use Gzhegow\Di\Tests\Services\MyServiceBClosureInterface;
use Gzhegow\Di\Exceptions\Runtime\Error\AutowireLoopError;

/**
 * Class DiTest
 */
class DiTest extends AbstractTestCase
{
	/**
	 * @return void
	 */
	public function testDecorate()
	{
		/** @var MyServiceAInterface $myAService */

		$case = $this;

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$decorationService = $myAService = $di->getOrFail(MyServiceAInterface::class);

		$di->call($myAService, function (MyServiceAInterface $myAService) use ($case, $decorationService) {
			$case->assertEquals($decorationService, $this);
			$case->assertEquals($decorationService, $myAService);

			// dynamicOption is protected, we used dynamic this
			// to allow make properties readonly filled with factory/builder classes
			$myAService = $this;
			$myAService->dynamicOption = 123;
		});

		$this->assertEquals(123, $myAService->getDynamicOption());
	}


	/**
	 * @return void
	 */
	public function testPass()
	{
		/** @var MyServiceAInterface $testService */

		$case = $this;

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$decorationService = $testService = $di->getOrFail(MyServiceAInterface::class);

		$data = [
			MyServiceAInterface::class => $decorationService,

			'$var2' => 'world',
			'$var5' => 'foo',

			0 => 'hello',
		];

		$di->handle(function (
			$var,
			$var2,
			$var3 = 'bar',
			$var4 = null,
			MyServiceAInterface $service = null
		) use (
			$case,
			$decorationService
		) {
			$case->assertEquals([
				0 => 'hello', // passed as int argument without ordering
				1 => 'world', // passed as string argument
				2 => 'bar', // default value
				3 => null, // default null
				4 => $decorationService, // created by interface

				// 5 => 'foo', // ignored because no param match
			], func_get_args());

			$case->assertEquals($decorationService, $service);
		}, $data);
	}

	/**
	 * @return void
	 */
	public function testPassVariadic()
	{
		/** @var MyServiceAInterface $testService */

		$case = $this;

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$data = [
			0        => null,
			2        => null,
			'$world' => 'world1',
			'$args'  => [],
		];

		$di->handle(function ($hello, $world = null, ...$args) use ($case) {
			$case->assertEquals([
				0 => null, // passed by name
				1 => 'world1', // passed by name
				// 2 => [], // variadic parameters becomes [] by default, even if null or empty array is passed
			], func_get_args());
		}, $data);
	}

	/**
	 * @return void
	 */
	public function testPassNoArguments()
	{
		/** @var MyServiceAInterface $testService */

		$case = $this;

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$service = $di->getOrFail(MyServiceAInterface::class);

		$data = [
			MyServiceAInterface::class => $service, // will be ignored - no arguments match
		];

		$di->handle(function () use ($case, $service) {
			$case->assertEquals([], func_get_args());
		}, $data);
	}

	/**
	 * @return void
	 */
	public function testPassUnexpectedOrder()
	{
		/** @var MyServiceAInterface $testService */

		$case = $this;

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$myAService = $di->getOrFail(MyServiceAInterface::class);

		$data = [
			'$var2' => '456',
			0       => '123',
		];

		$di->handle(function ($var1, MyServiceAInterface $myService, $var2) use ($case, $myAService) {
			$case->assertEquals([
				0 => '123',
				1 => $myAService, // array was expanded with autowired dependency
				2 => '456',
			], func_get_args());
		}, $data);
	}


	/**
	 * @return void
	 */
	public function testNormal()
	{
		/** @var MyServiceAInterface $myAService */

		$di = new Di();
		$di->registerProvider(MyProvider::class);

		$myAService = $di->getOrFail(MyServiceAInterface::class);
		$myBService = $di->getOrFail(MyServiceBInterface::class);

		$this->assertInstanceOf(MyAService::class, $myAService);
		$this->assertInstanceOf(MyBService::class, $myBService);

		$this->assertEquals(null, $myAService->getStaticOption());
	}

	/**
	 * @return void
	 */
	public function testBootable()
	{
		/** @var MyServiceAInterface $myAService */

		// drop old copy
		$it = new \RecursiveDirectoryIterator($dir = __DIR__ . '/../../config/tests/dest', \RecursiveDirectoryIterator::SKIP_DOTS);
		$iit = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
		foreach ( $iit as $file ) {
			$todo = ( $file->isDir()
				? 'rmdir'
				: 'unlink' );
			$todo($file->getRealPath());
		}
		rmdir($dir);

		$di = new Di();
		$di->registerProvider(MyBootableProvider::class);

		$myAService = $di->getOrFail(MyServiceAInterface::class);

		$this->assertEquals(null, $myAService->getDynamicOption()); // registered, not booted
		$this->assertEquals(null, $myAService->getStaticOption());  // registered, not booted

		$di->boot();

		$this->assertEquals(null, $myAService->getDynamicOption()); // not a singleton
		$this->assertEquals(1, $myAService->getStaticOption());     // shared for all classes

		// require
		$this->assertEquals(BOOTSTRAP, true);

		// copy
		$this->assertFileExists(__DIR__ . '/../../config/tests/dest/file.conf');
		$this->assertFileExists(__DIR__ . '/../../config/tests/dest/dir/file.conf');
		$this->assertFileExists(__DIR__ . '/../../config/tests/dest/dir/dir/file.conf');
	}

	/**
	 * @return void
	 */
	public function testDeferable()
	{
		/** @var MyServiceAInterface $myAService */

		$di = new Di();
		$di->registerProvider(MyDeferableProvider::class);

		$myAService = $di->getOrFail(MyServiceAInterface::class);

		$this->assertEquals(null, $myAService->getDynamicOption());
		$this->assertEquals(1, $myAService->getStaticOption()); // booted on create, so - already booted

		$di->boot(); // nothing happens, because of deferable boot

		$this->assertEquals(null, $myAService->getDynamicOption());
		$this->assertEquals(1, $myAService->getStaticOption()); // same result
	}


	/**
	 * @return void
	 */
	public function testSharedClosure()
	{
		$di = new Di();
		$di->registerProvider(MyProvider::class);

		$myBClosureSharedService1 = $di->getOrFail(MyServiceBClosureInterface::class);
		$myBClosureSharedService2 = $di->getOrFail(MyServiceBClosureInterface::class);

		$this->assertEquals($myBClosureSharedService1, $myBClosureSharedService2);
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
	public function testBadLoopSame()
	{
		// service requires itself

		$this->expectException(AutowireLoopError::class);

		$di = new Di();
		$di->getOrFail(MyLoopService::class);
	}

	/**
	 * @return void
	 */
	public function testBadLoopAB()
	{
		// service A requires B, and service B requires service A

		$this->expectException(AutowireLoopError::class);

		$di = new Di();
		$di->getOrFail(MyLoopAService::class);
	}
}