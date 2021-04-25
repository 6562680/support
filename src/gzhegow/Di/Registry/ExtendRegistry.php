<?php

namespace Gzhegow\Di\Registry;

use Gzhegow\Di\Validator;
use Gzhegow\Di\Exceptions\Logic\OutOfRangeException;

/**
 * Class ExtendRegistry
 */
class ExtendRegistry implements ExtendRegistryInterface
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @var \Closure[][]
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
	 * @return \Closure[]
	 */
	public function getExtends(string $bindName) : array
	{
		if (! $this->hasExtends($bindName)) {
			throw new OutOfRangeException('No extends found by key: ' . $bindName, func_get_args());
		}

		$result = $this->items[ $bindName ];

		return $result;
	}


	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasExtends($bindName) : bool
	{
		return $this->validator->isBindName($bindName)
			&& isset($this->items[ $bindName ]);
	}


	/**
	 * @param array $extends
	 *
	 * @return ExtendRegistry
	 */
	public function setExtends(array $extends = [])
	{
		$this->items = [];

		$this->addExtends($extends);

		return $this;
	}


	/**
	 * @param array $extends
	 *
	 * @return ExtendRegistry
	 */
	public function addExtends(array $extends = [])
	{
		foreach ( $extends as $bindName => $extend ) {
			$this->addExtend($bindName, $extend);
		}

		return $this;
	}


	/**
	 * @param string          $bindName
	 * @param \Closure|string $extend
	 *
	 * @return ExtendRegistry
	 */
	public function addExtend(string $bindName, $extend)
	{
		$this->validator->isBindNameOrFail($bindName);
		$this->validator->isExtendOrFail($extend);

		$this->items[ $bindName ][] = $extend;

		return $this;
	}
}