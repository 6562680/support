<?php

namespace Gzhegow\Support;

/**
 * Class Str
 */
class Str
{
	/**
	 * @param string      $str
	 * @param string|null $needle
	 * @param bool|null   $ignoreCase
	 *
	 * @return null|string
	 */
	public function starts(string $str, string $needle = null, bool $ignoreCase = null) : ?string
	{
		$needle = (string) $needle;
		$ignoreCase = $ignoreCase ?? true;

		if ('' === $str) return null;
		if ('' === $needle) return $str;

		$pos = $ignoreCase
			? stripos($str, $needle)
			: strpos($str, $needle);

		return 0 === $pos
			? substr($str, strlen($needle))
			: null;
	}

	/**
	 * @param string      $str
	 * @param string|null $needle
	 * @param bool|null   $ignoreCase
	 *
	 * @return null|string
	 */
	public function ends(string $str, string $needle = null, bool $ignoreCase = null) : ?string
	{
		$needle = (string) $needle;
		$ignoreCase = $ignoreCase ?? true;

		if ('' === $str) return null;
		if ('' === $needle) return $str;

		$pos = $ignoreCase
			? stripos($str, $needle)
			: strpos($str, $needle);

		return $pos === strlen($str) - strlen($needle)
			? substr($str, 0, $pos)
			: null;
	}


	/**
	 * @param string      $str
	 * @param string|null $sym
	 * @param int         $len
	 *
	 * @return string
	 */
	public function lwrap(string $str, string $sym = null, $len = 1) : string
	{
		$sym = (string) $sym;

		if ('' === $sym) return $str;

		$len = max(0, intval($len));

		return str_repeat($sym, $len) . $str;
	}

	/**
	 * @param string      $str
	 * @param string|null $sym
	 * @param int         $len
	 *
	 * @return string
	 */
	public function rwrap(string $str, string $sym = null, $len = 1) : string
	{
		$sym = (string) $sym;

		if ('' === $sym) return $str;

		$len = max(0, intval($len));

		return $str . str_repeat($sym, $len);
	}

	/**
	 * @param string      $str
	 * @param string|null $sym
	 * @param int         $len
	 *
	 * @return string
	 */
	public function wrap(string $str, string $sym = null, $len = 1) : string
	{
		$sym = (string) $sym;

		if ('' === $sym) return $str;

		$len = max(0, intval($len));

		return str_repeat($sym, $len) . $str . str_repeat($sym, $len);
	}


	/**
	 * @param string      $str
	 * @param string|null $needle
	 * @param bool        $ignoreCase
	 *
	 * @return string
	 */
	public function prepend(string $str, string $needle = null, bool $ignoreCase = true) : string
	{
		$needle = (string) $needle;

		if ('' === $needle) return $str;

		$fn = $ignoreCase
			? 'stripos'
			: 'strpos';

		return 0 === call_user_func($fn, $str, $needle)
			? $str
			: $needle . $str;
	}

	/**
	 * @param string      $str
	 * @param string|null $needle
	 * @param bool        $ignoreCase
	 *
	 * @return string
	 */
	public function append(string $str, string $needle = null, bool $ignoreCase = true) : string
	{
		$needle = (string) $needle;

		if ('' === $needle) return $str;

		$func = $ignoreCase
			? 'strripos'
			: 'strrpos';

		return strlen($str) - strlen($needle) === call_user_func($func, $str, $needle)
			? $str
			: $str . $needle;
	}


	/**
	 * @param string      $str
	 * @param string|null $needle
	 * @param bool|null   $ignoreCase
	 * @param int         $limit
	 *
	 * @return string
	 */
	public function crop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
	{
		return $this->rcrop($this->lcrop($str, $needle, $ignoreCase, $limit), $needle, $ignoreCase, $limit);
	}

