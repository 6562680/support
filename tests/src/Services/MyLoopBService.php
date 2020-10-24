<?php

namespace Gzhegow\Di\Tests\Services;

/**
 * Class MyLoopBService
 */
class MyLoopBService
{
	/**
	 * @var MyLoopAService
	 */
	protected $myLoopAService;


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