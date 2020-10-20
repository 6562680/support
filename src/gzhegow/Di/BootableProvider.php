<?php

namespace Gzhegow\Di;

/**
 * Class BootableProvider
 */
class BootableProvider implements BootableProviderInterface
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
	protected $isSynced = false;
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
	public function isSynced() : bool
	{
		return $this->isSynced;
	}

	/**
	 * @return bool
	 */
	public function isBooted() : bool
	{
		return $this->isBooted;
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
	 * @param bool|null $booted
	 *
	 * @return void
	 */
	public function setBooted(bool $booted = null) : void
	{
		$this->isBooted = $booted ?? true;
	}

	/**
	 * @param bool|null $synced
	 *
	 * @return void
	 */
	public function setSynced(bool $synced = null) : void
	{
		$this->isSynced = $synced ?? true;
	}


	/**
	 * @return void
	 */
	public function register() : void
	{
	}

	/**
	 * @return array
	 */
	public function sync() : array
	{
		return [];
	}

	/**
	 * @return void
	 */
	public function boot() : void
	{
	}
}