	/**
	 * @param string      $str
	 * @param string|null $needle
	 * @param bool|null   $ignoreCase
	 * @param int         $limit
	 *
	 * @return string
	 */
	public function rcrop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
	{
		$needle = (string) $needle;

		if ('' === $str) return $str;
		if ('' === $needle) return $str;

		$ignoreCase = $ignoreCase ?? true;

		while ( 1
			&& $limit--
			&& ( $pos = $ignoreCase
				? strripos($str, $needle)
				: strrpos($str, $needle) ) === strlen($str) - strlen($needle)
		) {
			$str = substr($str, 0, $pos);
		}

		return $str;
	}

	/**
	 * @param string      $str
	 * @param string|null $needle
	 * @param bool|null   $ignoreCase
	 * @param int         $limit
	 *
	 * @return string
	 */
	public function lcrop(string $str, string $needle = null, bool $ignoreCase = null, int $limit = -1) : string
	{
		$needle = (string) $needle;

		if ('' === $str) return $str;
		if ('' === $needle) return $str;

		$ignoreCase = $ignoreCase ?? true;

		while ( 1
			&& $limit--
			&& 0 === ( $ignoreCase
				? stripos($str, $needle)
				: strpos($str, $needle)
			)
		) {
			$str = substr($str, strlen($needle));
		}

		return $str;
	}

	/**
	 * @param string $str
	 * @param string $needle
	 * @param bool   $ignoreCase
	 *
	 * @return string
	 */
	public function uncrop(string $str, string $needle, bool $ignoreCase = true) : string
	{
		return $this->append($this->prepend($str, $needle, $ignoreCase), $needle, $ignoreCase);
	}


	/**
	 * @param mixed    $delimiters
	 * @param string   $string
	 * @param int|null $limit
	 *
	 * @return array
	 */
	public function explode($delimiters, string $string, int $limit = null) : array
	{
		$delimiters = (array) $delimiters;

		$results = [ $string ];

		foreach ( $delimiters as $delimiter ) {
			array_walk_recursive($results, function (&$item) use ($delimiter, $limit) {
				$item = isset($limit)
					? explode($delimiter, $item, $limit)
					: explode($delimiter, $item);
			});
		}

		return $results;
	}


	/**
	 * @param string $value
	 *
	 * @return string
	 */
	public function snake(string $value) : string
	{
		if ('' === $value) {
			return $value;
		}

		$value = preg_replace('/\s+/', '', ucwords($value));
		$value = str_replace('-', '_', $value);

		$test = str_replace([ '_', '-' ], '', $value);

		if (ctype_upper($test)) {
			$value = mb_strtolower($value);
		}

		$value = mb_strtolower(preg_replace('~(?<=\\w)(\p{Ll})~', '_$1', $value));

		return $value;
	}

	/**
	 * @param string $value
	 *
	 * @return string
	 */
	public function usnake(string $value) : string
	{
		return ucfirst($this->snake($value));
	}


	/**
	 * @param string $value
	 *
	 * @return string
	 */
	public function kebab(string $value) : string
	{
		if ('' === $value) {
			return $value;
		}

		$value = preg_replace('/\s+/', '', ucwords($value));
		$value = str_replace('_', '-', $value);

		$test = str_replace([ '_', '-' ], '', $value);

		if (ctype_upper($test)) {
			$value = mb_strtolower($value);
		}

		$value = mb_strtolower(preg_replace('~(?<=\\w)(\p{Ll})~', '-$1', $value));

		return $value;
	}

	/**
	 * @param string $value
	 *
	 * @return string
	 */
	public function ukebab(string $value) : string
	{
		return ucfirst($this->kebab($value));
	}


	/**
	 * @param string $value
	 *
	 * @return string
	 */
	public function pascal(string $value) : string
	{
		if ('' === $value) {
			return $value;
		}

		$test = str_replace([ '_', '-' ], '', $value);

		if (ctype_upper($test)) {
			$value = mb_strtolower($value);
		}

		$value = str_replace(' ', '', ucwords(str_replace([ '-', '_' ], ' ', $value)));

		return $value;
	}


	/**
	 * @param string $value
	 *
	 * @return string
	 */
	public function camel(string $value) : string
	{
		return lcfirst($this->pascal($value));
	}

	/**
	 * @param string $value
	 *
	 * @return string
	 */
	public function ucamel(string $value) : string
	{
		return $this->pascal($value);
	}

}
