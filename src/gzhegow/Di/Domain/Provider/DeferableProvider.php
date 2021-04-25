<?php

namespace Gzhegow\Di\Domain\Provider;

use Gzhegow\Di\DiInterface;
use Gzhegow\Di\Domain\Provider\Traits\CanSyncTrait;
use Gzhegow\Di\Domain\Provider\Traits\CanBootTrait;
use Gzhegow\Di\Domain\Provider\Traits\CanRegisterTrait;

/**
 * DeferableProvider
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
