<?php

namespace Gzhegow\Di;

use Psr\Container\ContainerInterface;
use Gzhegow\Di\Exceptions\RuntimeException;
use Gzhegow\Di\Exceptions\OutOfRangeException;
use Gzhegow\Di\Exceptions\InvalidArgumentException;

/**
 * Class Di
 */
class Di implements ContainerInterface, DiInterface
{
	/**
	 * @var array
	 */
	protected $items = [];

	/**
	 * @var array
	 */
	protected $shared = [];
	/**
	 * @var array
	 */
	protected $bind = [];

	/**
	 * @var array
	 */
	protected $extends = [];


	/**
	 * Constructor
	 */
	public function __construct()
	{
		if (! isset(static::$instances[ static::class ])) {
			static::$instances[ static::class ] = $this;
		}

		$this->setSharedOrFail(static::class, $this);
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
		catch ( OutOfRangeException $e ) {
			throw new RuntimeException('Unable to ' . __METHOD__, null, $e);
		}

		return $result;
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
	public function hasItem($id) : bool
	{
		return is_string($id) && isset($this->items[ $id ]);
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
			throw new RuntimeException('Unable to ' . __METHOD__, null, $e);
		}

		return $result;
	}


	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws OutOfRangeException
	 */
	public function get($id)
	{
		if (! is_string($id)) {
			throw new InvalidArgumentException('Id should be string');
		}

		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if ($this->hasItem($id)) {
			return $this->items[ $id ];
		}

		if ($this->hasBind($id)) {
			$bind = $this->bind[ $id ];

			if (is_string($bind) && $this->hasItem($bind)) {
				return $this->items[ $bind ];
			}
		}

		$item = $this->createAutowired($id);

		return $item;
	}


	/**
	 * @param string $id
	 *
	 * @return bool
	 */
	public function has($id)
	{
		return $this->hasItem($id)
			|| $this->hasBind($id)
			|| ( is_string($id) && class_exists($id) );
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
	 * @param \Closure $func
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
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 * @throws OutOfRangeException
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
			throw new OutOfRangeException('Bind not found: ' . $id);

		}

		switch ( true ):
			case ( is_string($bind) && class_exists($bind) ):
				$arguments = $this->autowireClass($bind, $params);

				$item = new $bind(...$arguments);

				if (isset($this->shared[ $bind ])) {
					if (! isset($this->items[ $bind ])) {
						$this->items[ $bind ] = $item;
					}
				}

				break;

			case ( is_object($bind) && is_a($bind, \Closure::class) ):
				$item = $this->callAutowired($bind, $params);

				break;

			default:
				throw new \RuntimeException('Incorrect bind found');

		endswitch;

		if (isset($this->extends[ $id ])) {
			foreach ( $this->extends[ $id ] as $func ) {
				$item = $this->callAutowired($func, [ $item ])
					?? $item; // if null returns previous instance
			}
		}

		if (isset($this->shared[ $id ])) {
			if (! isset($this->items[ $id ])) {
				$this->items[ $id ] = $item;
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
		catch ( OutOfRangeException $e ) {
			throw new \RuntimeException('Unable to ' . __METHOD__, null, $e);
		}

		return $result;
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
			throw new InvalidArgumentException('Bind should be not empty');
		}

		if ($this->hasBind($id)) {
			throw new \RuntimeException('Bind is already defined');
		}

		return $this->rebind($id, $bind, $shared);
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
		switch ( true ):
			case ( is_string($bind) ):
			case ( $this->isClosure($bind) ):
				$this->bind[ $id ] = $bind;

				if ($shared) {
					$this->shared[ $id ] = true;
				}
				break;

			default:
				throw new InvalidArgumentException('Bind should be string or closure: ' . $id);

		endswitch;

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
	 * @param string   $id
	 * @param \Closure $func
	 *
	 * @return Di
	 */
	public function extend(string $id, \Closure $func)
	{
		$this->extends[ $id ][] = $func;

		return $this;
	}


	/**
	 * @param callable $func
	 * @param array    $params
	 *
	 * @return mixed
	 */
	public function callAutowired(callable $func, array $params = [])
	{
		switch ( true ) {
			case $this->isClosure($func):
				$arguments = $this->autowireClosure($func, $params);
				break;

			case $this->isHandler($func):
				$arguments = $this->autowireHandler($func, $params);
				break;

			case $this->isCallable($func):
				$arguments = $this->autowireMethod($func[ 0 ], $func[ 1 ], $params);
				break;

			default:
				throw new \InvalidArgumentException('Incorrect callable passed');
		}

		$result = call_user_func_array($func, $arguments);

		return $result;
	}

	/**
	 * @param callable $func
	 * @param array    $params
	 *
	 * @return mixed
	 */
	public function callAutowiredOrFail(callable $func, array &$params = [])
	{
		try {
			$result = $this->callAutowired($func, $params);
		}
		catch ( \Exception $e ) {
			throw new \RuntimeException('Unable to ' . __METHOD__, null, $e);
		}

		return $result;
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

		return isset($rm)
			? $this->autowireParams($rm->getParameters(), $params)
			: [];
	}

	/**
	 * @param \Closure $func
	 * @param array    $params
	 *
	 * @return array
	 */
	protected function autowireCallable(\Closure $func, array &$params = []) : array
	{
		$rf = $this->reflectClosure($func);

		return $this->autowireParams($rf->getParameters(), $params);
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

		return $this->autowireParams($rf->getParameters(), $params);
	}

	/**
	 * @param mixed $handler
	 * @param array $params
	 *
	 * @return array
	 * @noinspection PhpUnusedParameterInspection
	 */
	protected function autowireHandler($handler, array &$params = []) : array
	{
		[ $id, $method ] = explode('@', $handler) + [ null, null ];

		return $this->autowireMethod($this->getOrFail($id), $method);
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
					catch ( \Exception $e ) {
						throw new \RuntimeException('Unable to ' . __METHOD__, null, $e);
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
				[ $rpPos => $item ],
				array_slice($int, $rpPos, null, true)
			);
		}

		return $int[ $rpPos ]
			?? null;
	}


	/**
	 * @param $object
	 *
	 * @return \ReflectionClass
	 */
	protected function reflectClass($object) : \ReflectionClass
	{
		try {
			$rc = new \ReflectionClass($object);
		}
		catch ( \ReflectionException $e ) {
			throw new \RuntimeException('Unable to ' . __METHOD__);
		}

		return $rc;
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
			throw new \RuntimeException('Unable to ' . __METHOD__);
		}

		return $rf;
	}

	/**
	 * @param \ReflectionClass $rc
	 * @param string           $method
	 *
	 * @return \ReflectionMethod
	 */
	protected function reflectMethod(\ReflectionClass $rc, string $method) : \ReflectionMethod
	{
		try {
			$rm = $rc->getMethod($method);
		}
		catch ( \ReflectionException $e ) {
			throw new \RuntimeException('Unable to ' . __METHOD__);
		}

		return $rm;
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
	public static function getInstance()
	{
		return static::$instances[ static::class ] = static::$instances[ static::class ] ?? new static();
	}


	/**
	 * @param string $id
	 * @param array  $params
	 *
	 * @return mixed
	 */
	public static function make(string $id, array $params = [])
	{
		return static::getInstance()->createAutowiredOrFail($id, $params);
	}


	/**
	 * @var array
	 */
	protected static $instances = [];
}
