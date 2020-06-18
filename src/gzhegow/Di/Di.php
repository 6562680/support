<?php

namespace Gzhegow\Di;

use Psr\Container\ContainerInterface;
use Gzhegow\Di\Exceptions\RuntimeException;
use Gzhegow\Di\Exceptions\OverflowException;
use Gzhegow\Di\Exceptions\NotFoundException;
use Gzhegow\Di\Exceptions\OutOfRangeException;
use Gzhegow\Di\Exceptions\InvalidArgumentException;

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
	 * @var array
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
	 * @var DeferableProviderInterface[][]
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

		if (! $this->hasShared(static::class)) {
			$this->setSharedOrFail(static::class, $this);
		}
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
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 * @throws OutOfRangeException()
	 */
	public function setShared(string $id, $item)
	{
		$this->set($id, $item, $shared = true);

		return $this;
	}

	/**
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return mixed
	 */
	public function setSharedOrFail(string $id, $item)
	{
		try {
			$result = $this->setShared($id, $item);
		}
		catch ( OutOfRangeException $e ) {
			throw new RuntimeException(null, null, $e);
		}

		return $result;
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

		$class = get_class($provider);

		$this->providers[ $class ] = $provider;

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

		$result = null;

		if ($this->hasItem($id)) {
			$result = $this->getItem($id);

		} else {
			if ($this->hasBind($id)) {
				$bind = $this->bind[ $id ];

				if ($this->hasItem($bind)) {
					$result = $this->getItem($bind);
				}

			} else {
				$bind = $id;

			}

			if (! $result) {
				$result = $this->createAutowired($bind);
			}
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
	 * @param bool   $shared
	 *
	 * @return Di
	 * @throws OutOfRangeException()
	 */
	public function set(string $id, $item, bool $shared = false)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if ($this->hasItem($id)) {
			throw new OutOfRangeException('Bind is already defined: ' . $id);
		}

		$this->items[ $id ] = $item;

		if ($shared) {
			$this->shared[ $id ] = true;
		}

		return $this;
	}


	/**
	 * @param string|array $func
	 *
	 * @return bool
	 */
	protected function isCallable($func) : bool
	{
		return ( is_array($func) || is_string($func) )
			&& is_callable($func);
	}

	/**
	 * @param string $class
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
	 * @param string $handler
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
			|| ( $isClosure = $this->isClosure($bind) )
			|| ( $isClass = $this->isClass($bind) )
		)) {
			throw new InvalidArgumentException('Bind should be class name or closure');
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
	 * @param string $id
	 * @param mixed  $item
	 *
	 * @return Di
	 * @throws OutOfRangeException()
	 */
	public function singleton(string $id, $item)
	{
		$this->setShared($id, $item);

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
			|| $this->isHandler($func)
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

		foreach ( $this->bindDeferable[ $id ] as $provider ) {
			$this->providerBooting($provider);
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

		if ($this->hasBind($id)) {
			$bind = $this->bind[ $id ];

		} elseif (class_exists($id)) {
			$bind = $id;

		} else {
			throw new NotFoundException('Bind not found: ' . $id);

		}

		if ($this->hasDeferableBind($bind)) {
			$this->bootDeferable($bind);
		}

		switch ( true ):
			case ( $this->isClosure($bind) ):
				$item = $this->callAutowired($bind, $params);

				break;

			case ( $this->isClass($bind) ):
				$arguments = $this->autowireClass($bind, $params);
				$item = new $bind(...$arguments);

				break;

			default:
				throw new RuntimeException('Unsupported bind type: ' . gettype($bind));

		endswitch;

		if ($this->hasExtends($id)) {
			foreach ( $this->extends[ $id ] as $func ) {
				$item = null
					?? $this->callAutowired($func, [
						0   => $item,
						$id => $item,
					])
					?? $item;
			}
		}

		foreach ( [ $id, $bind ] as $key ) {
			if ($this->hasShared($key)) {
				if (! isset($this->items[ $key ])) {
					$this->items[ $key ] = $item;
				}
			}
		}

		return $item;
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
	 * @param callable $func
	 * @param array    $params
	 *
	 * @return mixed
	 */
	public function callAutowired(callable $func, array $params = [])
	{
		if (! ( 0
			|| $this->isClosure($func)
			|| $this->isHandler($func)
			|| $this->isCallable($func)
		)) {
			throw new InvalidArgumentException('Func should be closure, handler or callable');
		}

		$arguments = [];
		switch ( true ) {
			case $this->isClosure($func):
				$arguments = $this->autowireClosure($func, $params);
				break;

			case $this->isHandler($func):
				$arguments = $this->autowireHandler($func, $params);
				break;

			case $this->isCallable($func):
				$arguments = $this->autowireCallable($func, $params);
				break;
		}

		$result = call_user_func_array($func, $arguments);

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
		$instance = $this->registerProviderClass($provider)
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

		$this->addProvider($instance);

		return $instance;
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
	 * @param string $class
	 * @param array  $params
	 *
	 * @return array
	 */
	protected function autowireClass(string $class, array &$params = []) : array
	{
		$rc = $this->reflectClass($class);
		$rm = $rc->getConstructor();

		$result = isset($rm)
			? $this->autowireParams($rm->getParameters(), $params)
			: [];

		return $result;
	}


	/**
	 * @param       $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function autowireCallable($callable, array &$params = []) : array
	{
		if (! $this->isCallable($callable)) {
			throw new InvalidArgumentException('Callable should be callable');
		}

		$rf = $this->reflectCallable($callable);

		$result = $this->autowireParams($rf->getParameters(), $params);

		return $result;
	}

	/**
	 * @param \Closure $func
	 * @param array    $params
	 *
	 * @return array
	 */
	protected function autowireClosure(\Closure $func, array &$params = []) : array
	{
		$rf = $this->reflectClosure($func);

		$result = $this->autowireParams($rf->getParameters(), $params);

		return $result;
	}

	/**
	 * @param mixed $handler
	 * @param array $params
	 *
	 * @return array
	 * @noinspection PhpUnusedParameterInspection
	 */
	protected function autowireHandler(string $handler, array &$params = []) : array
	{
		if (! $this->isHandler($handler)) {
			throw new InvalidArgumentException('Handler should be handler-like');
		}

		[ $id, $method ] = explode('@', $handler) + [ null, null ];

		$result = $this->autowireMethod($this->getOrFail($id), $method);

		return $result;
	}


	/**
	 * @param mixed  $object
	 * @param string $method
	 * @param array  $params
	 *
	 * @return array
	 */
	protected function autowireMethod($object, string $method, array &$params = []) : array
	{
		if (! is_object($object)) {
			throw new InvalidArgumentException('Object should be object');
		}

		$rc = $this->reflectClass($object);
		$rm = $this->reflectMethod($rc, $method);

		return $this->autowireParams($rm->getParameters(), $params);
	}


	/**
	 * @param \ReflectionParameter[] $reflectionParameters
	 * @param array                  $params
	 *
	 * @return array
	 */
	protected function autowireParams(array $reflectionParameters, array &$params = []) : array
	{
		$int = [];
		$str = [];
		foreach ( $params as $key => $val ) {
			if (! is_string($key)) {
				$int[ $key ] = $val;
			} else {
				$str[ $key ] = $val;
			}
		}

		$args = [];

		foreach ( $reflectionParameters as $rp ) {
			$pos = $rp->getPosition();
			$value = $this->autowireParam($rp, $int, $str);

			if (( isset($value) || ! $rp->isVariadic() )) {
				$args[ $pos ] = $value;
			}
		}

		$args += $int;

		return $args;
	}

	/**
	 * @param \ReflectionParameter $rp
	 * @param array                $int
	 * @param array                $str
	 *
	 * @return mixed
	 */
	protected function autowireParam(\ReflectionParameter $rp, array &$int = [], array &$str = [])
	{
		$rpPos = $rp->getPosition();

		$item = null;
		if ($rpType = $rp->getType()) {
			if (isset($str[ $rpTypeName = $rpType->getName() ])) {
				$item = $str[ $rpTypeName ];

			} elseif (interface_exists($rpTypeName)
				|| class_exists($rpTypeName)
			) {
				if (isset($int[ $rpPos ]) && is_object($int[ $rpPos ]) && is_a($int[ $rpPos ], $rpTypeName)) {
					// get by position
					return $int[ $rpPos ];

				} else {
					try {
						$item = $this->get($rpTypeName);
					}
					catch ( NotFoundException $e ) {
						throw new RuntimeException(null, null, $e);
					}
				}
			}

		} elseif (isset($str[ '$' . ( $rpName = $rp->getName() ) ])) {
			$item = $str[ '$' . $rpName ];

		} elseif (! isset($int[ $rpPos ])) {
			$item = $this->reflectParamDefaultValue($rp);

		}

		if (isset($item)) {
			$int = array_merge(
				array_slice($int, 0, $rpPos, true),
				[ $rpPos => $item ], // insert between
				array_slice($int, $rpPos, null, true)
			);
		}

		return $int[ $rpPos ]
			?? null;
	}


	/**
	 * @param string|object $object
	 *
	 * @return \ReflectionClass
	 */
	protected function reflectClass($object) : \ReflectionClass
	{
		try {
			if (is_object($object)) {
				if (is_a($object, \ReflectionClass::class)) {
					$rc = $object;

				} else {
					$rc = new \ReflectionClass(get_class($object));

				}
			} else {
				$rc = new \ReflectionClass($object);

			}
		}
		catch ( \ReflectionException $e ) {
			throw new RuntimeException(null, null, $e);
		}

		return $rc;
	}

	/**
	 * @param        $object
	 * @param string $method
	 *
	 * @return \ReflectionMethod
	 */
	protected function reflectMethod($object, string $method) : \ReflectionMethod
	{
		/** @var \ReflectionClass $reflectionClass */

		try {
			if (is_object($object) && is_a($reflectionClass = $object, \ReflectionClass::class)) {
				$rm = $reflectionClass->getMethod($method);

			} else {
				$rm = new \ReflectionMethod($object, $method);

			}
		}
		catch ( \ReflectionException $e ) {
			throw new RuntimeException(null, null, $e);
		}

		return $rm;
	}


	/**
	 * @param \Closure $func
	 *
	 * @return \ReflectionFunction
	 */
	protected function reflectClosure(\Closure $func) : \ReflectionFunction
	{
		try {
			$rf = new \ReflectionFunction($func);
		}
		catch ( \ReflectionException $e ) {
			throw new RuntimeException(null, null, $e);
		}

		return $rf;
	}

	/**
	 * @param callable $callable
	 *
	 * @return \ReflectionFunction|\ReflectionMethod
	 */
	protected function reflectCallable($callable)
	{
		try {
			if ($this->isClosure($callable)) {
				$rf = $this->reflectClosure($callable);

			} elseif (is_array($callable)) {
				$rf = $this->reflectMethod($callable[ 0 ], $callable[ 1 ]);

			} else {
				$rf = new \ReflectionFunction($callable);

			}
		}
		catch ( \ReflectionException $e ) {
			throw new RuntimeException(null, null, $e);
		}

		return $rf;
	}


	/**
	 * @param \ReflectionParameter $rp
	 *
	 * @return mixed
	 */
	protected function reflectParamDefaultValue(\ReflectionParameter $rp)
	{
		try {
			$value = $rp->getDefaultValue();
		}
		catch ( \ReflectionException $e ) {
			$value = null;
		}

		return $value;
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
