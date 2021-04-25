<?php

namespace Gzhegow\Di\Delegate;


/**
 * Class DelegateManager
 */
interface DelegateManagerInterface
{
	/**
	 * @return string|DelegateInterface
	 */
	public function getDelegateClass() : string;


	/**
	 * @return bool
	 */
	public function hasDelegateClass() : bool;


	/**
	 * @param string|DelegateInterface $delegateClass
	 *
	 * @return DelegateManager
	 */
	public function setDelegateClass($delegateClass);
}