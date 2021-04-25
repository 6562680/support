<?php

namespace Gzhegow\Di\Registry;

use Gzhegow\Di\Validator;
use Gzhegow\Di\Exceptions\Logic\OutOfRangeException;

/**
 * Class DeferableRegistry
 */
class DeferableRegistry implements DeferableRegistryInterface
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
	public function getDeferable(string $bindName)
	{
		if (! $this->hasDeferable($bindName)) {
			throw new OutOfRangeException('No deferable bind found by key: ' . $bindName, func_get_args());
		}

		$result = $this->items[ $bindName ];

		return $result;
	}


	/**
	 * @param string $bindName
	 *
	 * @return bool
	 */
	public function hasDeferable($bindName) : bool
	{
		return $this->validator->isBindName($bindName)
			&& isset($this->items[ $bindName ]);
	}


	/**
	 * @param array $deferables
	 *
	 * @return DeferableRegistry
	 */
	public function setDeferables(array $deferables)
	{
		$this->items = [];

		$this->addDeferables($deferables);

		return $this;
	}


	/**
	 * @param array $deferables
	 *
	 * @return DeferableRegistry
	 */
	public function addDeferables(array $deferables)
	{
		foreach ( $deferables as $bindName => $provider ) {
			$this->addDeferable($bindName, $provider);
		}

		return $this;
	}

	/**
	 * @param string          $bindName
	 * @param \Closure|string $provider
	 *
	 * @return DeferableRegistry
	 */
	public function addDeferable(string $bindName, $provider)
	{
		$this->validator->isBindNameOrFail($bindName);
		$this->validator->isProviderStringOrFail($provider);

		$this->items[ $bindName ][] = $provider;

		return $this;
	}
}