<?php

namespace Tests\Services;

/**
 * Class MyBService
 */
class MyBService
{
	/**
	 * @var MyAService
	 */
	protected $myAService;


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