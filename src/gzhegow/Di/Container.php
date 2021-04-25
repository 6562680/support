<?php

namespace Gzhegow\Di;

use Psr\Container\ContainerInterface;

/**
 * Class Container
 */
class Container implements ContainerInterface
{
	/**
	 * @var InjectorInterface
	 */
	protected $injector;


	/**
	 * Constructor
	 *
	 * @param InjectorInterface $injector
	 */
	public function __construct(InjectorInterface $injector)
	{
		$this->injector = $injector;
	}


	/**
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return void
	 */
	public function __call($name, $arguments)
	{
		$this->injector->{$name}(...$arguments);
	}


	/**
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function get($id)
	{
		return $this->injector->get($id);
	}

	/**
	 * @param string $id
	 *
	 * @return bool
	 */
	public function has($id) : bool
	{
		return $this->injector->has($id);
	}
}