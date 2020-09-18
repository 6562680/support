<?php

namespace Gzhegow\Di;

use Psr\Container\ContainerInterface;
use Gzhegow\Di\Exceptions\RuntimeException;
use Gzhegow\Di\Exceptions\Runtime\OverflowException;
use Gzhegow\Di\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Di\Exceptions\Exception\NotFoundException;
use Gzhegow\Di\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Di
 */
class Di implements
	DiInterface,
	ContainerInterface
{
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
	protected $providerSnapshots = [
		'items'   => [],
		'bind'    => [],
		'shared'  => [],
		'extends' => [],
	];

	/**
	 * @var bool
	 */
	protected $isBooted = false;


	/**
	 * Constructor
	 */
	public function __construct()
	{
		if (! isset(static::$instances[ static::class ])) {
			static::$instances[ static::class ] = $this;
		}

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
	}


	/**
	 * @param array $loop
	 *
	 * @return Loop
	 */
	public function newLoop(array $loop = [])
	{
		$instance = new Loop($this);

		( function () use ($loop) {
			$instance = $this;
			$instance->loop = $loop;
		} )->call($instance);

		return $instance;
	}


	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function getBind(string $id)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! $this->hasBind($id)) {
			throw new NotFoundException('Item not found: ' . $id);
		}

		$bind = $this->bind[ $id ];

		if ($this->hasDeferableBind($bind)) {
			$this->bootDeferable($bind);
		}

		return $bind;
	}

	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function getItem(string $id)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! $this->hasItem($id)) {
			throw new NotFoundException('Item not found: ' . $id);
		}

		$item = $this->items[ $id ];

		if ($this->hasDeferableBind($id)) {
			$this->bootDeferable($id);
		}

		return $item;
	}

	/**
	 * @param string $id
	 *
	 * @return array
	 * @throws NotFoundException
	 */
	public function getExtends(string $id) : array
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! $this->hasExtends($id)) {
			throw new NotFoundException('Extends not found: ' . $id);
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

		$this->providerRegistration($provider);

		if (is_a($bootableProvider = $provider, BootableProviderInterface::class)) {
			$this->providersBootable[ $class ] = $provider;

			if ($this->isBooted()) {
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
	 * @throws NotFoundException
	 */
	public function get($id)
	{
		if (! is_string($id)) {
			throw new InvalidArgumentException('Id should be string');
		}

		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		$result = $this->newLoop()->get($id);

		return $result;
	}

	/**
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function getOrFail(string $id)
	{
		try {
			$result = $this->get($id);
		}
		catch ( NotFoundException $e ) {
			throw new RuntimeException(null, null, $e);
		}

		return $result;
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
			|| $this->isClass($id);
	}


	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 * @throws OutOfRangeException
	 */
	public function set(string $id, $item)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if ($this->hasItem($id)) {
			throw new OutOfRangeException('Bind is already defined: ' . $id);
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
		catch ( OutOfRangeException $e ) {
			throw new RuntimeException(null, null, $e);
		}

		return $result;
	}


	/**
	 * @param string          $id
	 * @param string|\Closure $item
	 * @param bool            $shared
	 *
	 * @return Di
	 */
	public function replace(string $id, $item, bool $shared = false)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		$this->items[ $id ] = $item;

		return $this;
	}


	/**
	 * @param mixed $func
	 *
	 * @return bool
	 */
	protected function isCallable($func) : bool
	{
		return ( is_array($func) || is_string($func) )
			&& is_callable($func);
	}

	/**
	 * @param mixed $class
	 *
	 * @return bool
	 */
	protected function isClass($class) : bool
	{
		return is_string($class) && class_exists($class);
	}

	/**
	 * @param mixed $func
	 *
	 * @return bool
	 */
	protected function isClosure($func) : bool
	{
		return is_object($func) && ( get_class($func) === \Closure::class );
	}

	/**
	 * @param mixed $handler
	 *
	 * @return bool
	 */
	protected function isHandler($handler) : bool
	{
		return is_string($handler)
			&& ( '' !== $handler )
			&& ( $handler[ 0 ] !== '@' )
			&& ( false !== strpos($handler, '@') );
	}

	/**
	 * @param string $configPath
	 *
	 * @return $this
	 */
	public function loadConfig(string $configPath)
	{
		if ('' === $configPath) {
			throw new InvalidArgumentException('ConfigPath should be not empty');
		}

		require_once $configPath;

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
	 * @throws OutOfRangeException
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

		$isBind = ( 0
			|| ( $isClosure = $this->isClosure($bind) )
			|| ( $isClass = $this->isClass($bind) )
		);

		if (! $isBind) {
			throw new InvalidArgumentException('Bind should be closure or class name');
		}

		$this->bind[ $id ] = $bind;

		if ($shared) {
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
			|| $this->isClosure($func)
			|| $this->isCallable($func)
		)) {
			throw new InvalidArgumentException('Func should be closure, handler or callable');
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
			$this->providerBooting($provider);
		}

		return $this;
	}

	/**
	 * @param string $id
	 *
	 * @return Di
	 * @throws NotFoundException
	 */
	public function bootDeferable(string $id)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! $this->hasDeferableBind($id)) {
			throw new NotFoundException('Deferable bind not found: ' . $id);
		}

		foreach ( $this->bindDeferable[ $id ] as $provider => $bool ) {
			$this->providerBooting($this->providersDeferable[ $provider ]);
		}

		return $this;
	}


	/**
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function createAutowired(string $id, array $params = [])
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		$result = $this->newLoop()->createAutowired($id, $params);

		return $result;
	}

	/**
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 */
	public function createAutowiredOrFail(string $id, array $params = [])
	{
		try {
			$result = $this->createAutowired($id, $params);
		}
		catch ( NotFoundException $e ) {
			throw new RuntimeException(null, null, $e);
		}

		return $result;
	}


	/**
	 * @param object $newthis
	 * @param mixed  $func
	 * @param mixed  ...$arguments
	 *
	 * @return mixed
	 */
	public function call($newthis, $func, ...$arguments)
	{
		$result = $this->apply($newthis, $func, $arguments);

		return $result;
	}

	/**
	 * @param mixed $newthis
	 * @param mixed $func
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function apply($newthis, $func, array $params = [])
	{
		if (! ( 0
			|| ( $this->isClosure($func) )
			|| ( $this->isCallable($func) )
		)) {
			throw new InvalidArgumentException('Func should be closure, handler or callable');
		}

		$result = $this->newLoop()->apply($newthis, $func, $params);

		return $result;
	}


	/**
	 * @param callable $func
	 * @param array    $params
	 *
	 * @return mixed
	 */
	public function handle($func, array $params = [])
	{
		if (! ( 0
			|| ( $this->isHandler($func) )
			|| ( $this->isClosure($func) )
			|| ( $this->isCallable($func) )
		)) {
			throw new InvalidArgumentException('Func should be handler, closure or callable');
		}

		$result = $this->newLoop()->handle($func, $params);

		return $result;
	}


	/**
	 * @param ProviderInterface $provider
	 *
	 * @return Di
	 */
	protected function providerRegistration(ProviderInterface $provider)
	{
		if ($provider->isRegistered()) {
			return $this;
		}

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
	 * @param BootProviderInterface $provider
	 *
	 * @return Di
	 */
	protected function providerBooting(BootProviderInterface $provider)
	{
		if (! $provider->isBooted()) {
			$provider->boot();
		}

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

		$instance = $this->createAutowiredOrFail($provider);

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
		return static::$instances[ static::class ] = static::$instances[ static::class ]
			?? new static();
	}


	/**
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public static function make(string $id, array $params = [])
	{
		return static::getInstance()->createAutowired($id, $params);
	}

	/**
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 */
	public static function makeOrFail(string $id, array $params = [])
	{
		return static::getInstance()->createAutowiredOrFail($id, $params);
	}


	/**
	 * @var array
	 */
	protected static $instances = [];
}