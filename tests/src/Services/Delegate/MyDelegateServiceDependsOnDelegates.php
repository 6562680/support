<?php

namespace Gzhegow\Di\Tests\Services\Delegate;

/**
 * Class MyDelegateServiceDependsOnDelegates
 */
class MyDelegateServiceDependsOnDelegates
{
	/**
	 * @var MyDelegateAService
	 */
	public $myAService;
	/**
	 * @var MyDelegateBService|MyDelegateServiceBInterface
	 */
	public $myBService;
	/**
	 * @var MyDelegateCService|MyDelegateServiceCInterface
	 */
	public $myCService;
	/**
	 * @var MyDelegateDService|MyDelegateServiceDInterface
	 */
	public $myDService;


	/**
	 * Constructor
	 *
	 * @param MyDelegateAService               $myAService
	 * @param MyDelegateServiceBInterface|null $myBService
	 * @param MyDelegateServiceCInterface|null $myCService
	 * @param MyDelegateServiceDInterface|null $myDService
	 */
	public function __construct(
		MyDelegateAService $myAService,
		MyDelegateServiceBInterface $myBService = null,
		MyDelegateServiceCInterface $myCService = null,
		MyDelegateServiceDInterface $myDService = null
	)
	{
		$this->myAService = $myAService;
		$this->myBService = $myBService;
		$this->myCService = $myCService;
		$this->myDService = $myDService;
	}
}