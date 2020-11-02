<?php

namespace Gzhegow\Di;

/**
 * Interface DelegateInterface
 */
interface DelegateInterface
{
	/**
	 * @return mixed
	 */
	public function getDelegate();


	/**
	 * @return bool
	 */
	public function hasDelegate() : bool;


	/**
	 * @return mixed
	 */
	public function loadDelegate();
}