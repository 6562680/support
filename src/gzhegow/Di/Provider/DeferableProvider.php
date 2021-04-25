<?php

namespace Gzhegow\Di\Provider;

use Gzhegow\Di\DiInterface;
use Gzhegow\Di\Provider\Traits\CanSyncTrait;
use Gzhegow\Di\Provider\Traits\CanBootTrait;
use Gzhegow\Di\Provider\Traits\CanRegisterTrait;

/**
 * Class DeferableProvider
 */
class DeferableProvider implements DeferableProviderInterface
{
	use CanRegisterTrait;
	use CanSyncTrait;
	use CanBootTrait;


	/**
	 * @var DiInterface
	 */
	protected $di;


	/**
	 * Constructor
	 *
	 * @param DiInterface $di
	 */
	public function __construct(DiInterface $di)
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
