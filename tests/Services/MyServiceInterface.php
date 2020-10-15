<?php

namespace Tests\Services;

/**
 * Interface MyServiceInterface
 */
interface MyServiceInterface
{
	/**
	 * @return mixed
	 */
	public function getDynamicOption();

	/**
	 * @param $value
	 *
	 * @return void
	 */
	public function setDynamicOption($value);


	/**
	 * @return mixed
	 */
	public static function getStaticOption();

	/**
	 * @param $value
	 *
	 * @return void
	 */
	public static function setStaticOption($value);
}