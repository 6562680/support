<?php

namespace Tests\Services;

/**
 * Class MyBadService
 */
class MyBadService
{
	/**
	 * @var MyBadService
	 */
	protected $myBadService;


	/**
	 * Constructor
	 *
	 * @param MyBadService $myBadService
	 */
	public function __construct(MyBadService $myBadService)
	{
		$this->myBadService = $myBadService;
	}
}