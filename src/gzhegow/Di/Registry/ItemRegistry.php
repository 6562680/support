<?php

namespace Gzhegow\Di\Registry;

use Gzhegow\Di\Validator;
use Gzhegow\Di\Exceptions\Logic\OutOfRangeException;
use Gzhegow\Di\Exceptions\Runtime\OverflowException;

/**
 * Class ItemRegistry
 */
class ItemRegistry implements ItemRegistryInterface
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @var mixed
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
	 * @return mixed
	 */
	public function getItem(string $bindName)
	{
		if (! $this->hasItem($bindName)) {
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
	public function hasItem($bindName) : bool
	{
		return $this->validator->isBindName($bindName)
			&& isset($this->items[ $bindName ]);
	}



	/**
	 * @param string $bindName
	 * @param mixed  $item
	 *
	 * @return ItemRegistry
	 */
	public function setItem(string $bindName, $item)
	{
		$this->validator->isBindNameOrFail($bindName);

		$this->items[ $bindName ] = $item;

		return $this;
	}



	/**
	 * @param string          $bindName
	 * @param \Closure|string $item
	 *
	 * @return ItemRegistry
	 */
	public function addItem(string $bindName, $item)
	{
		if ($this->hasItem($bindName)) {
			throw new OverflowException('Item is already registered: ' . $bindName, func_get_args());
		}

		$this->setItem($bindName, $item);

		return $this;
	}
}