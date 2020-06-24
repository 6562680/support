<?php

namespace Tests\Services;

/**
 * Class MyTwoService
 */
class MyTwoService
{
	/**
	 * @var MyService
	 */
	protected $myService;


	/**
	 * Constructor
	 *
	 * @param MyService $myService
	 */
	public function __construct(MyService $myService)
	{
		$this->myService = $myService;
	}
}