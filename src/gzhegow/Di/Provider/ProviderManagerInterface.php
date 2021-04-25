<?php

namespace Gzhegow\Di\Provider;


use Gzhegow\Di\Exceptions\Exception\NotFoundException;

/**
 * Class ProviderManager
 */
interface ProviderManagerInterface
{
	/**
	 * @return ProviderInterface[]
	 */
	public function getProviders() : array;


	/**
	 * @param string|ProviderInterface $provider
	 *
	 * @return ProviderInterface
	 */
	public function getProvider($provider) : ProviderInterface;


	/**
	 * @return bool
	 */
	public function isBooted() : bool;


	/**
	 * @param string|ProviderInterface $provider
	 *
	 * @return bool
	 */
	public function hasProvider($provider) : bool;


	/**
	 * @param array $providers
	 *
	 * @return ProviderManager
	 */
	public function addProviders(array $providers);


	/**
	 * @param ProviderInterface $provider
	 *
	 * @return ProviderManager
	 */
	public function addProvider(ProviderInterface $provider);


	/**
	 * @return ProviderManager
	 */
	public function boot();

	/**
	 * @param mixed $id
	 *
	 * @return ProviderManager
	 * @throws NotFoundException
	 */
	public function bootDeferable($id);


	/**
	 * @param mixed $provider
	 *
	 * @return ProviderManager
	 */
	public function registerProvider($provider);
}