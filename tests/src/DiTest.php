<?php

namespace Gzhegow\Di\Tests;

use Gzhegow\Di\Di;
use Gzhegow\Di\Loop;
use Gzhegow\Support\Fs;
use Gzhegow\Di\Tests\Services\MyAService;
use Gzhegow\Di\Tests\Providers\MyProvider;
use Gzhegow\Di\Tests\Services\Loop\MyLoopService;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegate;
use Gzhegow\Di\Tests\Services\Loop\MyLoopAService;
use Gzhegow\Di\Tests\Services\Loop\MyLoopBService;
use Gzhegow\Di\Tests\Services\MyServiceAInterface;
use Gzhegow\Di\Tests\Providers\MyBootableProvider;
use Gzhegow\Di\Tests\Services\MyBDependsOnAService;
use Gzhegow\Di\Tests\Providers\MyDeferableProvider;
use Gzhegow\Di\Tests\Services\MyCDependsOnABService;
use Gzhegow\Di\Tests\Services\MyDDependsOnAOrNullService;
use Gzhegow\Di\Exceptions\Runtime\Error\AutowireLoopError;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegateBService;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegateCService;
use Gzhegow\Di\Tests\Services\Loop\MyLoopServiceInterface;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegateAService;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegateDService;
use Gzhegow\Di\Tests\Services\Loop\MyLoopAServiceInterface;
use Gzhegow\Di\Tests\Services\Loop\MyLoopBServiceInterface;
use Gzhegow\Di\Tests\Services\Loop\MyLoopWithInterfaceService;
use Gzhegow\Di\Tests\Services\Loop\MyLoopBWithInterfaceService;
use Gzhegow\Di\Tests\Services\Loop\MyLoopAWithInterfaceService;
use Gzhegow\Di\Tests\Services\Closure\MyClosureServiceBInterface;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegateServiceBInterface;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegateServiceCInterface;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegateServiceDInterface;
use Gzhegow\Di\Tests\Services\Delegate\MyDelegateServiceDependsOnDelegates;

/**
 * Class DiTest
 */
class DiTest extends AbstractTestCase
{
	/**
	 * @return void
	 */
	public function testNormal()
	{
		$di = new Di();
		$di->bind(MyAService::class, MyAService::class);

		$myAService = $di->getOrFail(MyAService::class);

		$this->assertInstanceOf(MyAService::class, $myAService);
	}

	/**
	 * @return void
	 */
	public function testNobind()
	{
		$di = new Di();

		$myAService = $di->getOrFail(MyAService::class);

		$this->assertInstanceOf(MyAService::class, $myAService);
	}

	/**
	 * @return void
	 */
	public function testInterface()
	{
		/** @var MyServiceAInterface $myAService */

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$myAService = $di->getOrFail(MyServiceAInterface::class);

		$this->assertInstanceOf(MyAService::class, $myAService);
	}


	/**
	 * @return void
	 */
	public function testNullDependency()
	{
		/** @var MyServiceAInterface $myAService */

		$di = new Di();

		$myDService = $di->getOrFail(MyDDependsOnAOrNullService::class);

		$this->assertInstanceOf(MyDDependsOnAOrNullService::class, $myDService);

		// if you declare dependency with possible null - di ignores dependency and passes null
		$this->assertEquals(null, $myDService->myAService);
	}


	/**
	 * @return void
	 */
	public function testShared()
	{
		$di = new Di();
		$di->bindShared(MyAService::class, MyAService::class);

		$myAService1 = $di->getOrFail(MyAService::class);
		$myAService2 = $di->getOrFail(MyAService::class);

		$this->assertInstanceOf(MyAService::class, $myAService1);
		$this->assertInstanceOf(MyAService::class, $myAService2);
		$this->assertEquals($myAService1, $myAService2);
	}

