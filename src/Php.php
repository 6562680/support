<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Php
 */
class Php
{
	/**
	 * @param object $object
	 *
	 * @return array
	 */
	public function getPublicVars(object $object) : array
	{
		return get_object_vars($object);
	}


	/**
	 * @param string $name
	 * @param null   $value
	 *
	 * @return null|string
	 */
	public function const(string $name, $value = null) : ?string
	{
		if (! $name) {
			throw new InvalidArgumentException('Argument 1 should be defined');
		}

		if (! defined($name)) {
			define($name, $value);

		} else {
			if (isset($value)) {
				throw new RuntimeException('Constant is already defined: ' . $name);
			}
		}

		return constant($name);
	}


	/**
	 * @param mixed ...$arguments
	 *
	 * @return array
	 */
	public function kwargs(...$arguments) : array
	{
		$kwargs = [];
		$args = [];
		foreach ( $arguments as $argument ) {
			foreach ( (array) $argument as $key => $val ) {
				if (! is_int($key)) {
					$kwargs[ $key ] = $val;
				} else {
					$args[] = $val;
				}
			}
		}

		return [ $kwargs, $args ];
	}

	/**
	 * @param mixed ...$arguments
	 *
	 * @return array
	 * @throws InvalidArgumentException
	 */
	public function kwparams(...$arguments) : array
	{
		$kwargs = [];
		$args = [];
		foreach ( $arguments as $argument ) {
			foreach ( (array) $argument as $key => $val ) {
				if (! is_int($key) && ! isset($kwargs[ $key ])) {
					$kwargs[ $key ] = $val;

				} elseif (! isset($args[ $key ])) {
					$args[ $key ] = $val;

				} else {
					throw new InvalidArgumentException('Duplicate key found: ' . $key, func_get_args());

				}
			}
		}

		return [ $kwargs, $args ];
	}


	/**
	 * @param string|object $item
	 *
	 * @return array
	 */
	public function splitclass($item) : array
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

		$result = explode('\\', $class);

		return $result;
	}


	/**
	 * @param mixed $item
	 *
	 * @return array
	 */
	public function nsclass($item) : array
	{
		$array = $this->splitclass($item);

		$class = array_pop($array);
		$namespace = implode($separator = '\\', $array)
			?: null;

		return [ $namespace, $class ];
	}

	/**
	 * @param mixed $item
	 *
	 * @return string
	 */
	public function class($item) : string
	{
		$array = $this->splitclass($item);

		return array_pop($array);
	}

	/**
	 * @param             $item
	 *
	 * @return null|string
	 */
	public function namespace($item) : ?string
	{
		$array = $this->splitclass($item);

		array_pop($array);

		return implode('\\', $array);
	}


	/**
	 * @param mixed       $item
	 * @param string|null $base
	 *
	 * @return string
	 */
	public function baseclass($item, string $base = null) : string
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

		$relative = $class;

		if ($base && 0 === stripos($class, rtrim($base, '\\'))) {
			$relative = str_ireplace($base . '\\', '', $class);
		}

		return $relative;
	}
}
