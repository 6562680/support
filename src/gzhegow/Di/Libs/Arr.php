<?php

namespace Gzhegow\Di\Libs;

use Gzhegow\Di\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Arr
 */
class Arr
{
	/**
	 * @param array $array
	 * @param int   $pos
	 * @param null  $value
	 *
	 * @return array
	 */
	public function expand(array $array, int $pos, $value = null) : array
	{
		if ($pos < 0) {
			throw new InvalidArgumentException('Pos should be non-negative');
		}

		$result = array_merge(
			array_slice($array, 0, $pos),
			[ $pos => $value ],
			array_slice($array, $pos)
		);

		return $result;
	}
}