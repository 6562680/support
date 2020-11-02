<?php

namespace Gzhegow\Di\Tests\Services\Loop;

/**
 * Class MyLoopBWithInterfaceService
 */
class MyLoopBWithInterfaceService implements MyLoopBServiceInterface
{
	/**
	 * @var MyLoopAServiceInterface
	 */
	public $myLoopAService;


	/**
	 * Constructor
	 *
	 * @param MyLoopAService $myLoopAService
	 */
	public function __construct(MyLoopAServiceInterface $myLoopAService)
	{
		$this->myLoopAService = $myLoopAService;
	}
}