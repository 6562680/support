<?php

namespace Gzhegow\Di\Tests\Services\Loop;

/**
 * Class MyLoopBService
 */
class MyLoopBService
{
	/**
	 * @var MyLoopAService
	 */
	public $myLoopAService;


	/**
	 * Constructor
	 *
	 * @param MyLoopAService $myLoopAService
	 */
	public function __construct(MyLoopAService $myLoopAService)
	{
		$this->myLoopAService = $myLoopAService;
	}
}