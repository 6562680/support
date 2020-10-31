<?php

namespace Gzhegow\Di;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Php;
use Gzhegow\Support\Type;
use Gzhegow\Reflection\Reflection;
use Gzhegow\Di\Exceptions\RuntimeException;
use Gzhegow\Reflection\ReflectionInterface;
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
	protected $id = null;


	/**
	 * Constructor
	 *
	 * @param Arr        $arr
	 * @param Php        $php
	 * @param Type       $type
	 * @param Reflection $reflection
	 *
	 * @param Di         $di
	 *
	 * @param Loop|null  $parent
	 */
	public function __construct(
		ReflectionInterface $reflection,

		Arr $arr,
		Php $php,
		Type $type,

		Di $di,

		Loop $parent = null
	)
	{
		$this->reflection = $reflection;

		$this->arr = $arr;
		$this->php = $php;
		$this->type = $type;

		$this->di = $di;

		$this->parent = $parent;
	}


	/**
	 * @return Loop
	 */
	public function newChild() : Loop
	{
		return new Loop(
			$this->reflection,

			$this->arr,
			$this->php,
			$this->type,

			$this->di,

			$this
		);
	}


	/**
	 * @param string $class
	 * @param mixed  ...$arguments
	 *
	 * @return object
	 */
	protected function newClass(string $class, ...$arguments)
	{
		if ('' === $class) {
			throw new InvalidArgumentException('Class should be not empty');
		}

		if (! $this->type->isClass($class)) {
			throw new InvalidArgumentException('Class should be existing class: ' . $class);
		}

		[ $kwargs, $args ] = $this->php->kwparams(...$arguments);

		$arguments = $this->autowireConstructor($class, array_merge($args, $kwargs));

		ksort($arguments);

		return new $class(...$arguments);
	}


	/**
	 * @param string $id
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public function createOrFail(string $id, ...$arguments)
	{
		try {
			$result = $this->create($id, ...$arguments);
		}
		catch ( NotFoundError $e ) {
			throw new RuntimeException('Unable to ' . __METHOD__, func_get_args(), $e);
		}

		return $result;
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
			|| ( $isClass = $this->type->isClass($id) )
		)) {
			throw new NotFoundError('Bind not found: ' . $id);
		}

		$bind = $id;
		$result = null;

		if (null === ( $result = $this->executeBind($id, $bind, $registry) )) {
			$parent = $this;

			while ( $parent = $parent->parent ) {
				$stack[] = $parent->id;

				if ($parent->id === $bind) {
					throw new AutowireLoopError(sprintf(
						'Autowire loop detected: %s is required in [ %s ]', $id, implode(' <- ', array_reverse($stack))
					));
				}
			}
			$this->id = $bind;

			$result = $this->newClass($bind, ...$arguments);
		}

		if ($this->di->hasExtends($bind)) {
			foreach ( $this->di->getExtends($bind) as $func ) {
				$result = null
					?? $this->handle($func, [
						$bind => $result,
					])
					?? $result;
			}
		}

		if (! $this->di->hasItem($bind)) {
			if ($this->di->hasShared($bind)) {
				$this->di->set($bind, $result);
			}
		}

		foreach ( array_keys($registry) as $registryBind ) {
			if (! $this->di->hasItem($registryBind)) {
				if ($this->di->hasShared($registryBind)) {
					$this->di->set($registryBind, $result);
				}
			}
		}

		return $result;
	}


	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundError
	 */
	public function get(string $id)
	{
		if ('' === $id) {
			throw new InvalidArgumentException('Id should be not empty');
		}

		$result = $this->executeBind($id, $bind);

		return $result ?? $this->create($bind);
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
		catch ( NotFoundError $e ) {
			throw new RuntimeException('Unable to ' . __METHOD__, func_get_args(), $e);
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
			|| ( $isClosure = $this->type->isClosure($func) )
			|| ( $isHandler = $this->type->isHandler($func) )
			|| ( $isCallable = $this->type->isCallableArray($func) )
		)) {
			throw new InvalidArgumentException('Func should be closure, callable or handler', func_get_args());
		}

		[ $kwargs, $args ] = $this->php->kwparams(...$arguments);

		$params = array_merge($args, $kwargs);

		$arguments = [];
		switch ( true ) {
			case $isClosure:
				$arguments = $this->autowireClosure($func, $params);

				break;

			case $isHandler:
				[ $id, $method ] = explode('@', $func) + [ null, null ];

				$object = $this->newChild()->getOrFail($id);

				$func = [ $object, $method ];
				$arguments = $this->autowireMethod($object, $method, $params);

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
	 * @param string|object|\ReflectionClass $newthis
	 * @param callable                       $func
	 * @param array                          $arguments
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
			|| ( $isClosure = $this->type->isClosure($func) )
			|| ( $isCallableString = $this->type->isCallableString($func) )
			|| ( $isCallableArray = $this->type->isCallableArray($func) )
		)) {
			throw new InvalidArgumentException('Func should be \Closure, callable string or callable array of public method', func_get_args());
		}

		if ($isCallableArray) {
			if (! is_object($func[ 0 ])) {
				throw new InvalidArgumentException('Callable should contain object instance', func_get_args());
			}

			if (! is_a($newthis, get_class($func[ 0 ]))) {
				throw new InvalidArgumentException('Callable should contain object that extends original one', func_get_args());
			}
		}

		[ $kwargs, $args ] = $this->php->kwparams(...$arguments);

		$params = array_merge($args, $kwargs)
			+ [ get_class($newthis) => $newthis ];

		$arguments = [];
		switch ( true ) {
			case $isClosure:
				$arguments = $this->autowireClosure($func, $params);
				break;

			case $isCallableString:
				$arguments = $this->autowireCallable($func, $params);
				break;

			case $isCallableArray:
				$arguments = $this->autowireCallableMethodNonStatic($func, $params);
				break;
		}

		switch ( true ) {
			case $isClosure:
				$closure = $func;
				break;

			case $isCallableString:
			case $isCallableArray:
				$closure = \Closure::fromCallable($func);
				break;
		}

		ksort($arguments);

		$result = $closure->bindTo($newthis, $newthis)(...$arguments);

		return $result;
	}


	/**
	 * @param string       $id
	 *
	 * @param string|null &$bind
	 * @param array|null  &$registry
	 *
	 * @return string|\Closure
	 * @throws NotFoundError
	 */
	protected function executeBind(string $id, string &$bind = null, array &$registry = null)
	{
		$result = null;

		$bind = $id;

		$registry = [];
		while ( $this->di->hasBind($bind) ) {
			if (isset($registry[ $bind ])) {
				throw new AutowireLoopError('Autowire Loop detected: ' . $bind, implode(' <- ', array_keys($registry)));
			}

			$registry[ $bind ] = true;

			if ($this->di->hasDeferableBind($bind)) {
				$this->di->bootDeferable($bind);
			}

			$bind = $this->di->getBind($bind);
		}

		$result = null
			?? $result
			?? ( $this->di->hasItem($bind)
				? $this->di->getItem($bind)
				: null )
			?? ( $this->type->isClosure($bind)
				? $this->handle($bind)
				: null )
			?? null;

		return $result;
	}


	/**
	 * @param string|object|\ReflectionClass $object
	 * @param array                          $params
	 *
	 * @return array
	 */
	protected function autowireConstructor($object, array $params = []) : array
	{
		if (! $this->type->isReflectableClass($object, $class)) {
			throw new InvalidArgumentException('Class is not reflectable: ' . $class, func_get_args());
		}

		$rm = $this->reflection
			->reflectClass($class)->getConstructor();

		$result = isset($rm)
			? $this->autowireParams($rm->getParameters(), $params)
			: [];

		return $result;
	}

	/**
	 * @param string|object|\ReflectionClass $object
	 * @param string                         $method
	 * @param array                          $params
	 *
	 * @return array
	 */
	protected function autowireMethod($object, string $method, array $params = []) : array
	{
		if (! $this->type->isReflectableClass($object, $class)) {
			throw new InvalidArgumentException('Class is not reflectable: ' . $class, func_get_args());
		}

		$rm = $this->reflection
			->reflectMethod($this->reflection->reflectClass($object), $method);

		$result = $this->autowireParams($rm->getParameters(), $params);

		return $result;
	}

	/**
	 * @param \Closure $closure
	 * @param array    $params
	 *
	 * @return array
	 */
	protected function autowireClosure(\Closure $closure, array $params = []) : array
	{
		$rf = $this->reflection->reflectClosure($closure);

		$result = $this->autowireParams($rf->getParameters(), $params);

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
			?? $this->pipeAutowireCallableString($callable, $params)
			?? $this->pipeAutowireCallableArray($callable, $params)
			?? $this->pipeAutowireCallableClosure($callable, $params);

		if (! isset($result)) {
			throw new InvalidArgumentException('Unable to autowire callable', func_get_args());
		}

		return $result;
	}

	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function autowireCallableString($callable, array $params = []) : array
	{
		$result = null
			?? $this->pipeAutowireCallableString($callable, $params);

		if (! isset($result)) {
			throw new InvalidArgumentException('Unable to autowire callable string', func_get_args());
		}

		return $result;
	}

	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function autowireCallableMethodNonStatic($callable, array $params = []) : array
	{
		$result = null
			?? $this->pipeAutowireCallableArrayMethodNonStatic($callable, $params);

		if (! isset($result)) {
			throw new InvalidArgumentException('Unable to autowire callable public method', func_get_args());
		}

		return $result;
	}


	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function pipeAutowireCallableString($callable, array $params = []) : ?array
	{
		if (! $this->type->isCallableString($callable)) return null;

		$rf = $this->reflection->reflectCallable($callable);

		$result = $this->autowireParams($rf->getParameters(), $params);

		return $result;
	}

	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function pipeAutowireCallableArray($callable, array $params = []) : ?array
	{
		if (! $this->type->isCallableArray($callable)) return null;

		$rm = $this->reflection->reflectMethod($callable[ 0 ], $callable[ 1 ]);

		$a = $rm->isStatic();
		$b = is_object($callable[ 0 ]);
		$xor = ( ( $a != $b ) && ( $a || $b ) );

		$result = $xor
			? $this->autowireParams($rm->getParameters(), $params)
			: null;

		return $result;
	}

	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function pipeAutowireCallableArrayMethodNonStatic($callable, array $params = []) : ?array
	{
		if (! $this->type->isCallableArray($callable)) return null;

		$rm = $this->reflection->reflectMethod($callable[ 0 ], $callable[ 1 ]);

		if ($rm->isStatic() || ! is_object($callable[ 0 ])) return null;

		$result = $this->autowireParams($rm->getParameters(), $params);

		return $result;
	}

	/**
	 * @param mixed $callable
	 * @param array $params
	 *
	 * @return array
	 */
	protected function pipeAutowireCallableArrayMethodStatic($callable, array $params = []) : ?array
	{
		if (! $this->type->isCallableArray($callable)) return null;

		$rm = $this->reflection->reflectMethod($callable[ 0 ], $callable[ 1 ]);

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
	protected function pipeAutowireCallableClosure($closure, array $params = []) : ?array
	{
		if (! $this->type->isClosure($closure)) return null;

		$result = $this->autowireClosure($closure, $params);

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
		$autowireResult = null
			?: $this->pipeAutowireParamType($rp, $int, $str, $used)
				?: $this->pipeAutowireParamName($rp, $int, $str, $used)
					?: $this->pipeAutowireParamPosition($rp, $int, $str, $used)
						?: $this->pipeAutowireParamDefault($rp, $int, $str, $used);

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
	protected function pipeAutowireParamType(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = []) : array
	{
		if (! $rpType = $rp->getType()) return [];
		if (! $rpTypeName = $rpType->getName()) return [];

		if (array_key_exists($rpTypeName, $str)
			&& is_object($str[ $rpTypeName ])
			&& is_a($str[ $rpTypeName ], $rpTypeName)
		) {
			$value = $str[ $rpTypeName ];

			$used[ $rpTypeName ] = true;

			$int = $this->arr->expand($int, $rp->getPosition(), $value);

			return [ $value ];

		} elseif (interface_exists($rpTypeName) || class_exists($rpTypeName)) {
			$isNull = false;
			try {
				$value = $rp->getDefaultValue();
				$isNull = is_null($value);
			}
			catch ( \ReflectionException $exception ) {
			}

			if (! $isNull) {
				$value = $this->newChild()->getOrFail($rpTypeName);

			} else {
				if (! is_a($rpTypeName, DelegateInterface::class, true)) {
					return [];
				}

				if (! $this->di->hasDelegateClass()) {
					throw new NoDelegateClassError('You must define DelegateClass to use delayed delegation');
				}

				$class = $this->di->getDelegateClass();
				$value = new $class($this->di, $rpTypeName);
			}

			$int = $this->arr->expand($int, $rp->getPosition(), $value);

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
	protected function pipeAutowireParamName(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = [])
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

		$int = $this->arr->expand($int, $rp->getPosition(), $value);

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
	protected function pipeAutowireParamPosition(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = []) : array
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
	protected function pipeAutowireParamDefault(\ReflectionParameter $rp, array &$int = [], array &$str = [], array &$used = []) : array
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