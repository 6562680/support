<?php

namespace Gzhegow\Di\Provider;

use Psr\Container\ContainerInterface;

/**
 * Class ProviderFactory
 */
class ProviderFactory implements ProviderFactoryInterface
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;


	/**
	 * Constructor
	 *
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container = null)
	{
		$this->container = $container;
	}


	/**
	 * @param string $name
	 *
	 * @return ProviderInterface
	 */
	public function newProvider(string $name) : ProviderInterface
	{
		return $this->container
			? $this->container->get($name)
			: new $name();
	}
}