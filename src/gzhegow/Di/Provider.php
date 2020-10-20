<?php

namespace Gzhegow\Di;

/**
 * Class Provider
 */
class Provider implements ProviderInterface
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
	 * @param bool|null $registered
	 *
	 * @return void
	 */
	public function setRegistered(bool $registered = null) : void
	{
		$this->isRegistered = $registered ?? true;
	}

	/**
	 * @return void
	 */
	public function register() : void
	{
	}
}
