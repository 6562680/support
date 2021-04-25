<?php

namespace Gzhegow\Di\Provider;

use Gzhegow\Di\Di;
use Gzhegow\Di\DiInterface;
use Gzhegow\Di\Provider\Traits\CanSyncTrait;
use Gzhegow\Di\Provider\Traits\CanBootTrait;
use Gzhegow\Di\Provider\Traits\CanRegisterTrait;

/**
 * Class BootableProvider
 */
class BootableProvider implements BootableProviderInterface
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
	 * @param Di $di
	 */
	public function __construct(DiInterface $di)
	{
		$this->di = $di;
	}
}
