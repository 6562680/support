<?php

namespace Gzhegow\Di\Libs;

use Gzhegow\Di\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Php
 */
class Php
{
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
}