<?php

namespace Gzhegow\Di\Delegate;

use Psr\Container\ContainerInterface;
use Gzhegow\Di\Exceptions\Runtime\UnexpectedValueException;

/**
 * Class Delegate
 */
class Delegate implements DelegateInterface
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;

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
	 * @param ContainerInterface $container
	 * @param string             $id
	 */
	public function __construct(ContainerInterface $container, string $id)
	{
		$this->container = $container;

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
			$this->delegate = $this->container->get($this->id);
		}

		if (! is_object($this->delegate)) {
			throw new UnexpectedValueException('Delegate should be object', [ $this->delegate ]);
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