	/**
	 * @return void
	 */
	public function testSharedClosure()
	{
		$di = new Di();
		$di->bindShared(MyClosureServiceBInterface::class, function (Loop $loop) {
			return new MyBDependsOnAService(
				$loop->get(MyAService::class)
			);
		});

		$myBClosureSharedService1 = $di->getOrFail(MyClosureServiceBInterface::class);
		$myBClosureSharedService2 = $di->getOrFail(MyClosureServiceBInterface::class);

		$this->assertEquals($myBClosureSharedService1, $myBClosureSharedService2);
	}


	/**
	 * @return void
	 */
	public function testDelegate()
	{
		/**
		 * @var MyDelegate $delegateB
		 * @var MyDelegate $delegateC
		 * @var MyDelegate $delegateD
		 */

		$di = new Di();

		$di->setDelegateClass(MyDelegate::class);

		$di->bind(MyDelegateServiceBInterface::class, MyDelegateBService::class);
		$di->bind(MyDelegateServiceCInterface::class, MyDelegateCService::class);
		$di->bind(MyDelegateServiceDInterface::class, MyDelegateDService::class);

		$myService = $di->getOrFail(MyDelegateServiceDependsOnDelegates::class);

		$delegateB = $myService->myBService;
		$delegateC = $myService->myCService;
		$delegateD = $myService->myDService;

		$this->assertInstanceOf(MyDelegate::class, $delegateB);
		$this->assertInstanceOf(MyDelegate::class, $delegateC);
		$this->assertInstanceOf(MyDelegate::class, $delegateD);

		$myAService = $myService->myAService;
		$delegateB->property; // __get
		$delegateC->property = 123; // __set
		$invokedDelegate = $delegateD();

		$this->assertInstanceOf(MyDelegateAService::class, $myAService);
		$this->assertInstanceOf(MyDelegateBService::class, $delegateB->getDelegate());
		$this->assertInstanceOf(MyDelegateCService::class, $delegateC->getDelegate());
		$this->assertInstanceOf(MyDelegateDService::class, $delegateD->getDelegate());

		$this->assertEquals($invokedDelegate, $delegateD->getDelegate());
	}


	/**
	 * @return void
	 */
	public function testProvider()
	{
		/** @var MyServiceAInterface $myAService */

		$di = new Di();
		$di->registerProvider(MyProvider::class);

		$this->assertInstanceOf(MyAService::class, $myAService = $di->getOrFail(MyServiceAInterface::class));
		$this->assertInstanceOf(MyBDependsOnAService::class, $di->getOrFail(MyBDependsOnAService::class));

		// boot wont launched
		$this->assertEquals(null, $myAService->getStaticOption());
	}

	/**
	 * @return void
	 */
	public function testProviderBootable()
	{
		/** @var MyServiceAInterface $myAService */

		$di = new Di();
		$di->registerProvider(MyBootableProvider::class);

		// remove old sync before test
		( new Fs() )->rmdir(__DIR__ . '/../config/dest', true);

		$myAService = $di->getOrFail(MyServiceAInterface::class);

		// bont still not launched
		$this->assertEquals(null, $myAService->getDynamicOption()); // registered, not booted
		$this->assertEquals(null, $myAService->getStaticOption());  // registered, not booted

		// triggering boot - that synces configs, resources and calls all providers boot method
		$di->boot();

		// singleton
		$this->assertEquals(1, $myAService->getStaticOption());

		// instance
		$this->assertEquals(null, $myAService->getDynamicOption());

		// check syncing is correct
		$this->assertFileExists(__DIR__ . '/../config/dest/file.conf');
		$this->assertFileExists(__DIR__ . '/../config/dest/dir/file.conf');
		$this->assertFileExists(__DIR__ . '/../config/dest/dir/dir/file.conf');
	}

