<?php

namespace Gzhegow\Di\Registry;

use Gzhegow\Di\Validator;
use Gzhegow\Di\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Di\Exceptions\Runtime\OverflowException;

/**
 * Class BindRegistry
 */
class BindRegistry implements BindRegistryInterface
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @var string[]|\Closure[]
	 */
	protected $items = [];


	/**
	 * Constructor
	 *
	 * @param Validator $validator
	 */
	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}


	/**
	 * @param string $bindName
	 *
	 * @return \Closure|string
	 */
	public function getBind(string $bindName)
	{
		if (! $this->hasBind($bindName)) {
			throw new OutOfRangeException('No bind found by key: ' . $bindName, func_get_args());
		}

		$result = $this->items[ $bindName ];

		return $result;
	}


	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasBind($bindName) : bool
	{
		return $this->validator->isBindName($bindName)
			&& isset($this->items[ $bindName ]);
	}


	/**
	 * @param string          $bindName
	 * @param \Closure|string $bind
	 *
	 * @return BindRegistry
	 */
	public function setBind(string $bindName, $bind)
	{
		$this->validator->isBindNameOrFail($bindName);
		$this->validator->isBindOrFail($bind);

		$this->items[ $bindName ] = $bind;

		return $this;
	}


	/**
	 * @param string          $bindName
	 * @param \Closure|string $bind
	 *
	 * @return BindRegistry
	 */
	public function addBind(string $bindName, $bind)
	{
		if ($this->hasBind($bindName)) {
			throw new OverflowException('Bind is already registered: ' . $bindName, func_get_args());
		}

		$this->setBind($bindName, $bind);

		return $this;
	}
}