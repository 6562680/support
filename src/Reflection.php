<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Reflection
 */
class Reflection
{
	/**
	 * @var Php
	 */
	protected $php;

	/**
	 * @var array
	 */
	protected $cache;


	/**
	 * Constructor
	 *
	 * @param Php $php
	 */
	public function __construct(Php $php)
	{
		$this->php = $php;
	}


	/**
	 * @param mixed  $item
	 * @param string $method
	 *
	 * @return bool
	 */
	public function isPropertyDeclared($item, string $method) : bool
	{
		try {
			$array = $this->propertyInfo($item, $method);
		}
		catch ( \Exception $e ) {
			return false;
		}

		return $array[ 'default' ] && $array[ 'declared' ];
	}

	/**
	 * @param mixed           $item
	 * @param string          $property
	 * @param string[]|bool[] ...$tags
	 *
	 * @return bool
	 */
	public function isPropertyExists($item, string $property, ...$tags) : bool
	{
		try {
			$array = $this->propertyInfo($item, $property);
		}
		catch ( \Exception $e ) {
			return false;
		}

		if (! $tags) {
			return true;
		}

		[ $kwargs, $args ] = $this->php->kwargs(...$tags);

		$index = [];
		foreach ( $kwargs as $arg => $bool ) {
			$index[ $arg ] = $bool;
		}

		foreach ( $args as $arg ) {
			$index[ $arg ] = true;
		}

		if (array_diff_key($index, $array)) return false;
		if ($index !== array_intersect_assoc($index, $array)) return false;

		return true;
	}


	/**
	 * @param mixed  $item
	 * @param string $method
	 *
	 * @return bool
	 */
	public function isMethodDeclared($item, string $method) : bool
	{
		try {
			$array = $this->methodInfo($item, $method);
		}
		catch ( \Exception $e ) {
			return false;
		}

		return (bool) $array[ 'declared' ];
	}

	/**
	 * @param mixed           $item
	 * @param string          $method
	 * @param string[]|bool[] ...$tags
	 *
	 * @return bool
	 */
	public function isMethodExists($item, string $method, ...$tags) : bool
	{
		try {
			$array = $this->methodInfo($item, $method);
		}
		catch ( \Exception $e ) {
			return false;
		}

		if (! $tags) {
			return true;
		}

		[ $kwargs, $args ] = $this->php->kwargs(...$tags);

		$index = [];
		foreach ( $kwargs as $arg => $bool ) {
			$index[ $arg ] = $bool;
		}

		foreach ( $args as $arg ) {
			$index[ $arg ] = true;
		}

		if (array_diff_key($index, $array)) return false;
		if ($index !== array_intersect_assoc($index, $array)) return false;

		return true;
	}


	/**
	 * @param mixed  $item
	 * @param string $property
	 *
	 * @return \ReflectionMethod
	 */
	public function reflectMethod($item, string $property) : \ReflectionMethod
	{
		switch ( true ):
			case is_string($item) && class_exists($item):
				$class = $item;
				break;

			case is_object($item):
				$class = get_class($item);
				break;

			default:
				throw new InvalidArgumentException('Argument 1 should be object or class', func_get_args());

		endswitch;

		if ('' === $property) {
			throw new InvalidArgumentException('Property should be not empty', func_get_args());
		}

		if (! isset($this->cache[ $class . '::' . $property ])) {
			try {
				$this->cache[ $class . '::' . $property ] = new \ReflectionProperty($item, $property);

			}
			catch ( \ReflectionException $e ) {
				throw new RuntimeException('Unable to reflect', func_get_args(), $e);
			}
		}

		return $this->cache[ $class . '::' . $property ];
	}

	/**
	 * @param mixed  $item
	 * @param string $property
	 *
	 * @return \ReflectionProperty
	 */
	public function reflectProperty($item, string $property) : \ReflectionProperty
	{
		switch ( true ):
			case is_string($item) && class_exists($item):
				$class = $item;
				break;

			case is_object($item):
				$class = get_class($item);
				break;

			default:
				throw new InvalidArgumentException('Argument 1 should be object or class', func_get_args());

		endswitch;

		if ('' === $property) {
			throw new InvalidArgumentException('Property should be not empty', func_get_args());
		}

		if (! isset($this->cache[ $class . '.' . $property ])) {
			try {
				$this->cache[ $class . '.' . $property ] = new \ReflectionProperty($item, $property);

			}
			catch ( \ReflectionException $e ) {
				throw new RuntimeException('Unable to reflect', func_get_args(), $e);
			}
		}

		return $this->cache[ $class . '.' . $property ];
	}


	/**
	 * @param mixed  $item
	 * @param string $property
	 *
	 * @return array
	 * @throws \ReflectionException
	 */
	public function propertyInfo($item, string $property) : array
	{
		switch ( true ):
			case is_string($item) && class_exists($item):
				$class = $item;
				break;

			case is_object($item):
				$class = get_class($item);
				break;

			default:
				throw new InvalidArgumentException('Argument 1 should be object or class', func_get_args());

		endswitch;

		$result = [];

		$rp = $this->reflectProperty($item, $property);

		$result[ 'declared' ] = $rp->getDeclaringClass()->getName() === $class;
		$result[ 'default' ] = $rp->isDefault();
		$result[ 'private' ] = $rp->isPrivate();
		$result[ 'protected' ] = $rp->isProtected();
		$result[ 'public' ] = $rp->isPublic();
		$result[ 'static' ] = $rp->isStatic();

		return $result;
	}

	/**
	 * @param mixed  $item
	 * @param string $method
	 *
	 * @return array
	 * @throws \ReflectionException
	 */
	public function methodInfo($item, string $method) : array
	{
		switch ( true ):
			case is_string($item) && class_exists($item):
				$class = $item;
				break;

			case is_object($item):
				$class = get_class($item);
				break;

			default:
				throw new InvalidArgumentException('Argument 1 should be object or class');

		endswitch;

		$rm = $this->reflectMethod($item, $method);

		$result = [];

		$result[ 'declared' ] = $rm->getDeclaringClass()->getName() === $class;
		$result[ 'abstract' ] = $rm->isAbstract();
		$result[ 'final' ] = $rm->isFinal();
		$result[ 'private' ] = $rm->isPrivate();
		$result[ 'protected' ] = $rm->isProtected();
		$result[ 'public' ] = $rm->isPublic();
		$result[ 'static' ] = $rm->isStatic();

		return $result;
	}
}
