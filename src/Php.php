<?php

namespace Gzhegow\Support;

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

		[ $kwargs, $args ] = $this->kwargs(...$tags);

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

		[ $kwargs, $args ] = $this->kwargs(...$tags);

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
	 * @param string $name
	 * @param string $value
	 *
	 * @return bool
	 */
	public function putenv(string $name, string $value) : bool
	{
		$status = putenv($name . '=' . $value);

		if ($status) static::$env[ $name ] = $value;

		return $status;
	}

	/**
	 * @param null      $option
	 * @param bool|null $runtime
	 *
	 * @return null|array|false|string
	 */
	public function getenv($option = null, bool $runtime = null) // : string|array
	{
		$varname = is_string($option)
			? $option
			: null;

		$varname_lower = is_string($option)
			? mb_strtolower($option)
			: null;

		$runtime = null
			?? ( is_bool($runtime)
				? $runtime
				: null )
			?? ( is_bool($option)
				? $option
				: null )
			?? true;

		$env = getenv();
		if ($runtime) {
			$env = array_merge($env, static::$env ?? []);
		}

		// one value
		if ($varname) {
			$result = null
				?? ( isset($env[ $varname ])
					? getenv($varname, $runtime)
					: null )
				?? ( isset($env[ $varname_lower ])
					? getenv($varname_lower, $runtime)
					: null );

			return $result;
		}

		// all values
		$result = [];
		$registry = [];
		foreach ( $env as $key => $item ) {
			$prev = $registry[ $key_lower = mb_strtolower($key) ] ?? null;

			if (isset($prev)) unset($result[ $prev ]);

			$registry[ $key_lower ] = $key;
			$result[ $key ] = getenv($key, $runtime);
		}

		return $result;
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
				throw new \RuntimeException('Constant is already defined: ' . $name);
			}
		}

		return constant($name);
	}


	/**
	 * @param        $item
	 * @param string $property
	 *
	 * @return array
	 * @throws \ReflectionException
	 */
	public function propertyInfo($item, string $property) : array
	{
		static $cache;

		if ('' === $property) {
			throw new InvalidArgumentException('Argument 2 should be not empty', func_get_args());
		}

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

		$cache = $cache ?? [];

		$rp = $cache[ $class . '.' . $property ] = $cache[ $class . '.' . $property ]
			?? new \ReflectionProperty($item, $property);

		$result = [];

		$result[ 'declared' ] = $rp->getDeclaringClass()->getName() === $class;
		$result[ 'default' ] = $rp->isDefault();
		$result[ 'private' ] = $rp->isPrivate();
		$result[ 'protected' ] = $rp->isProtected();
		$result[ 'public' ] = $rp->isPublic();
		$result[ 'static' ] = $rp->isStatic();

		return $result;
	}

	/**
	 * @param        $item
	 * @param string $method
	 *
	 * @return array
	 * @throws \ReflectionException
	 */
	public function methodInfo($item, string $method) : array
	{
		static $cache;

		if ('' === $method) {
			throw new InvalidArgumentException('Argument 2 should be not empty', func_get_args());
		}

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

		$cache = $cache ?? [];

		$rm = $cache[ $class . '::' . $method ] = $cache[ $class . '::' . $method ]
			?? new \ReflectionMethod($item, $method);

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


	/**
	 * @param string|object $item
	 * @param string|null   $base
	 *
	 * @return array
	 */
	public function splitclass($item, string $base = null) : array
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
		if ($base && 0 === stripos($class, $base)) {
			$relative = str_ireplace($base . '\\', '', $class);
		}

		$result = explode('\\', $relative);

		return $result;
	}

	/**
	 * @param             $item
	 * @param string|null $base
	 *
	 * @return array
	 */
	public function nsclass($item, string $base = null) : array
	{
		$array = $this->splitclass($item, $base);

		$class = array_pop($array);
		$namespace = implode($separator = '\\', $array)
			?: null;

		return [ $namespace, $class ];
	}

	/**
	 * @param             $item
	 * @param string|null $base
	 *
	 * @return string
	 */
	public function baseclass($item, string $base = null) : string
	{
		$array = $this->splitclass($item, $base);

		return implode('\\', $array);
	}

	/**
	 * @param             $item
	 * @param string|null $base
	 *
	 * @return string
	 */
	public function class($item, string $base = null) : string
	{
		$array = $this->splitclass($item, $base);

		return array_pop($array);
	}

	/**
	 * @param             $item
	 * @param string|null $base
	 *
	 * @return null|string
	 */
	public function namespace($item, string $base = null) : ?string
	{
		$array = $this->splitclass($item, $base);

		array_pop($array);

		return implode('\\', $array);
	}


	/**
	 * @param array $args
	 *
	 * @return mixed
	 */
	public function traceArgs(array $args)
	{
		array_walk_recursive($args, function (&$v) {
			if (! is_scalar($v)) {
				if (is_null($v)) {
					$v = '{ NULL }';
				} elseif (is_resource($v)) {
					$v = '{ Resource #' . intval($v) . ' }';
				} else {
					$v = '{ #' . spl_object_id($v) . ' ' . get_class($v) . ' }';
				}
			}
		});

		return $args;
	}


	/**
	 * @var
	 */
	protected static $env;
}
