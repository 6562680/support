<?php

namespace Gzhegow\Di\Tests\Services;

/**
 * Class MyDService
 */
class MyDService
{
	/**
	 * @var MyAService
	 */
	protected $myAService;
	/**
	 * @var MyServiceBDelegateInterface|MyBService
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
		MyServiceBDelegateInterface $myBService = null
	)
	{
		$this->myAService = $myAService;
		$this->myBService = $myBService;
	}


	/**
	 * @return MyBService
	 */
	public function getMyBService() : MyBService
	{
		return $this->myBService->getDelegate();
	}

	/**
	 * @return MyServiceBDelegateInterface
	 */
	public function getMyBServiceDelegate() : MyServiceBDelegateInterface
	{
		return $this->myBService;
	}
}