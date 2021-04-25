<?php

namespace Gzhegow\Di\Tests\Services\Loop;

/**
 * Class MyLoopWithInterfaceService
 */
class MyLoopWithInterfaceService implements MyLoopServiceInterface
{
	/**
	 * @var MyLoopWithInterfaceService
	 */
	public $myLoopService;


	/**
	 * Constructor
	 *
	 * @param MyLoopWithInterfaceService $myLoopService
	 */
	public function __construct(MyLoopWithInterfaceService $myLoopService)
	{
		$this->myLoopService = $myLoopService;
	}
}