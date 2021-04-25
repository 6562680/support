<?php

namespace Gzhegow\Di\Domain\Provider;

use Gzhegow\Di\DiInterface;
use Gzhegow\Di\Domain\Provider\Traits\CanRegisterTrait;

/**
 * Provider
 */
class Provider implements ProviderInterface
{
	use CanRegisterTrait;


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
}
