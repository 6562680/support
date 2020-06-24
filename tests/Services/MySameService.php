<?php

namespace Tests\Services;

/**
 * Class MySameService
 */
class MySameService
{
	/**
	 * @var MyService
	 */
	protected $myService;
	/**
	 * @var MyTwoService
	 */
	protected $myLoopTwoService;


	/**
	 * Constructor
	 *
	 * @param MyService    $myService
	 * @param MyTwoService $myLoopTwoService
	 */
	public function __construct(
		MyService $myService,
		MyTwoService $myLoopTwoService
	)
	{
		$this->myService = $myService;
		$this->myLoopTwoService = $myLoopTwoService;
	}
}