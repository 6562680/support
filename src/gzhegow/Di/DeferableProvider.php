<?php

namespace Gzhegow\Di;

use Gzhegow\Di\Traits\CanBootTrait;
use Gzhegow\Di\Traits\CanSyncTrait;
use Gzhegow\Di\Traits\CanRegisterTrait;

/**
 * Class DeferableProvider
 */
class DeferableProvider implements DeferableProviderInterface
{
	use CanRegisterTrait;
	use CanBootTrait;
	use CanSyncTrait;


	/**
	 * @var Di
	 */
	protected $di;


	/**
	 * Constructor
	 *
	 * @param Di $di
	 */
	public function __construct(Di $di)
	{
		$this->di = $di;
	}


	/**
	 * @return array
	 */
	public function provides() : array
	{
		return [];
	}
}
