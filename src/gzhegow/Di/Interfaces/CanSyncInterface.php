<?php

namespace Gzhegow\Di\Interfaces;


/**
 * Interface CanSyncInterface
 */
interface CanSyncInterface
{
	/**
	 * @return string[]
	 */
	public function getDefine() : array;

	/**
	 * @return string[]
	 */
	public function getSync() : array;


	/**
	 * @return bool
	 */
	public function isSynced() : bool;


	/**
	 * @param bool|null $synced
	 *
	 * @return void
	 */
	public function markAsSynced(bool $synced = null) : void;


	/**
	 * @param string $defineKey
	 *
	 * @return mixed
	 */
	public function defineRealpath(string $defineKey) : string;

	/**
	 * @param string $syncKey
	 *
	 * @return mixed
	 */
	public function syncRealpath(string $syncKey) : string;
}