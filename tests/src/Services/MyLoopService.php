<?php

namespace Gzhegow\Di\Tests\Services;

/**
 * Class MyLoopService
 */
class MyLoopService
{
	/**
	 * @var MyLoopService
	 */
	protected $myBadService;


	/**
	 * Constructor
	 *
	 * @param MyLoopService $myBadService
	 */
	public function __construct(MyLoopService $myBadService)
	{
		$this->myBadService = $myBadService;
	}
}