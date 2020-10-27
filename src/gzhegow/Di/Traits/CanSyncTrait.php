<?php

namespace Gzhegow\Di\Traits;

use Gzhegow\Di\Exceptions\Logic\InvalidArgumentException;

/**
 * Trait CanSyncTrait
 */
trait CanSyncTrait
{
	/**
	 * @var bool
	 */
	protected $isSynced = false;

	/**
	 * @var string[]
	 */
	protected $define;
	/**
	 * @var string[]
	 */
	protected $sync;


	/**
	 * @return string[]
	 */
	public function getDefine() : array
	{
		return $this->define = $this->define
			?? $this->define();
	}

	/**
	 * @return string[]
	 */
	public function getSync() : array
	{
		return $this->sync = $this->sync
			?? $this->sync();
	}


	/**
	 * @return bool
	 */
	public function isSynced() : bool
	{
		return $this->isSynced;
	}


	/**
	 * @param bool|null $synced
	 *
	 * @return void
	 */
	public function markAsSynced(bool $synced = null) : void
	{
		$this->isSynced = $synced ?? true;
	}


	/**
	 * @param string $defineKey
	 *
	 * @return string
	 */
	public function defineRealpath(string $defineKey) : string
	{
		if (false === ( $realpath = realpath($path = $this->getDefine()[ $defineKey ]) )) {
			throw new InvalidArgumentException('Sync path is missing: ' . $defineKey, [ $defineKey, $path ]);
		}

		return $realpath;
	}

	/**
	 * @param string $syncKey
	 *
	 * @return string
	 */
	public function syncRealpath(string $syncKey) : string
	{
		if (false === ( $realpath = realpath($path = $this->getSync()[ $syncKey ]) )) {
			throw new InvalidArgumentException('Sync path is missing: ' . $syncKey, [ $syncKey, $path ]);
		}

		return $realpath;
	}


	/**
	 * @return array
	 */
	protected function define() : array
	{
		return [];
	}

	/**
	 * @return array
	 */
	protected function sync() : array
	{
		return [];
	}
}