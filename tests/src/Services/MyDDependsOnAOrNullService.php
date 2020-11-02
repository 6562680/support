<?php

namespace Gzhegow\Di\Tests\Services;

/**
 * Class MyDDependsOnAOrNullService
 */
class MyDDependsOnAOrNullService
{
	/**
	 * @var MyAService
	 */
	public $myAService;


	/**
	 * Constructor
	 *
	 * @param MyAService           $myAService
	 * @param MyBDependsOnAService $myBService
	 */
	public function __construct(
		MyAService $myAService = null
	)
	{
		$this->myAService = $myAService;
	}
}