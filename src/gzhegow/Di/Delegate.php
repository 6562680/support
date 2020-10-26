<?php

namespace Gzhegow\Di;

/**
 * Class Delegate
 */
class Delegate implements DelegateInterface
{
	/**
	 * @var Di
	 */
	protected $di;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var mixed
	 */
	protected $delegate;


	/**
	 * Constructor
	 *
	 * @param Di     $di
	 * @param string $id
	 */
	public function __construct(
		Di $di,

		string $id
	)
	{
		$this->di = $di;

		$this->id = $id;
	}


	/**
	 * @return mixed
	 */
	public function __invoke()
	{
		return $this->getDelegate();
	}


	/**
	 * @return mixed
	 */
	public function getDelegate()
	{
		return $this->delegate = $this->delegate ?? $this->di->getOrFail($this->id);
	}
}
