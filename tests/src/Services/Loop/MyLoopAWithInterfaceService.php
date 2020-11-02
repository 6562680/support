<?php

namespace Gzhegow\Di\Tests\Services\Loop;

/**
 * Class MyLoopAWithInterfaceService
 */
class MyLoopAWithInterfaceService implements MyLoopAServiceInterface
{
	/**
	 * @var MyLoopBServiceInterface
	 */
	public $myLoopBService;


	/**
	 * Constructor
	 *
	 * @param MyLoopBServiceInterface $myLoopBService
	 */
	public function __construct(MyLoopBServiceInterface $myLoopBService)
	{
		$this->myLoopBService = $myLoopBService;
	}
}