<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Path
 */
class Path
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
	 * @param string $pathname
	 * @param string $separator
	 *
	 * @return string
	 */
	function optimize(string $pathname, string $separator = '/') : string
	{
		if ('' === $pathname) {
			return '';
		}

		$optimized = str_replace($separator, "\0", $pathname);

		$optimized = str_replace(
			[ '/', '\\', DIRECTORY_SEPARATOR ],
			[ $separator, $separator, $separator ],
			$optimized
		);

		if (false !== strpos($pathname, $separator . $separator)) {
			$optimized = preg_replace('~' . preg_quote($separator, '/') . '{2,}~', $separator, $optimized);
		}

		$optimized = str_replace("\0", $separator, $optimized);

		return $optimized;
	}

	/**
	 * @param string $pathname
	 *
	 * @return string
	 */
	function normalize(string $pathname) : string
	{
		return $this->optimize($pathname, DIRECTORY_SEPARATOR);
	}


	/**
	 * @param string $path
	 *
	 * @return string
	 */
	function realpath(string $path) : string
	{
		if (false === ( $result = realpath($path) )) {
			throw new InvalidArgumentException('Path not exists: ' . $path);
		}

		return $result;
	}

	/**
	 * @param string      $path
	 * @param string|null $base
	 *
	 * @return string
	 */
	function basepath(string $path, string $base = null) : string
	{
		$basePath = str_replace($this->normalize($base . '/'), '', $this->normalize($path));

		return $basePath;
	}


	/**
	 * @param array $parts
	 *
	 * @return string
	 */
	function join(...$parts) : string
	{
		[ 1 => $args ] = $this->php->kwargs(...$parts);

		$result = array_reduce($args, static function (array $carry, string $part) {
			if ('' === $part) {
				return $carry;
			}

			$carry[] = $part;

			return $carry;
		}, []);

		return $this->normalize(implode('/', $result));
	}

	/**
	 * @param array $parts
	 *
	 * @return string
	 */
	function joinsafe(...$parts) : string
	{
		[ 1 => $args ] = $this->php->kwargs(...$parts);

		$result = array_reduce($args, static function (array $carry, $part) {
			if (! $this->type->isTheString($part)) {
				throw new InvalidArgumentException('Each part should be non-empty stringable', $part);
			}

			$carry[] = $part;

			return $carry;
		}, []);

		return $this->normalize(implode('/', $result));
	}
}
