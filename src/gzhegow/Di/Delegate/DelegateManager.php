<?php

namespace Gzhegow\Di\Delegate;

use Gzhegow\Di\Validator;

/**
 * Class DelegateManager
 */
class DelegateManager implements DelegateManagerInterface
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @var string
	 */
	protected $delegateClass;


	/**
	 * Constructor
	 *
	 * @param Validator $validator
	 */
	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}


	/**
	 * @return string|DelegateInterface
	 */
	public function getDelegateClass() : string
	{
		return $this->delegateClass;
	}


	/**
	 * @return bool
	 */
	public function hasDelegateClass() : bool
	{
		return ! ! $this->delegateClass;
	}


	/**
	 * @param string|DelegateInterface $delegateClass
	 *
	 * @return DelegateManager
	 */
	public function setDelegateClass($delegateClass)
	{
		$this->validator->isDelegateClassOrFail($delegateClass);

		$this->delegateClass = $delegateClass;

		return $this;
	}
}