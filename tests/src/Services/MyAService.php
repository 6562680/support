<?php

namespace Gzhegow\Di\Tests\Services;

/**
 * Class MyDelegateAService
 */
class MyAService implements MyServiceAInterface
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
	 * @return MyAService
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