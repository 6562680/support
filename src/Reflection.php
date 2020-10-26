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
	 * @var Type
	 */
	protected $type;

	/**
	 * @var array
	 */
	protected $cache;


	/**
	 * Constructor
	 *
	 * @param Php  $php
	 * @param Type $type
	 */
	public function __construct(Php $php, Type $type)
	{
		$this->php = $php;
		$this->type = $type;
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
	 * @param mixed        $item
	 * @param string|null &$class
	 *
	 * @return \ReflectionClass
	 */
	public function reflectClass($item, string &$class = null) : \ReflectionClass
	{
		switch ( true ):
			case $this->type->isReflectableClass($item, $class):
			case $this->type->isReflectionClass($item, $class):
				break;

			default:
				throw new InvalidArgumentException('Argument 1 should be object or class', func_get_args());

		endswitch;

		if (! isset($this->cache[ $class ])) {
			try {
				$this->cache[ $class ] = new \ReflectionClass($item);
			}
			catch ( \ReflectionException $e ) {
				throw new RuntimeException('Unable to reflect', func_get_args(), $e);
			}
		}

		return $this->cache[ $class ];
	}

	/**
	 * @param mixed        $item
	 * @param string       $method
	 * @param string|null &$class
	 *
	 * @return \ReflectionMethod
	 */
	public function reflectMethod($item, string $method, string &$class = null) : \ReflectionMethod
	{
		switch ( true ):
			case $this->type->isReflectableClass($item, $class):
			case $this->type->isReflectionClass($item, $class):
				break;

			default:
				throw new InvalidArgumentException('Argument 1 should be object or class', func_get_args());

		endswitch;

		if ('' === $method) {
			throw new InvalidArgumentException('Property should be not empty', func_get_args());
		}

		if (! isset($this->cache[ $class . '::' . $method ])) {
			try {
				$this->cache[ $class . '::' . $method ] = new \ReflectionMethod($item, $method);
			}
			catch ( \ReflectionException $e ) {
				throw new RuntimeException('Unable to reflect', func_get_args(), $e);
			}
		}

		return $this->cache[ $class . '::' . $method ];
	}

	/**
	 * @param mixed        $item
	 * @param string       $property
	 * @param string|null &$class
	 *
	 * @return \ReflectionProperty
	 */
	public function reflectProperty($item, string $property, string &$class = null) : \ReflectionProperty
	{
		switch ( true ):
			case $this->type->isReflectableClass($item, $class):
			case $this->type->isReflectionClass($item, $class):
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
	 */
	public function propertyInfo($item, string $property) : array
	{
		$result = [];

		$rp = $this->reflectProperty($item, $property, $class);

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
	 */
	public function methodInfo($item, string $method) : array
	{
		$rm = $this->reflectMethod($item, $method, $class);

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
