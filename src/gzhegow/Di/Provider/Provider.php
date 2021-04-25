<?php

namespace Gzhegow\Di\Provider;

use Gzhegow\Di\DiInterface;
use Gzhegow\Di\Provider\Traits\CanRegisterTrait;

/**
 * Class Provider
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
