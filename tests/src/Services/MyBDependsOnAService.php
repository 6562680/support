<?php

namespace Gzhegow\Di\Tests\Services;

/**
 * Class MyBDependsOnAService
 */
class MyBDependsOnAService
{
	/**
	 * @var MyAService
	 */
	public $myAService;


	/**
	 * Constructor
	 *
	 * @param MyAService $myAService
	 */
	public function __construct(MyAService $myAService)
	{
		$this->myAService = $myAService;
	}
}