	/**
	 * @return void
	 */
	public function testProviderDeferable()
	{
		/** @var MyServiceAInterface $myAService */

		$di = new Di();
		$di->registerProvider(MyDeferableProvider::class);

		$myAService = $di->getOrFail(MyServiceAInterface::class);

		// result
		$this->assertEquals(null, $myAService->getDynamicOption());
		$this->assertEquals(1, $myAService->getStaticOption()); // booted on create, so - already booted

		// nothing happens, because boot already done for this service on create
		$di->boot();

		// expected same result
		$this->assertEquals(null, $myAService->getDynamicOption());
		$this->assertEquals(1, $myAService->getStaticOption());
	}


	/**
	 * @return void
	 */
	public function testCall()
	{
		/** @var MyServiceAInterface $myAService */

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$decorationService = $myAService = $di->getOrFail(MyServiceAInterface::class);

		$testCase = $this;
		$di->call($myAService, function (MyServiceAInterface $myAService) use ($decorationService, $testCase) {
			$testCase->assertEquals($decorationService, $this);
			$testCase->assertEquals($decorationService, $myAService);

			// dynamicOption is protected, call() method changes bounded context
			// to allow make properties readonly filled with factory/builder classes without creating public setters/getters
			$myAService = $this;
			$myAService->dynamicOption = 123;
		});

		static::assertEquals(123, $myAService->getDynamicOption());
	}


