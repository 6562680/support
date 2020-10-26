<?php

namespace Gzhegow\Support;

/**
 * Class Debug
 */
class Debug
{
	/**
	 * @param mixed $arg
	 *
	 * @return mixed
	 */
	public function arg($arg)
	{
		if (is_null($arg)) {
			$arg = '{ NULL }';

		} elseif (is_bool($arg)) {
			$arg = $arg
				? 'TRUE'
				: 'FALSE';

		} elseif (is_object($arg)) {
			$arg = '{ #' . spl_object_id($arg) . ' ' . get_class($arg) . ' }';

		} elseif (is_resource($arg)) {
			$arg = '{ Resource #' . intval($arg) . ' }';

		}

		return $arg;
	}

	/**
	 * @param array $args
	 *
	 * @return mixed
	 */
	public function args(array $args)
	{
		array_walk_recursive($args, function (&$v) {
			$v = $this->arg($v);
		});

		return $args;
	}


	/**
	 * @param string $content
	 *
	 * @return string
	 */
	public function doc(string $content) : string
	{
		return preg_replace("/\s+/m", ' ', $content);
	}


	/**
	 * @param array $trace
	 *
	 * @return array
	 */
	public function trace(array $trace) : array
	{
		$trace[ 'args' ] = $this->printR($this->args($trace[ 'args' ]), 1);

		return $trace;
	}


	/**
	 * @param array $arguments
	 *
	 * @return string
	 */
	public function varDump(...$arguments) : string
	{
		ob_start();

		var_dump(...$arguments);

		return ob_get_clean();
	}


	/**
	 * @param mixed     $arg
	 * @param bool|null $return
	 *
	 * @return string
	 */
	public function printR($arg, bool $return = null) : ?string
	{
		if (! $return) {
			ob_start();
			print_r($arg);
			ob_end_clean();

			return null;

		}

		return $this->doc(print_r($arg, $return));
	}
}
