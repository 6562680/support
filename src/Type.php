<?php

namespace Gzhegow\Support;

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
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isBool($value) : bool
	{
		return ( is_bool($value) && ( $value === true ) )
			|| ( is_bool($value) && ( $value === false ) )
			|| ( is_int($value) && ( $value === 1 ) )
			|| ( is_int($value) && ( $value === 0 ) )
			|| ( is_float($value) && ( $value === 1.0 ) )
			|| ( is_float($value) && ( $value === 0.0 ) )
			|| ( is_string($value) && ( $value === "1" ) )
			|| ( is_string($value) && ( $value === "0" ) );
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isInt($value) : bool
	{
		return is_int($value)
			|| ( false !== filter_var($value, FILTER_VALIDATE_INT) );
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isFloat($value) : bool
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
			|| ( ( is_float($value) || is_numeric($value) ) && ! is_nan($value) )
		);
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isLine($value) : bool
	{
		return is_string($value)
			|| $this->isNumber($value);
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isWord($value) : bool
	{
		return $this->isLine($value)
			&& ( '' !== $value );
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function isStringable($value) : bool
	{
		return $this->isLine($value)
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
		return is_array($arrayable)
			|| ( is_object($arrayable) && method_exists($arrayable, 'toArray') );
	}


	/**
	 * @param mixed $array
	 *
	 * @return bool
	 */
	public function isArray($array) : bool
	{
		if (! is_array($array)) return false;
		if (! $array) return true; // empty array is array too

		// contains ordered int keys? is an array
		return range(0, count($array) - 1) === array_keys($array);
	}

	/**
	 * @param mixed $list
	 *
	 * @return bool
	 */
	public function isList($list) : bool
	{
		if (! is_array($list)) return false;
		if (! $list) return true; // empty list is array too

		// contains string key? not a list
		foreach ( array_keys($list) as $key ) {
			if (is_string($key)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @param mixed $assoc
	 *
	 * @return bool
	 */
	public function isAssoc($assoc) : bool
	{
		if (! is_array($assoc)) return false;
		if (! $assoc) return false; // empty assoc is not an assoc

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
	 * @param mixed $dict
	 *
	 * @return bool
	 */
	public function isDict($dict) : bool
	{
		if (! is_array($dict)) return false;
		if (! $dict) return false; // empty dict is not an dict

		// contains
		foreach ( array_keys($dict) as $key ) {
			if (is_int($key)) return false;  // 0,1,2
			if ('' === $key) return false;   // ''
		}

		return true;
	}

	/**
	 * @param mixed $cortage
	 *
	 * @return bool
	 */
	public function isCortage($cortage) : bool
	{
		if (! is_array($cortage)) return false;
		if (! $cortage) return true; // empty dict is not an cortage

		// contains
		foreach ( array_keys($cortage) as $key ) {
			if (is_int($key)) return false;  // 0,1,2
			if ('' === $key) return false;   // ''
		}

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
	 * @param mixed $func
	 *
	 * @return bool
	 */
	public function isCallableArray($func) : bool
	{
		return is_array($func) && is_callable($func);
	}

	/**
	 * @param mixed $func
	 *
	 * @return bool
	 */
	public function isCallableString($func) : bool
	{
		return is_string($func) && is_callable($func);
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
	 * @param mixed $handler
	 *
	 * @return bool
	 */
	public function isHandler($handler) : bool
	{
		return is_string($handler)
			&& ( '' !== $handler )
			&& ( $handler[ 0 ] !== '@' )
			&& ( 1 !== substr_count($handler, '@') );
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
	 * @param mixed $reflectionClass
	 *
	 * @return bool
	 */
	public function isReflectionClass($reflectionClass) : bool
	{
		return is_object($reflectionClass) && is_a($reflectionClass, \ReflectionClass::class);
	}

	/**
	 * @param mixed $reflectable
	 *
	 * @return bool
	 */
	public function isReflectableClass($reflectable) : bool
	{
		return ( 0
			|| ( is_object($reflectable) )
			|| ( is_string($reflectable) && class_exists($reflectable) )
		);
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
}