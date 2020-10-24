<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Math
 */
class Math
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
	public function __construct(
		Php $php,
		Type $type
	)
	{
		$this->php = $php;
		$this->type = $type;
	}


	/**
	 * @param mixed $item
	 * @param mixed ...$values
	 *
	 * @return float
	 */
	public function median($item, ...$values) : float
	{
		[ 1 => $args ] = $this->php->kwargs($item, ...$values);

		$list = [];
		foreach ( $args as $arg ) {
			if (! $this->type->isNumber($arg)) {
				throw new InvalidArgumentException('Each argument should be numeric');
			}

			$list[] = $arg;
		}

		if (! $list) {
			throw new InvalidArgumentException('At least one number should be passed');
		}

		if (1 == ( $count = count($list) )) {
			return current($list);
		}

		sort($values);

		$idx = (int) floor($count / 2) - 1;

		return $count % 2
			? $values[ $idx ]
			: ( $values[ $idx ] + $values[ $idx + 1 ] ) / 2;
	}


	/**
	 * @param       $item
	 * @param mixed ...$values
	 *
	 * @return float
	 */
	public function avg($item, ...$values) : float
	{
		[ 1 => $args ] = $this->php->kwargs($item, ...$values);

		$list = [];
		foreach ( $args as $arg ) {
			if (! $this->type->isNumber($arg)) {
				throw new InvalidArgumentException('Each argument should be numeric');
			}

			$list[] = $arg;
		}

		if (! $list) {
			throw new InvalidArgumentException('At least one number should be passed');
		}

		if (1 == ( $count = count($list) )) {
			return current($list);
		}

		return array_sum($values) / count($values);
	}


	/**
	 * @param mixed $min
	 * @param mixed $max
	 *
	 * @return string
	 */
	public function rand($min, $max) : string
	{
		if (! $this->type->isNumber($min)) {
			throw new InvalidArgumentException('From should be number', func_get_args());
		}

		$max = $max ?? $min;

		if (! $this->type->isNumber($max)) {
			throw new InvalidArgumentException('To should be number', func_get_args());
		}

		return ( $min + lcg_value() * ( abs($max - $min) ) );
	}
}
