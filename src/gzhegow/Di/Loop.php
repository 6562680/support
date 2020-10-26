<?php

namespace Gzhegow\Di;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Php;
use Gzhegow\Support\Type;
use Gzhegow\Support\Reflection;
use Psr\Container\ContainerInterface;
use Gzhegow\Di\Exceptions\RuntimeException;
use Gzhegow\Di\Exceptions\Error\NotFoundError;
use Gzhegow\Di\Exceptions\Runtime\Error\AutowireError;
use Gzhegow\Di\Exceptions\Logic\InvalidArgumentException;
use Gzhegow\Di\Exceptions\Runtime\Error\AutowireLoopError;
use Gzhegow\Di\Exceptions\Runtime\Error\NoDelegateClassError;

/**
 * Class Loop
 */
class Loop
{
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
	 * @var Reflection
	 */
	protected $reflection;

	/**
	 * @var Di
	 */
	protected $di;

	/**
	 * @var array
	 */
	protected $parent = null;
	/**
	 * @var string
	 */
	protected $loopKey = null;


	/**
	 * Constructor
	 *
	 * @param Di        $di
	 * @param Loop|null $parent
	 */
	public function __construct(Di $di, Loop $parent = null)
	{
		$this->di = $di;

		$this->parent = $parent;
	}

	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return null|mixed
	 * @throws NotFoundError
	 */
	public function create(string $id, ...$arguments)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		if (! ( 0
			|| ( $hasBind = $this->di->hasBind($id) )
			|| ( $isClass = $this->requireType()->isClass($id) )
		)) {
			throw new NotFoundError('Bind not found: ' . $id);
		}

		$loopKey = $id;

		$bind = $id;
		if ($hasBind) {
			$bind = $this->di->getBind($id);

			if (! $this->requireType()->isClosure($bind)) {
				$loopKey = $bind;
			}
		}

		$parent = $this;
		while ( $parent = $parent->parent ) {
			$stack[] = $loopKey;

			if ($parent->loopKey === $loopKey) {
				throw new AutowireLoopError(sprintf(
					'Autowire loop: %s is required in [ %s ]',
					$bind, implode(' <- ', array_reverse($stack))
				));
			}
		}

		$this->loopKey = $loopKey;

		if ($this->di->hasDeferableBind($bind)) {
			$this->di->bootDeferable($bind);
		}

		switch ( true ):
			case ( $this->requireType()->isClosure($bind) ):
				$item = $this->handle($bind, ...$arguments);

				break;

			case ( $this->requireType()->isClass($bind) ):
				[ $kwargs, $args ] = $this->requirePhp()->kwparams(...$arguments);

				$arguments = $this->autowireClass($bind, array_merge($args, $kwargs));
				ksort($arguments);

				$item = new $bind(...$arguments);

				break;

			default:
				throw new RuntimeException('Unsupported bind type: ' . gettype($bind));

		endswitch;

		if ($this->di->hasExtends($id)) {
			foreach ( $this->di->getExtends($id) as $func ) {
				$item = null
					?? $this->handle($func, [
						$id => $item,
					])
					?? $item;
			}
		}

		if ($this->di->hasShared($id)) {
			if (! $this->di->hasItem($id)) {
				$this->di->set($id, $item);
			}
		}

		if ($this->di->hasShared($bind)) {
			if (! $this->di->hasItem($bind)) {
				$this->di->set($bind, $item);
			}
		}

