<?php

namespace Tests\Services;

/**
 * Class MyService
 */
class MyService implements MyServiceInterface
{
	/**
	 * @var mixed
	 */
	protected $dynamicOption;


	/**
	 * @return mixed
	 */
	public function getDynamicOption()
	{
		return $this->dynamicOption;
	}

	/**
	 * @param mixed $value
	 *
	 * @return MyService
	 */
	public function setDynamicOption($value)
	{
		$this->dynamicOption = $value;

		return $this;
	}


	/**
	 * @return void
	 */
	public static function getStaticOption()
	{
		return static::$staticOption;
	}

	/**
	 * @param $value
	 *
	 * @return void
	 */
	public static function setStaticOption($value)
	{
		static::$staticOption = $value;
	}


	/**
	 * @var mixed
	 */
	protected static $staticOption;
}