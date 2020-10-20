<?php

namespace Gzhegow\Di\Interfaces;


/**
 * Interface CanBootInterface
 */
interface CanSyncInterface
{
	/**
	 * @return bool
	 */
	public function isSynced() : bool;

	/**
	 * @param bool|null $synced
	 *
	 * @return void
	 */
	public function setSynced(bool $synced = null) : void;

	/**
	 * @return array
	 */
	public function sync() : array;
}