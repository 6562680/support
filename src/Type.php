<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Interfaces\CanToArrayInterface;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Type
 */
class Type
{
	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isEmpty($value) : bool
	{
		if (is_object($value) && is_countable($value)) {
			return ! (bool) count($value);
		}

		if (false === $value) {
			return false;
		}

		return empty($value);
	}


	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function isKey($value) : bool
	{
		// generator can pass any object as foreach key, so this check is recommended

		return is_int($value) || is_string($value);
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isTheInt($value) : bool
	{
		return is_int($value)
			|| ( false !== filter_var($value, FILTER_VALIDATE_INT) );
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isTheFloat($value) : bool
	{
		return ! is_nan($value)
			&& ( is_float($value)
				|| ( false !== filter_var($value, FILTER_VALIDATE_FLOAT) )
			);
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isNumber($value) : bool
	{
		return ( is_int($value)
			|| ( ! is_nan($value) && ( is_float($value) || is_numeric($value) ) )
		);
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isStringOrNumber($value) : bool
	{
		return is_string($value) || $this->isNumber($value);
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isTheString($value) : bool
	{
		return is_string($value)
			&& ( '' !== $value );
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isTheStringOrNumber($value) : bool
	{
		return ( '' !== $value )
			&& $this->isStringOrNumber($value);
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isStringable($value) : bool
	{
		return $this->isStringOrNumber($value)
			&& ( ! is_array($value)
				&& ( settype($value, 'string') !== false )
			);
	}

	/**
	 * @param mixed $arrayable
	 *
	 * @return bool
	 */
	public function isArrayable($arrayable) : bool
	{
		if (is_null($arrayable)) {
			return true;

		} elseif (is_scalar($arrayable)) {
			return true;

		} elseif (is_iterable($arrayable)) {
			return true;

		} elseif (is_object($arrayable)) {
			if (is_a($arrayable, CanToArrayInterface::class)) {
				return true;

			} elseif (method_exists($arrayable, 'toArray')) {
				return true;
			}
		}

		return false;
	}


	/**
	 * @param mixed $assoc
	 *
	 * @return bool
	 */
	public function isAssoc($assoc) : bool
	{
		if (! is_array($assoc)) return false;
		if (! $assoc) return false; // empty array is not an assoc

		// contains simulateonsly string/int key? is an assoc
		$hasStr = false;
		$hasInt = false;
		foreach ( array_keys($assoc) as $key ) {
			$hasStr = $hasStr || is_string($key);
			$hasInt = $hasInt || is_int($key);

			if ($hasStr && $hasInt) {
				return true;
			}
		}

		return false;
	}


	/**
	 * @param mixed $cortage
	 *
	 * @return bool
	 */
	public function isCortage($cortage) : bool
	{
		if (! is_array($cortage)) return false;
		if (! $cortage) return true; // empty array is cortage

		// contains
		foreach ( array_keys($cortage) as $key ) {
			if (is_int($key)) return false;  // 0,1,2
			if ('' === $key) return false;   // ''
		}

		return true;
	}

	/**
	 * @param mixed $dict
	 *
	 * @return bool
	 */
	public function isDict($dict) : bool
	{
		if (! is_array($dict)) return false;
		if (! $dict) return false; // empty array is not a dict

		return $this->isCortage($dict);
	}


	/**
	 * @param mixed $list
	 *
	 * @return bool
	 */
	public function isList($list) : bool
	{
		if (! is_iterable($list)) return false;
		if (! $list) return true; // empty array is list too

		// contains string key? not a list
		foreach ( $list as $key => &$val ) {
			if (! is_int($key)) {
				return false;
			}
		}
		unset($val);

		return true;
	}

	/**
	 * @param mixed $orderedArray
	 *
	 * @return bool
	 */
	public function isOrderedList($orderedArray) : bool
	{
		if (! is_iterable($orderedArray)) return false;
		if (! $orderedArray) return true; // empty array is array too

		// contains ordered int keys? is an array
		$i = 0;
		foreach ( $orderedArray as $key => &$val ) {
			if (! is_int($key)) {
				return false;
			}

			if ($i++ !== $key) {
				return false;
			}
		}
		unset($val);

		return true;
	}


	/**
	 * @param mixed $callable
	 *
	 * @return bool
	 */
	public function isCallable($callable) : bool
	{
		return ( 0
			|| ( is_object($callable) && ( get_class($callable) === \Closure::class ) )
			|| ( ( is_array($callable) || is_string($callable) ) && is_callable($callable) )
		);
	}

	/**
	 * @param mixed        $func
	 * @param null|string &$class
	 * @param null|string &$method
	 * @param null|object &$object
	 *
	 * @return bool
	 */
	public function isCallableArray($func, string &$class = null, string &$method = null, &$object = null) : bool
	{
		return is_array($func)
			&& ( $this->isCallableArrayString($func, $class, $method)
				|| $this->isCallableArrayObject($func, $object, $method, $class) );
	}

	/**
	 * @param mixed        $func
	 *
	 * @param null|object &$object
	 * @param null|string &$method
	 * @param null|string &$class
	 *
	 * @return bool
	 */
	public function isCallableArrayObject($func, &$object = null, string &$method = null, string &$class = null) : bool
	{
		return is_array($func)
			&& isset($func[ 0 ]) && is_object($object = $func[ 0 ]) && is_string($class = get_class($object))
			&& isset($func[ 1 ]) && $this->isTheString($method = $func[ 1 ])
			&& is_callable($func);
	}

	/**
	 * @param mixed        $func
	 * @param null|string &$class
	 * @param null|string &$method
	 *
	 * @return bool
	 */
	public function isCallableArrayString($func, &$class = null, &$method = null) : bool
	{
		return is_array($func)
			&& isset($func[ 0 ]) && $this->isTheString($class = $func[ 0 ])
			&& isset($func[ 1 ]) && $this->isTheString($method = $func[ 1 ])
			&& is_callable($func);
	}

	/**
	 * @param mixed $func
	 *
	 * @return bool
	 */
	public function isCallableString($func) : bool
	{
		return $this->isTheString($func) && is_callable($func);
	}


	/**
	 * @param mixed $func
	 *
	 * @return bool
	 */
	public function isClosure($func) : bool
	{
		return is_object($func) && ( get_class($func) === \Closure::class );
	}


	/**
	 * @param mixed        $handler
	 * @param string|null &$class
	 * @param string|null &$method
	 *
	 * @return bool
	 */
	public function isHandler($handler, string &$class = null, string &$method = null) : bool
	{
		$isHandler = $this->isTheString($handler)
			&& ( $handler[ 0 ] !== '@' )
			&& ( 1 === substr_count($handler, '@') );

		[ $class, $method ] = explode('@', $handler);

		return $isHandler;
	}


	/**
	 * @param mixed $class
	 *
	 * @return bool
	 */
	public function isClass($class) : bool
	{
		return is_string($class) && class_exists($class);
	}

	/**
	 * @param mixed        $reflectable
	 * @param string|null &$class
	 *
	 * @return bool
	 */
	public function isReflectableClass($reflectable, string &$class = null) : bool
	{
		return ( 0
			|| ( is_object($reflectable) && ( $class = get_class($reflectable) ) )
			|| ( is_string($reflectable) && class_exists($reflectable) && ( $class = $reflectable ) )
		);
	}


	/**
	 * @param \ReflectionClass  $reflectionClass
	 * @param string|null      &$class
	 *
	 * @return bool
	 */
	public function isReflectionClass($reflectionClass, string &$class = null) : bool
	{
		return is_object($reflectionClass)
			&& is_a($reflectionClass, \ReflectionClass::class)
			&& $class = $reflectionClass->getName();
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isFile($value) : bool
	{
		return is_object($value) && is_a($value, \SplFileInfo::class);
	}


	/**
	 * @param mixed $h
	 *
	 * @return bool
	 */
	public function isResource($h) : bool
	{
		return is_resource($h) || 'resource (closed)' === gettype($h);
	}


	/**
	 * @param null $data
	 *
	 * @return array
	 */
	public function arrval($data = null) : array
	{
		$result = [];

		if (is_null($data)) {
			$result = [];

		} elseif (is_scalar($data)) {
			$result = [ $data ];

		} elseif (is_array($data)) {
			$result = $data;

		} elseif (is_object($data)) {
			if (is_a($data, CanToArrayInterface::class)) {
				/** @var CanToArrayInterface $data */

				$result = $data->toArray();

			} elseif (is_iterable($data)) {
				foreach ( $data as $idx => $item ) {
					if ($this->isKey($idx)) {
						$result[ $idx ] = $item;

					} else {
						$result[] = $item;

					}
				}

			} elseif (method_exists($data, 'toArray')) {
				$result = $data->toArray();

			}

		} else {
			throw new InvalidArgumentException('Unable to convert variable to array', $data);
		}

		return $result;
	}


	/**
	 * @param mixed ...$items
	 *
	 * @return array
	 */
	public function listval(...$items) : array
	{
		$result = [];

		foreach ( $items as $idx => $item ) {
			if (is_iterable($item)) {
				$list = $this->isList($item)
					? $item
					: [ $item ];

				foreach ( $list as $int => $val ) {
					$result[] = $val;
				}
			} else {
				$result[] = $item;
			}
		}

		return $result;
	}

	/**
	 * @param mixed ...$items
	 *
	 * @return array
	 */
	public function listvalFlatten(...$items) : array
	{
		$result = [];

		array_walk_recursive($items, function ($item) use (&$result) {
			if (is_iterable($item)) {
				$list = $this->isList($item)
					? $item
					: [ $item ];

				foreach ( $list as $int => $val ) {
					$result[] = $val;
				}
			} else {
				$result[] = $item;
			}
		});

		return $result;
	}
}