<?php

namespace Gzhegow\Di\Provider\Traits;

/**
 * Trait CanBootTrait
 */
trait CanBootTrait
{
	/**
	 * @var bool
	 */
	protected $isBooted = false;


	/**
	 * @return bool
	 */
	public function isBooted() : bool
	{
		return $this->isBooted;
	}


	/**
	 * @param bool|null $booted
	 *
	 * @return void
	 */
	public function markAsBooted(bool $booted = null) : void
	{
		$this->isBooted = $booted ?? true;
	}


	/**
	 * @return void
	 */
	public function boot() : void
	{
	}
}