	/**
	 * @return void
	 */
	public function testHandle()
	{
		/** @var MyServiceAInterface $testService */

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
		) use ($decorationService) {
			static::assertEquals($decorationService, $service);
			static::assertEquals([
				0 => 'hello', // passed as int argument without ordering
				1 => 'world', // passed as string argument
				2 => 'bar', // default value
				3 => null, // default null
				4 => $decorationService, // created by interface

				// 5 => 'foo', // ignored because no param match
			], func_get_args());
		}, $data);
	}

	/**
	 * @return void
	 */
	public function testHandleNoArguments()
	{
		/** @var MyServiceAInterface $testService */

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$service = $di->getOrFail(MyServiceAInterface::class);

		$data = [
			MyServiceAInterface::class => $service, // will be ignored - no arguments match
		];

		$di->handle(function () {
			static::assertEquals([], func_get_args());
		}, $data);
	}

	/**
	 * @return void
	 */
	public function testHandleVariadic()
	{
		/** @var MyServiceAInterface $testService */

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$data = [
			0        => null,
			2        => null,
			'$world' => 'world1',
			'$args'  => [],
		];

		$di->handle(function ($hello, $world = null, ...$args) {
			static::assertEquals([
				0 => null, // passed by name
				1 => 'world1', // passed by name

				// 2 => [], // variadic parameters becomes [] by default, even if null or empty array is passed
			], func_get_args());
		}, $data);
	}

	/**
	 * @return void
	 */
	public function testHandleUnexpectedOrder()
	{
		/** @var MyServiceAInterface $testService */

		$di = new Di();
		$di->bind(MyServiceAInterface::class, MyAService::class);

		$myAService = $di->getOrFail(MyServiceAInterface::class);

		$data = [
			'$var2' => '456',
			0       => '123',
		];

		$di->handle(function ($var1, MyServiceAInterface $myService, $var2) use ($myAService) {
			static::assertEquals([
				0 => '123',
				1 => $myAService, // array was expanded with autowired dependency
				2 => '456',
			], func_get_args());
		}, $data);
	}


	/**
	 * @return void
	 */
	public function testSame()
	{
		// both of dependent services required same service, its normal behavior

		$di = new Di();
		$instance = $di->getOrFail(MyCDependsOnABService::class);

		$this->assertInstanceOf(MyCDependsOnABService::class, $instance);
	}

	/**
	 * @return void
	 */
	public function testBindSelf()
	{
		// service bounded as self, its normal behavior (usually for singletons)

		$di = new Di();
		$di->bindShared(MyBDependsOnAService::class, MyBDependsOnAService::class);
		$di->bind(MyCDependsOnABService::class, MyCDependsOnABService::class);

		$b = $di->getOrFail(MyBDependsOnAService::class);
		$c = $di->getOrFail(MyCDependsOnABService::class);

		$this->assertInstanceOf(MyBDependsOnAService::class, $b);
		$this->assertInstanceOf(MyCDependsOnABService::class, $c);
	}


	/**
	 * @return void
	 */
	public function testBadLoopSelf()
	{
		// service requires itself

		$this->expectException(AutowireLoopError::class);

		$di = new Di();
		$di->getOrFail(MyLoopService::class);
	}

	/**
	 * @return void
	 */
	public function testBadLoopSelfInterface()
	{
		// service requires itself via interface

		$this->expectException(AutowireLoopError::class);

		$di = new Di();
		$di->bind(MyLoopServiceInterface::class, MyLoopWithInterfaceService::class);

		$di->getOrFail(MyLoopWithInterfaceService::class);
	}

	/**
	 * @return void
	 */
	public function testBadLoopSelfClosure()
	{
		// service requires itself inside closure factory

		$this->expectException(AutowireLoopError::class);

		$di = new Di();
		$di->bind(MyLoopService::class, function (Loop $loop) {
			return $loop->create(MyLoopService::class);
		});

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

	/**
	 * @return void
	 */
	public function testBadLoopABInterface()
	{
		// service A requires B, and service B requires service A via interfaces

		$this->expectException(AutowireLoopError::class);

		$di = new Di();
		$di->bind(MyLoopAServiceInterface::class, MyLoopAWithInterfaceService::class);
		$di->bind(MyLoopBServiceInterface::class, MyLoopBWithInterfaceService::class);

		$di->getOrFail(MyLoopAServiceInterface::class);
	}

	/**
	 * @return void
	 */
	public function testBadLoopCrossReference()
	{
		$this->expectException(AutowireLoopError::class);

		$di = new Di();
		$di->bind(MyLoopAService::class, MyLoopBService::class); // a to b
		$di->bind(MyLoopBService::class, MyLoopAService::class); // b to a

		$di->getOrFail(MyLoopAService::class);
	}

	/**
	 * @return void
	 */
	public function testBadLoopCrossReferenceInterfaces()
	{
		$this->expectException(AutowireLoopError::class);

		$di = new Di();
		$di->bind(MyLoopAServiceInterface::class, MyLoopBWithInterfaceService::class); // a to b
		$di->bind(MyLoopBServiceInterface::class, MyLoopAWithInterfaceService::class); // b to a

		$di->getOrFail(MyLoopAServiceInterface::class);
	}


	/**
	 * @return void
	 */
	public function testBadLoopABClosure()
	{
		// we recommend await Loop in closures (we pass it directly to first argument when creating via closure)
		// usually you can use $di->get() inside closure, but it is incorrect, because loop detection will be broken

		$this->expectException(AutowireLoopError::class);

		$di = new Di();

		$di->bind(MyLoopAService::class, function (Loop $loop) {
			return new MyLoopAService(
				$loop->create(MyLoopBService::class)
			);
		});

		$di->bind(MyLoopBService::class, function (Loop $loop) {
			return new MyLoopBService(
				$loop->create(MyLoopAService::class)
			);
		});

		$di->getOrFail(MyLoopAService::class);
	}

	/**
	 * @return void
	 */
	public function testBadLoopABClosureInterfaces()
	{
		// we recommend await Loop in closures (we pass it directly to first argument when creating via closure)
		// usually you can use $di->get() inside closure, but it is incorrect, because loop detection will be broken

		$this->expectException(AutowireLoopError::class);

		$di = new Di();

		$di->bind(MyLoopAServiceInterface::class, function (Loop $loop) {
			return new MyLoopAService(
				$loop->create(MyLoopBServiceInterface::class)
			);
		});

		$di->bind(MyLoopBServiceInterface::class, function (Loop $loop) {
			return new MyLoopBService(
				$loop->create(MyLoopAServiceInterface::class)
			);
		});

		$di->getOrFail(MyLoopAServiceInterface::class);
	}
}