		return $item;
	}

	/**
	 * @param Arr|null $arr
	 *
	 * @return Arr
	 */
	public function requireArr(Arr $arr = null) : Arr
	{
		return $this->arr = $arr
			?? $this->arr
			?? $this->di->requireArr();
	}

	/**
	 * @param Php|null $php
	 *
	 * @return Php
	 */
	public function requirePhp(Php $php = null) : Php
	{
		return $this->php = $php
			?? $this->php
			?? $this->di->requirePhp();
	}

	/**
	 * @param Type|null $type
	 *
	 * @return Type
	 */
	public function requireType(Type $type = null) : Type
	{
		return $this->type = $type
			?? $this->type
			?? $this->di->requireType();
	}

	/**
	 * @param Reflection|null $reflection
	 *
	 * @return Reflection
	 */
	public function requireReflection(Reflection $reflection = null) : Reflection
	{
		return $this->reflection = $reflection
			?? $this->reflection
			?? $this->di->requireReflection();
	}

	/**
	 * @param string $id
	 *
	 * @return null|mixed
	 */
	protected function getAsChild(string $id)
	{
		try {
			$instance = $this->di->newLoop($this)->get($id);
		}
		catch ( NotFoundError $exception ) {
			throw new RuntimeException(null, null, $exception);
		}

		return $instance;
	}

	/**
	 * @param string $id
	 *
	 * @return null|mixed
	 * @throws NotFoundError
	 */
	public function get(string $id)
	{
		if (! is_string($id)) {
			throw new InvalidArgumentException('Id should be string');
		}

		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		$result = null;

		if ($this->di->hasItem($id)) {
			$result = $this->di->getItem($id);

		} else {
			if (! $this->di->hasBind($id)) {
				$bind = $id;

			} else {
				$bind = $this->di->getBind($id);

				if ($this->requireType()->isClosure($bind)) {
					$bind = $id;

				} elseif ($this->di->hasItem($bind)) {
					$result = $this->di->getItem($bind);

				}
			}

			if (! $result) {
				$result = $this->create($bind);
			}
		}

		return $result;
	}


	/**
	 * @param callable $func
	 * @param array    $arguments
	 *
	 * @return mixed
	 */
	public function handle($func, ...$arguments)
	{
		/** @var \Closure $closure */

		if (! ( 0
			|| ( $isHandler = $this->requireType()->isHandler($func) )
			|| ( $isClosure = $this->requireType()->isClosure($func) )
			|| ( $isCallable = $this->requireType()->isCallableArray($func) )
		)) {
			throw new InvalidArgumentException('Func should be closure, handler or callable');
		}

		[ $kwargs, $args ] = $this->requirePhp()->kwparams(...$arguments);

		$params = array_merge($args, $kwargs);

		$arguments = [];
		switch ( true ) {
			case $isHandler:
				[ $id, $method ] = explode('@', $func) + [ null, null ];

				$func = [ $object = $this->getAsChild($id), $method ];

				$arguments = $this->autowireMethod($object, $method, $params);

				break;

			case $isClosure:
				$arguments = $this->autowireClosure($func, $params);
				break;

			case $isCallable:
				$arguments = $this->autowireCallable($func, $params);
				break;
		}

		ksort($arguments);

		$result = call_user_func_array($func, $arguments);

		return $result;
	}

	/**
	 * @param object   $newthis
	 * @param callable $func
	 * @param array    $arguments
	 *
	 * @return mixed
	 */
	public function call($newthis, $func, ...$arguments)
	{
		/** @var \Closure $closure */

		if (! is_object($newthis)) {
			throw new InvalidArgumentException('NewThis should be object');
		}

		if (! ( 0
			|| ( $isCallable = $this->requireType()->isHandler($func) )
			|| ( $isClosure = $this->requireType()->isClosure($func) )
			|| ( $isCallable = $this->requireType()->isCallable($func) )
		)) {
			throw new InvalidArgumentException('Func should be closure, handler or callable');
		}

		[ $kwargs, $args ] = $this->requirePhp()->kwparams(...$arguments);

		$params = array_merge($args, $kwargs)
			+ [ get_class($newthis) => $newthis ];

		$arguments = [];
		switch ( true ) {
			case $isClosure:
				$arguments = $this->autowireClosure($func, $params);
				break;

			case $isCallable:
				$arguments = $this->autowireCallable($func, $params);
				break;
		}

		switch ( true ) {
			case $isClosure:
				$closure = $func;
				break;

			case $isCallable:
				$closure = \Closure::fromCallable($func);
				break;
		}

		ksort($arguments);

		$result = $closure->call($newthis, ...$arguments);

		return $result;
	}


	/**
	 * @param string $class
	 * @param array  $params
	 *
	 * @return array
	 */
	protected function autowireClass(string $class, array $params = []) : array
	{
		$rm = $this->requireReflection()->reflectClass($class)->getConstructor();

		$result = isset($rm)
			? $this->autowireParams($rm->getParameters(), $params)
			: [];

		return $result;
	}


	/**
	 * @param mixed  $class
	 * @param string $method
	 * @param array  $params
	 *
	 * @return array
	 */
	protected function autowireMethod($class, string $method, array $params = []) : array
	{
		if (! ( 0
			|| is_string($class)
			|| is_object($class)
		)) {
			throw new InvalidArgumentException('Object should be typeof object');
		}

		$result = null
			?? $this->autowireMethodClass($class, $method, $params)
			?? $this->autowireMethodObject($object = $class, $method, $params);

		return $result;
	}

	/**
	 * @param mixed  $class
	 * @param string $method
	 * @param array  $params
	 *
	 * @return array
	 */
	protected function autowireMethodClass($class, string $method, array $params = []) : ?array
	{
		if (! is_string($class)) return null;

		$rm = $this->requireReflection()->reflectMethod(
			$this->requireReflection()->reflectClass($class),
			$method
		);

		$result = $this->autowireParams($rm->getParameters(), $params);

		return $result;
	}

	/**
	 * @param mixed  $class
	 * @param string $method
	 * @param array  $params
	 *
	 * @return array
	 */
	protected function autowireMethodObject($class, string $method, array $params = []) : array
	{
		if (! is_object($class)) return null;

		$rm = $this->requireReflection()->reflectMethod(
			$this->requireReflection()->reflectClass($class),
			$method
		);

		$result = $this->autowireParams($rm->getParameters(), $params);

		return $result;
	}


	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function autowireCallable($callable, array $params = []) : array
	{
		$result = null
			?? $this->autowireCallableArray($callable, $params)
			?? $this->autowireCallableClosure($callable, $params)
			?? $this->autowireCallableString($callable, $params);

		return $result;
	}


	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function autowireCallableArray($callable, array $params = []) : ?array
	{
		if (! is_array($callable)) return null;

		if (! $this->requireType()->isCallableArray($callable)) {
			throw new InvalidArgumentException('Callable should be callable');
		}

		$rm = $this->requireReflection()->reflectMethod($callable[ 0 ], $callable[ 1 ]);

		$result = null
			?? $this->autowireCallableMethodPublic($rm, $callable[ 0 ], $params)
			?? $this->autowireCallableMethodStatic($rm, $params);

		return $result;
	}

	/**
	 * @param \ReflectionMethod $rm
	 * @param mixed             $object
	 * @param array             $params
	 *
	 * @return array
	 */
	protected function autowireCallableMethodPublic(\ReflectionMethod $rm, $object, array $params = []) : ?array
	{
		if ($rm->isStatic()) return null;

		if (! is_object($object)) {
			throw new InvalidArgumentException('Object should be instance');
		}

		$result = $this->autowireParams($rm->getParameters(), $params);

		return $result;
	}

	/**
	 * @param \ReflectionMethod $rm
	 * @param array             $params
	 *
	 * @return array
	 */
	protected function autowireCallableMethodStatic(\ReflectionMethod $rm, array $params = []) : ?array
	{
		if (! $rm->isStatic()) return null;

		$result = $this->autowireParams($rm->getParameters(), $params);

		return $result;
	}

	/**
	 * @param mixed $closure
	 * @param array $params
	 *
	 * @return array
	 */
	protected function autowireCallableClosure($closure, array $params = []) : ?array
	{
		if (! is_object($closure)) return null;

		if (! $this->requireType()->isClosure($closure)) {
			throw new InvalidArgumentException('Closure should be correct closure');
		}

		$result = $this->autowireClosure($closure, $params);

		return $result;
	}

	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function autowireCallableString($callable, array $params = []) : ?array
	{
		if (! is_string($callable)) return null;

		if (! $this->requireType()->isCallableString($callable)) {
			throw new InvalidArgumentException('Callable should be correct callable');
		}

		$rf = $this->requireReflection()->reflectCallable($callable);

		$result = $this->autowireParams($rf->getParameters(), $params);

		return $result;
	}


	/**
	 * @param mixed $closure
	 * @param array $params
	 *
	 * @return array
	 */
	protected function autowireClosure($closure, array $params = []) : ?array
	{
		if (! $this->requireType()->isClosure($closure)) {
			throw new InvalidArgumentException('Closure should be correct closure');
		}

		$rf = $this->requireReflection()->reflectClosure($closure);

		$result = $this->autowireParams($rf->getParameters(), $params);

		return $result;
	}


	/**
	 * @param \ReflectionParameter[] $reflectionParameters
	 * @param array                  $params
	 *
	 * @return array
	 */
	protected function autowireParams(array $reflectionParameters, array $params = []) : array
	{
		$used = [];

		$append = [
			DiInterface::class,
			Di::class,
			'$di',

			ContainerInterface::class,
			'$container',
		];
		foreach ( $append as $key ) {
			$params += [ $key => $this->di ];
		}

		$int = [];
		$str = [];
		foreach ( $params as $key => $val ) {
			if (is_int($key)) {
				$int[ $key ] = $val;
			} else {
				$str[ $key ] = $val;
			}
		}

		$args = [];

		if ($reflectionParameters) {
			foreach ( $reflectionParameters as $rp ) {
				$result = $this->autowireParam($rp, $int, $str, $used);

				if (count($result)) {
					$args[ $rp->getPosition() ] = reset($result);
					continue;
				}

				if ($rp->isVariadic()) {
					continue;
				}

				throw new AutowireError(
					sprintf('Unable to autowire parameter %d (%s)', $rp->getPosition(), $rp->getName())
				);
			}
		}

		$keys = array_keys($args);
		sort($keys);

		$result = [];
		$idx = 0;
		foreach ( $keys as $key ) {
			if (! is_int($key)) {
				$key = $idx;
			}

			$result[ $key ] = $args[ $key ];
			$idx++;
		}

		return $result;
	}

	/**
	 * @param \ReflectionParameter $rp
	 * @param array                $int
	 * @param array                $str
	 * @param array                $used
	 *
	 * @return array
	 */
	protected function autowireParam(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = []) : array
	{
		$order = [
			[ $this, 'autowireParamType' ],
			[ $this, 'autowireParamName' ],
			[ $this, 'autowireParamPosition' ],
			[ $this, 'autowireParamDefault' ],
		];

		$autowireResult = [];

		foreach ( $order as $func ) {
			$autowireResult = $func($rp, $int, $str, $used);

			if (count($autowireResult)) {
				break;
			}
		}

		return $autowireResult;
	}

	/**
	 * @param \ReflectionParameter $rp
	 * @param array                $int
	 * @param array                $str
	 * @param array                $used
	 *
	 * @return array
	 */
	protected function autowireParamType(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = []) : array
	{
		if (! $rpType = $rp->getType()) return [];
		if (! $rpTypeName = $rpType->getName()) return [];

		if (array_key_exists($rpTypeName, $str)
			&& is_object($str[ $rpTypeName ])
			&& is_a($str[ $rpTypeName ], $rpTypeName)
		) {
			$value = $str[ $rpTypeName ];

			$used[ $rpTypeName ] = true;

			$int = $this->requireArr()->expand($int, $rp->getPosition(), $value);

			return [ $value ];

		} elseif (interface_exists($rpTypeName) || class_exists($rpTypeName)) {
			$isNull = false;
			try {
				$value = $rp->getDefaultValue();
				$isNull = is_null($value);
			}
			catch ( \ReflectionException $exception ) {
			}

			if ($isNull) {
				if (! is_a($rpTypeName, DelegateInterface::class, true)) {
					return [];
				}

				if (! $this->di->hasDelegateClass()) {
					throw new NoDelegateClassError('You must define DelegateClass to use delayed delegation');
				}

				$class = $this->di->getDelegateClass();
				$value = new $class($this->di, $rpTypeName);

			} else {
				$value = $this->getAsChild($rpTypeName);
			}

			$int = $this->requireArr()->expand($int, $rp->getPosition(), $value);

			return [ $value ];
		}

		return [];
	}

	/**
	 * @param \ReflectionParameter $rp
	 * @param array                $int
	 * @param array                $str
	 * @param array                $used
	 *
	 * @return array
	 */
	protected function autowireParamName(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = [])
	{
		if (! $rpName = $rp->getName()) return [];
		if (! array_key_exists($key = '$' . $rpName, $str)) return [];

		$used[ $key ] = true;

		if ($rp->isVariadic()) {
			if (is_null($str[ $key ]) || ( [] === $str[ $key ] )) {
				return [];
			}
		}

		$value = $str[ $key ];

		$int = $this->requireArr()->expand($int, $rp->getPosition(), $value);

		return [ $value ];
	}

	/**
	 * @param \ReflectionParameter $rp
	 * @param array                $int
	 * @param array                $str
	 * @param array                $used
	 *
	 * @return array
	 */
	protected function autowireParamPosition(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = []) : array
	{
		if (! array_key_exists($rpPos = $rp->getPosition(), $int)) return [];

		if ($rp->isVariadic()) {
			if (is_null($int[ $rpPos ]) || ( [] === $int[ $rpPos ] )) {
				return [];
			}
		}

		$value = $int[ $rpPos ];

		return [ $value ];
	}

	/**
	 * @param \ReflectionParameter $rp
	 * @param array                $int
	 * @param array                $str
	 * @param array                $used
	 *
	 * @return array
	 */
	protected function autowireParamDefault(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = []) : array
	{
		try {
			$value = $rp->getDefaultValue();
		}
		catch ( \ReflectionException $exception ) {
			return [];
		}

		return [ $value ];
	}
}