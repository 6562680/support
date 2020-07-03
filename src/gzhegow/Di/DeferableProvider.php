<?php

namespace Gzhegow\Di;

/**
 * Class DeferableProvider
 */
class DeferableProvider implements DeferableProviderInterface
{
	/**
	 * @var Di
	 */
	protected $di;

	/**
	 * @var bool
	 */
	protected $isRegistered = false;
	/**
	 * @var bool
	 */
	protected $isBooted = false;


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
	 * @return bool
	 */
	public function isRegistered() : bool
	{
		return $this->isRegistered;
	}

	/**
	 * @return bool
	 */
	public function isBooted() : bool
	{
		return $this->isBooted;
	}


	/**
	 * @return void
	 */
	public function register() : void
	{
	}

	/**
	 * @return void
	 */
	public function boot() : void
	{
	}


	/**
	 * @return array
	 */
	public function provides() : array
	{
		return [];
	}
}
