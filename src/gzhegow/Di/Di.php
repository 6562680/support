<?php

namespace Gzhegow\Di;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Php;
use Gzhegow\Support\Type;
use Gzhegow\Reflection\Reflection;
use Psr\SimpleCache\CacheInterface;
use Psr\Container\ContainerInterface;
use Gzhegow\Reflection\CachedReflection;
use Gzhegow\Di\Exceptions\RuntimeException;
use Gzhegow\Di\Interfaces\CanBootInterface;
use Gzhegow\Di\Interfaces\CanSyncInterface;
use Gzhegow\Reflection\ReflectionInterface;
use Gzhegow\Di\Exceptions\Error\NotFoundError;
use Gzhegow\Di\Exceptions\Runtime\OverflowException;
use Gzhegow\Di\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Di
 */
class Di implements
	ContainerInterface,
	DiInterface
{
	/**
	 * @var CacheInterface
	 */
	protected $cache;
	/**
	 * @var ReflectionInterface
	 */
	protected $reflection;

	/**
	 * @var Arr
	 */
	protected $arr;
	/**
	 * @var Php
	 */
	protected $php;
	/**
	 * @var Type
	 */
	protected $type;

	/**
	 * @var array
	 */
	protected $items = [];

	/**
	 * @var array
	 */
	protected $bind = [];
	/**
	 * @var bool[][]
	 */
	protected $bindDeferable = [];

	/**
	 * @var array
	 */
	protected $shared = [];

	/**
	 * @var array
	 */
	protected $extends = [];

	/**
	 * @var ProviderInterface[]
	 */
	protected $providers = [];
	/**
	 * @var BootableProviderInterface[]
	 */
	protected $providersBootable = [];
	/**
	 * @var DeferableProviderInterface[]
	 */
	protected $providersDeferable = [];

	/**
	 * @var array
	 */
	protected $providerSnapshots = [];

	/**
	 * @var bool
	 */
	protected $isBooted = false;

	/**
	 * @var string
	 */
	protected $delegateClass;


	/**
	 * Constructor
	 *
	 * @param CacheInterface|null $cache
	 */
	public function __construct(CacheInterface $cache = null)
	{
		$this->cache = $cache;

		static::$instance = static::$instance ?? $this;

		$keys = [
			ContainerInterface::class,
			DiInterface::class,

			static::class,
		];

		foreach ( $keys as $key ) {
			if (! $this->hasShared($key)) {
				$this->set($key, $this);
			}
		}

		$this->php = $this->newPhp();
		$this->type = $this->newType();

		$this->arr = $this->newArr();
		$this->reflection = $this->newReflection();
	}


	/**
	 * @return Loop
	 */
	public function newLoop($id) : Loop
	{
		$loop = new Loop(
			$this->reflection,

			$this->arr,
			$this->php,
			$this->type,

			$this,

			$id
		);

		return $loop;
	}


	/**
	 * @return Arr
	 */
	public function newArr() : Arr
	{
		return new Arr(
			$this->php,
			$this->type
		);
	}

	/**
	 * @return Php
	 */
	public function newPhp() : Php
	{
		return new Php();
	}

	/**
	 * @return Type
	 */
	public function newType() : Type
	{
		return new Type();
	}

	/**
	 * @return ReflectionInterface
	 */
	public function newReflection() : ReflectionInterface
	{
		return $this->cache
			? new CachedReflection(
				$this->php,
				$this->type,
				$this->cache
			)
			: new Reflection(
				$this->php,
				$this->type
			);
	}


	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public function createOrFail(string $id, ...$arguments)
	{
		return $this->newLoop($id)->createOrFail($id, ...$arguments);
	}

	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public function create(string $id, ...$arguments)
	{
		return $this->newLoop($id)->create($id, ...$arguments);
	}


	/**
	 * @param string $id
	 *
	 * @return string|\Closure
	 * @throws NotFoundError
	 */
	public function getBind(string $id)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! $this->hasBind($id)) {
			throw new NotFoundError('Item not found: ' . $id);
		}

		$bind = $this->bind[ $id ];

		return $bind;
	}

	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public function getItem(string $id)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! $this->hasItem($id)) {
			throw new NotFoundError('Item not found: ' . $id);
		}

		$item = $this->items[ $id ];

		return $item;
	}


	/**
	 * @param string $id
	 *
	 * @return array
	 * @throws NotFoundError
	 */
	public function getExtends(string $id) : array
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! $this->hasExtends($id)) {
			throw new NotFoundError('Extends not found: ' . $id);
		}

		$item = $this->extends[ $id ];

		return $item;
	}


	/**
	 * @return ProviderInterface[]
	 */
	public function getProviders() : array
	{
		return $this->providers;
	}

	/**
	 * @return BootableProviderInterface[]
	 */
	public function getProvidersBootable() : array
	{
		return $this->providersBootable;
	}

	/**
	 * @return DeferableProviderInterface[][]
	 */
	public function getProvidersDeferable() : array
	{
		return $this->providersDeferable;
	}


	/**
	 * @return string
	 */
	public function getDelegateClass() : string
	{
		return $this->delegateClass;
	}


	/**
	 * @return bool
	 */
	public function isBooted() : bool
	{
		return $this->isBooted;
	}


	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasItem($id) : bool
	{
		return is_string($id) && isset($this->items[ $id ]);
	}


	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasBind($id) : bool
	{
		return is_string($id) && isset($this->bind[ $id ]);
	}

	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasDeferableBind($id) : bool
	{
		return is_string($id) && isset($this->bindDeferable[ $id ]);
	}


	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasShared($id) : bool
	{
		return is_string($id) && isset($this->shared[ $id ]);
	}


	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function hasExtends($id) : bool
	{
		return is_string($id) && isset($this->extends[ $id ]);
	}


	/**
	 * @return bool
	 */
	public function hasDelegateClass() : bool
	{
		return ! ! $this->delegateClass;
	}


	/**
	 * @param array $providers
	 *
	 * @return Di
	 */
	public function setProviders(array $providers)
	{
		foreach ( $this->providers as $provider ) {
			$this->removeProvider($provider);
		}

		$this->addProviders($providers);

		return $this;
	}

	/**
	 * @param string $delegateClass
	 *
	 * @return Di
	 */
	public function setDelegateClass(string $delegateClass)
	{
		if (! is_a($delegateClass, DelegateInterface::class, true)) {
			throw new InvalidArgumentException('Delegate class should implements ' . DelegateInterface::class);
		}

		$this->delegateClass = $delegateClass;

		return $this;
	}


	/**
	 * @param array $providers
	 *
	 * @return $this
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
	 * @return Di
	 */
	public function addProvider(ProviderInterface $provider)
	{
		/** @var ProviderInterface $provider */
		/** @var BootableProviderInterface $bootableProvider */
		/** @var DeferableProviderInterface $deferableProvider */

		$this->providers[ $class = get_class($provider) ] = $provider;

		$this->providerRegistering($provider);

		if (is_a($bootableProvider = $provider, BootableProviderInterface::class)) {
			$this->providersBootable[ $class ] = $provider;

			// if already called boot method - we boot immediately
			if ($this->isBooted()) {
				$this->providerSyncing($bootableProvider);
				$this->providerBooting($bootableProvider);
			}
		}

		if (is_a($deferableProvider = $provider, DeferableProviderInterface::class)) {
			$this->providersDeferable[ $class ] = $provider;

			foreach ( $deferableProvider->provides() as $id ) {
				$this->bindDeferable[ $id ][ $class ] = true;
			}
		}

		return $this;
	}


	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public function get($id)
	{
		return $this->newLoop($id)->get($id);
	}

	/**
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function getOrFail(string $id)
	{
		return $this->newLoop($id)->getOrFail($id);
	}


	/**
	 * @param string $id
	 *
	 * @return bool
	 */
	public function has($id)
	{
		return 0
			|| $this->hasItem($id)
			|| $this->hasBind($id)
			|| $this->type->isClass($id);
	}


	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 */
	public function set(string $id, $item)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if ($this->hasItem($id)) {
			throw new OverflowException('Item is already defined: ' . $id);
		}

		$this->replace($id, $item);

		return $this;
	}

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return mixed
	 */
	public function setOrFail(string $id, $item)
	{
		try {
			$result = $this->set($id, $item);
		}
		catch ( OverflowException $e ) {
			throw new RuntimeException('Unable to ' . __METHOD__, func_get_args(), $e);
		}

		return $result;
	}


	/**
	 * @param string          $id
	 * @param string|\Closure $item
	 *
	 * @return Di
	 */
	public function replace(string $id, $item)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		$this->items[ $id ] = $item;

		return $this;
	}


	/**
	 * @param string          $id
	 * @param string|\Closure $bind
	 * @param bool            $shared
	 *
	 * @return Di
	 */
	public function bind(string $id, $bind, bool $shared = false)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if ($this->hasBind($id)) {
			throw new OverflowException('Bind is already defined: ' . $id);
		}

		$this->rebind($id, $bind, $shared);

		return $this;
	}

	/**
	 * @param string          $id
	 * @param string|\Closure $bind
	 *
	 * @return Di
	 */
	public function bindShared(string $id, $bind)
	{
		$this->bind($id, $bind, $shared = true);

		return $this;
	}

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 */
	public function singleton(string $id, $item)
	{
		$this->bindShared($id, $item);

		return $this;
	}


	/**
	 * @param string          $id
	 * @param string|\Closure $bind
	 * @param bool            $shared
	 *
	 * @return Di
	 */
	public function rebind(string $id, $bind, bool $shared = false)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! ( 0
			|| ( $isClosure = $this->type->isClosure($bind) )
			|| ( $isClass = $this->type->isClass($bind) )
		)) {
			throw new InvalidArgumentException('Bind should be closure or class name');
		}

		if ($id !== $bind) {
			$this->bind[ $id ] = $bind;
		}

		if (! $shared && $this->hasShared($id)) {
			unset($this->shared[ $id ]);
		}

		if ($shared && ! $this->hasShared($id)) {
			$this->shared[ $id ] = true;
		}

		return $this;
	}

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 */
	public function rebindShared(string $id, $item)
	{
		$this->rebind($id, $item, $shared = true);

		return $this;
	}


	/**
	 * @param string                   $id
	 * @param string|callable|\Closure $func
	 *
	 * @return Di
	 */
	public function extend(string $id, $func)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! ( 0
			|| $this->type->isClosure($func)
			|| $this->type->isCallable($func)
		)) {
			throw new InvalidArgumentException('Func should be closure or callable');
		}

		$this->extends[ $id ][] = $func;

		return $this;
	}


	/**
	 * @param mixed $provider
	 *
	 * @return $this
	 */
	public function registerProvider($provider)
	{
		$this->pipeRegisterProvider($provider);

		return $this;
	}

	/**
	 * @param mixed $provider
	 *
	 * @return Di
	 */
	public function removeProvider($provider)
	{
		$this->pipeRemoveProvider($provider);

		return $this;
	}


	/**
	 * @return Di
	 */
	public function boot()
	{
		$this->isBooted = true;

		foreach ( $this->providersBootable as $provider ) {
			$this->providerSyncing($provider);
			$this->providerBooting($provider);
		}

		return $this;
	}

	/**
	 * @param string $id
	 *
	 * @return Di
	 * @throws NotFoundError
	 */
	public function bootDeferable(string $id)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! $this->hasDeferableBind($id)) {
			throw new NotFoundError('Deferable bind not found: ' . $id);
		}

		foreach ( $this->bindDeferable[ $id ] as $provider => $bool ) {
			$this->providerSyncing($this->providersDeferable[ $provider ]);
			$this->providerBooting($this->providersDeferable[ $provider ]);
		}

		return $this;
	}


	/**
	 * @param callable $func
	 * @param array    $arguments
	 *
	 * @return mixed
	 */
	public function handle($func, ...$arguments)
	{
		if (! ( 0
			|| ( $this->type->isHandler($func) )
			|| ( $this->type->isClosure($func) )
			|| ( $this->type->isCallable($func) )
		)) {
			throw new InvalidArgumentException('Func should be handler, closure or callable');
		}

		$result = $this->newLoop($func)
			->handle($func, ...$arguments);

		return $result;
	}

	/**
	 * @param mixed    $newthis
	 * @param callable $func
	 * @param array    $arguments
	 *
	 * @return mixed
	 */
	public function call($newthis, $func, ...$arguments)
	{
		if (! ( 0
			|| ( $this->type->isCallable($func) )
			|| ( $this->type->isClosure($func) )
		)) {
			throw new InvalidArgumentException('Func should be closure, handler or callable');
		}

		$result = $this->newLoop($func)
			->call($newthis, $func, ...$arguments);

		return $result;
	}


	/**
	 * @param ProviderInterface $provider
	 *
	 * @return Di
	 */
	protected function providerRegistering(ProviderInterface $provider)
	{
		if ($provider->isRegistered()) {
			return $this;
		}

		$provider->markAsRegistered(true);

		$class = get_class($provider);

		$snapshot = [
			'items'   => $this->items,
			'bind'    => $this->bind,
			'shared'  => $this->shared,
			'extends' => $this->extends,
		];

		$provider->register();

		foreach ( array_keys($snapshot) as $key ) {
			$snapshot[ $key ] = array_diff_key($this->{$key}, $snapshot[ $key ]);

			$this->providerSnapshots[ $class ] = $snapshot;
		}

		return $this;
	}

	/**
	 * @param CanSyncInterface $provider
	 *
	 * @return Di
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
	 * @return Di
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
	 * @param mixed $provider
	 *
	 * @return ProviderInterface
	 */
	protected function pipeRegisterProvider($provider) : ProviderInterface
	{
		$instance = null
			?? $this->registerProviderClass($provider)
			?? $this->registerProviderInstance($provider);

		return $instance;
	}

	/**
	 * @param mixed $provider
	 *
	 * @return null|Di
	 */
	protected function registerProviderClass($provider) : ?ProviderInterface
	{
		if (! is_string($provider)) return null;

		$instance = $this->createOrFail($provider);

		$provider = $this->registerProviderInstance($instance);

		return $provider;
	}

	/**
	 * @param mixed $provider
	 *
	 * @return ProviderInterface
	 */
	protected function registerProviderInstance($provider) : ?ProviderInterface
	{
		if (! is_object($provider)) return null;
		if (! is_a($provider, ProviderInterface::class)) return null;

		$this->addProvider($provider);

		return $provider;
	}


	/**
	 * @param string $provider
	 *
	 * @return Di
	 */
	protected function pipeRemoveProvider($provider) : Di
	{
		$di = null
			?? $this->removeProviderInstance($provider)
			?? $this->removeProviderClass($provider);

		return $di;
	}

	/**
	 * @param mixed $provider
	 *
	 * @return Di
	 */
	protected function removeProviderInstance($provider) : ?Di
	{
		if (! is_object($provider)) return null;
		if (! is_a($provider, ProviderInterface::class)) return null;

		$di = $this->removeProviderClass(get_class($provider));

		return $di;
	}

	/**
	 * @param mixed $providerClass
	 *
	 * @return Di
	 */
	protected function removeProviderClass($providerClass) : ?Di
	{
		if (! is_string($providerClass)) return null;
		if ('' === $providerClass) return null;

		if (isset($this->providerSnapshots[ $providerClass ])) {
			foreach ( $this->providerSnapshots[ $providerClass ] as $key => $items ) {
				foreach ( $items as $idx => $item ) {
					unset($this->{$key}[ $idx ]);
				}
			}

			unset($this->providerSnapshots[ $providerClass ]);
		}

		if (is_a($deferableProvider = $providerClass, BootableProviderInterface::class, true)) {
			unset($this->providersBootable[ $providerClass ]);
		}

		if (is_a($deferableProvider = $providerClass, DeferableProviderInterface::class, true)) {
			foreach ( $this->bindDeferable as $id => $providers ) {
				unset($this->bindDeferable[ $id ][ $providerClass ]);
			}

			unset($this->providersDeferable[ $providerClass ]);
		}

		return $this;
	}


	/**
	 * @return static
	 */
	public static function getInstance() : Di
	{
		return static::$instance = static::$instance ?? new static();
	}

	/**
	 * @return static
	 */
	public static function resetInstance() : Di
	{
		return static::$instance = new static();
	}


	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public static function find(string $id)
	{
		return static::getInstance()->get($id);
	}

	/**
	 * @param string $id
	 *
	 * @return mixed
	 */
	public static function findOrFail(string $id)
	{
		return static::getInstance()->getOrFail($id);
	}


	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public static function make(string $id, ...$arguments)
	{
		return static::getInstance()->create($id, ...$arguments);
	}

	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public static function makeOrFail(string $id, ...$arguments)
	{
		return static::getInstance()->createOrFail($id, ...$arguments);
	}


	/**
	 * @var static
	 */
	protected static $instance;
}