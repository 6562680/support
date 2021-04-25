<?php

namespace Gzhegow\Di\Tests\Services\Closure;

/**
 * Class MyClosureBDependsOnAService
 */
class MyClosureBDependsOnAService
{
	/**
	 * @var MyClosureAService
	 */
	public $myAService;


	/**
	 * Constructor
	 *
	 * @param MyClosureAService $myAService
	 */
	public function __construct(MyClosureAService $myAService)
	{
		$this->myAService = $myAService;
	}
}