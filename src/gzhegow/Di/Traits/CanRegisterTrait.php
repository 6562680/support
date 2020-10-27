<?php

namespace Gzhegow\Di\Traits;

/**
 * Trait CanRegisterTrait
 */
trait CanRegisterTrait
{
	/**
	 * @var bool
	 */
	protected $isRegistered = false;


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
	public function markAsRegistered(bool $registered = null) : void
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