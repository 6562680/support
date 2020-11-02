<?php

namespace Gzhegow\Di;

use Gzhegow\Di\Exceptions\Runtime\UnexpectedValueException;

/**
 * Class Delegate
 */
class Delegate implements DelegateInterface
{
	/**
	 * @var Di
	 */
	protected $di;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var mixed
	 */
	protected $delegate;


	/**
	 * Constructor
	 *
	 * @param Di     $di
	 * @param string $id
	 */
	public function __construct(
		Di $di,

		string $id
	)
	{
		$this->di = $di;

		$this->id = $id;
	}


	/**
	 * @return mixed
	 */
	public function __invoke()
	{
		if (! $this->hasDelegate()) {
			$this->loadDelegate();
		}

		return $this->getDelegate();
	}


	/**
	 * @param int|string $name
	 *
	 * @return mixed
	 */
	public function __get($name)
	{
		if (! $this->hasDelegate()) {
			$this->loadDelegate();
		}

		return $this->delegate->{$name};
	}

	/**
	 * @param int|string $name
	 * @param mixed      $value
	 *
	 * @return void
	 */
	public function __set($name, $value)
	{
		if (! $this->hasDelegate()) {
			$this->loadDelegate();
		}

		$this->delegate->{$name} = $value;
	}


	/**
	 * @param string $method
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		if (! $this->hasDelegate()) {
			$this->getDelegate();
		}

		return call_user_func_array([ $this->delegate, $method ], $arguments);
	}


	/**
	 * @return mixed
	 */
	public function loadDelegate()
	{
		if (! isset($this->delegate)) {
			$this->delegate = $this->di->getOrFail($this->id);
		}

		if (! is_object($this->delegate)) {
			throw new UnexpectedValueException('Invalid delegate loaded');
		}

		return $this->delegate;
	}


	/**
	 * @return mixed
	 */
	public function getDelegate()
	{
		if (is_null($this->delegate)) {
			throw new UnexpectedValueException('There is no delegate, call __get(), __set(), __invoke() or ->loadDelegate() methods');
		}

		return $this->delegate;
	}


	/**
	 * @return bool
	 */
	public function hasDelegate() : bool
	{
		return isset($this->delegate);
	}
}
