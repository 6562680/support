<?php

namespace Gzhegow\Di\Provider;

use Gzhegow\Di\Validator;
use Gzhegow\Di\Exceptions\RuntimeException;
use Gzhegow\Di\Provider\Traits\CanSyncInterface;
use Gzhegow\Di\Provider\Traits\CanBootInterface;
use Gzhegow\Di\Registry\DeferableRegistryInterface;

/**
 * Class ProviderManager
 */
class ProviderManager implements ProviderManagerInterface
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @var DeferableRegistryInterface
	 */
	protected $deferableRegistry;

	/**
	 * @var ProviderFactoryInterface
	 */
	protected $providerFactory;

	/**
	 * @var bool
	 */
	protected $isBooted = false;

	/**
	 * @var array
	 */
	protected $providers = [];
	/**
	 * @var array
	 */
	protected $providersBootable = [];
	/**
	 * @var array
	 */
	protected $providersDeferable = [];


	/**
	 * Constructor
	 *
	 * @param Validator                  $validator
	 *
	 * @param DeferableRegistryInterface $deferableRegistry
	 *
	 * @param ProviderFactoryInterface   $providerFactory
	 */
	public function __construct(
		Validator $validator,

		DeferableRegistryInterface $deferableRegistry,

		ProviderFactoryInterface $providerFactory
	)
	{
		$this->validator = $validator;

		$this->deferableRegistry = $deferableRegistry;

		$this->providerFactory = $providerFactory;
	}


	/**
	 * @return ProviderInterface[]
	 */
	public function getProviders() : array
	{
		return $this->providers;
	}


	/**
	 * @param string|ProviderInterface $provider
	 *
	 * @return ProviderInterface
	 */
	public function getProvider($provider) : ProviderInterface
	{
		$providerClass = is_object($provider)
			? get_class($provider)
			: $provider;

		$result = $this->providers[ $providerClass ];

		return $result;
	}


	/**
	 * @return bool
	 */
	public function isBooted() : bool
	{
		return $this->isBooted;
	}


	/**
	 * @param string|ProviderInterface $provider
	 *
	 * @return bool
	 */
	public function hasProvider($provider) : bool
	{
		$providerClass = is_object($provider)
			? get_class($provider)
			: $provider;

		return isset($this->providers[ $providerClass ]);
	}


	/**
	 * @param array $providers
	 *
	 * @return ProviderManager
	 */
	public function addProviders(array $providers)
	{
		foreach ( $providers as $provider ) {
			$this->addProvider($provider);
		}

		return $this;
	}


	/**
	 * @param ProviderInterface $provider
	 *
	 * @return ProviderManager
	 */
	public function addProvider(ProviderInterface $provider)
	{
		$this->providers[ $providerClass = get_class($provider) ] = $provider;

		$this->pipelineRegisterProvider($provider);
		$this->pipelineAddProvider($provider);

		return $this;
	}


	/**
	 * @param BootableProviderInterface $provider
	 *
	 * @return ProviderManager
	 */
	protected function addBootableProvider(BootableProviderInterface $provider)
	{
		$this->providersBootable[ $providerClass = get_class($provider) ] = $provider;

		if ($this->isBooted()) {
			$this->providerSyncing($provider);
			$this->providerBooting($provider);
		}

		return $this;
	}

	/**
	 * @param DeferableProviderInterface $provider
	 *
	 * @return ProviderManager
	 */
	protected function addDeferableProvider(DeferableProviderInterface $provider)
	{
		$this->providersDeferable[ $providerClass = get_class($provider) ] = $provider;

		foreach ( $provider->provides() as $id ) {
			$this->deferableRegistry->addDeferable($id, $providerClass);
		}

		return $this;
	}


	/**
	 * @return ProviderManager
	 */
	public function boot()
	{
		foreach ( $this->providersBootable as $provider ) {
			$this->providerSyncing($provider);
			$this->providerBooting($provider);
		}

		return $this;
	}

	/**
	 * @param mixed $id
	 *
	 * @return ProviderManager
	 */
	public function bootDeferable($id)
	{
		if (! $this->deferableRegistry->hasDeferable($id)) {
			return $this;
		}

		foreach ( $this->deferableRegistry->getDeferable($id) as $provider ) {
			$this->providerSyncing($this->providersDeferable[ $provider ]);
			$this->providerBooting($this->providersDeferable[ $provider ]);
		}

		return $this;
	}


	/**
	 * @param mixed $provider
	 *
	 * @return ProviderManager
	 */
	public function registerProvider($provider)
	{
		$this->pipelineRegisterProvider($provider);

		return $this;
	}


	/**
	 * @param ProviderInterface $provider
	 *
	 * @return ProviderManager
	 */
	protected function providerRegistering(ProviderInterface $provider)
	{
		if ($provider->isRegistered()) {
			return $this;
		}

		$provider->register();

		$provider->markAsRegistered(true);

		return $this;
	}

	/**
	 * @param CanSyncInterface $provider
	 *
	 * @return ProviderManager
	 */
	protected function providerSyncing(CanSyncInterface $provider)
	{
		if ($provider->isSynced()) {
			return $this;
		}

		$provider->markAsSynced(true);

		$defines = [];

		foreach ( $provider->getDefine() as $name => $from ) {
			if (! file_exists($from)) {
				throw new RuntimeException('Source file not found: ' . $from, func_get_args());
			}

			$defines[ $name ] = $from;
		}

		foreach ( $provider->getSync() as $name => $to ) {
			if (! isset($defines[ $name ])) {
				throw new RuntimeException('Define not found: ' . $name, func_get_args());
			}

			$from = $defines[ $name ];

			if (file_exists($to)) {
				continue;
			}

			if (! is_dir($dest = pathinfo($to, PATHINFO_DIRNAME))) {
				mkdir($dest, 0755, true);
			}

			if (! is_dir($from)) {
				copy($from, $to);

			} else {
				$it = new \RecursiveDirectoryIterator($from, \RecursiveDirectoryIterator::SKIP_DOTS);
				$iit = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::SELF_FIRST);

				foreach ( $iit as $file ) {
					/** @var \RecursiveDirectoryIterator $iit */

					$dest = $to . DIRECTORY_SEPARATOR . $iit->getSubPathName();
					$file->isDir()
						? mkdir($dest, 755, true)
						: copy($file->getRealpath(), $dest);
				}
			}
		}

		return $this;
	}

	/**
	 * @param CanBootInterface $provider
	 *
	 * @return ProviderManager
	 */
	protected function providerBooting(CanBootInterface $provider)
	{
		if ($provider->isBooted()) {
			return $this;
		}

		$provider->markAsBooted(true);

		$provider->boot();

		return $this;
	}


	/**
	 * @param ProviderInterface $provider
	 *
	 * @return ProviderManager
	 */
	protected function pipelineAddProvider(ProviderInterface $provider)
	{
		$this->pipeAddBootableProvider($provider);
		$this->pipeAddDeferableProvider($provider);

		return $this;
	}

	/**
	 * @param string|ProviderInterface $provider
	 *
	 * @return string
	 */
	protected function pipelineRegisterProvider($provider) : string
	{
		$providerClass = null
			?? $this->pipeRegisterProviderClass($provider)
			?? $this->pipeRegisterProviderInstance($provider);

		return $providerClass;
	}


	/**
	 * @param ProviderInterface|BootableProviderInterface $provider
	 *
	 * @return null|ProviderManager
	 */
	protected function pipeAddBootableProvider(ProviderInterface $provider) : ?ProviderInterface
	{
		if (! is_a($provider, BootableProviderInterface::class)) {
			return null;
		}

		$this->addBootableProvider($provider);

		return $provider;
	}

	/**
	 * @param ProviderInterface|DeferableProviderInterface $provider
	 *
	 * @return null|ProviderManager
	 */
	protected function pipeAddDeferableProvider(ProviderInterface $provider) : ?ProviderInterface
	{
		if (! is_a($provider, DeferableProviderInterface::class)) {
			return null;
		}

		$this->addDeferableProvider($provider);

		return $provider;
	}


	/**
	 * @param ProviderInterface $provider
	 *
	 * @return null|static
	 */
	protected function pipeRegisterProviderInstance($provider) : ?string
	{
		if (! is_object($provider)) return null;
		if (! is_a($provider, ProviderInterface::class)) return null;

		$this->addProvider($providerClass = $provider);

		return $providerClass;
	}

	/**
	 * @param string $provider
	 *
	 * @return null|static
	 */
	protected function pipeRegisterProviderClass($provider) : ?string
	{
		if (! is_string($provider)) return null;

		$instance = $this->providerFactory->newProvider($provider);

		$this->providerRegistering($instance);

		$this->addProvider($instance);

		return $provider;
	}
}