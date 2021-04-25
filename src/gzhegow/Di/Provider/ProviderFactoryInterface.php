<?php

namespace Gzhegow\Di\Provider;


use Gzhegow\Di\Provider\ProviderInterface;

/**
 * Class ProviderFactory
 */
interface ProviderFactoryInterface
{
	/**
	 * @param string $name
	 *
	 * @return ProviderInterface
	 */
	public function newProvider(string $name) : ProviderInterface;
}