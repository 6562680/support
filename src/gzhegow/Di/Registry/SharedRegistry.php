<?php

namespace Gzhegow\Di\Registry;

use Gzhegow\Di\Validator;
use Gzhegow\Di\Exceptions\Runtime\OverflowException;

/**
 * Class SharedRegistry
 */
class SharedRegistry implements SharedRegistryInterface
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @var bool[]
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
	 * @return bool
	 */
	public function hasLocal($bindName) : bool
	{
		return $this->validator->isBindName($bindName)
			&& empty($this->items[ $bindName ]);
	}

	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasShared($bindName) : bool
	{
		return $this->validator->isBindName($bindName)
			&& ! empty($this->items[ $bindName ]);
	}


	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function setLocal(string $bindName)
	{
		$this->validator->isBindNameOrFail($bindName);

		$this->items[ $bindName ] = false;

		return $this;
	}

	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function setShared(string $bindName)
	{
		$this->validator->isBindNameOrFail($bindName);

		$this->items[ $bindName ] = true;

		return $this;
	}


	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function addLocal(string $bindName)
	{
		if ($this->hasLocal($bindName)) {
			throw new OverflowException('Bind is already shared: ' . $bindName, func_get_args());
		}

		$this->setLocal($bindName);

		return $this;
	}

	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function addShared(string $bindName)
	{
		if ($this->hasShared($bindName)) {
			throw new OverflowException('Bind is already shared: ' . $bindName, func_get_args());
		}

		$this->setShared($bindName);

		return $this;
	}


	/**
	 * @param string $bindName
	 *
	 * @return SharedRegistry
	 */
	public function removeShared(string $bindName)
	{
		unset($this->items[ $bindName ]);

		return $this;
	}
}