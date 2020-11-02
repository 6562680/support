<?php

namespace Gzhegow\Di\Tests\Services\Loop;

/**
 * Class MyLoopAService
 */
class MyLoopAService
{
	/**
	 * @var MyLoopBService
	 */
	public $myLoopBService;


	/**
	 * Constructor
	 *
	 * @param MyLoopBService $myLoopBService
	 */
	public function __construct(MyLoopBService $myLoopBService)
	{
		$this->myLoopBService = $myLoopBService;
	}
}