<?php

namespace Tests\Services;

/**
 * Class MyCService
 */
class MyCService
{
	/**
	 * @var MyAService
	 */
	protected $myAService;
	/**
	 * @var MyBService
	 */
	protected $myBService;


	/**
	 * Constructor
	 *
	 * @param MyAService $myAService
	 * @param MyBService $myBService
	 */
	public function __construct(
		MyAService $myAService,
		MyBService $myBService
	)
	{
		$this->myAService = $myAService;
		$this->myBService = $myBService;
	}
}