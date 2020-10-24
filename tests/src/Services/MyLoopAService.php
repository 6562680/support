<?php

namespace Gzhegow\Di\Tests\Services;

/**
 * Class MyLoopAService
 */
class MyLoopAService
{
	/**
	 * @var MyLoopBService
	 */
	protected $myLoopBService;


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