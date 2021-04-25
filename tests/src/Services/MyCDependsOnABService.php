<?php

namespace Gzhegow\Di\Tests\Services;

/**
 * Class MyCDependsOnABService
 */
class MyCDependsOnABService
{
	/**
	 * @var MyAService
	 */
	public $myAService;
	/**
	 * @var MyBDependsOnAService
	 */
	public $myBService;


	/**
	 * Constructor
	 *
	 * @param MyAService           $myAService
	 * @param MyBDependsOnAService $myBService
	 */
	public function __construct(
		MyAService $myAService,
		MyBDependsOnAService $myBService
	)
	{
		$this->myAService = $myAService;
		$this->myBService = $myBService;
	}
}