<?php

namespace Gzhegow\Support;

/**
 * Class Config
 */
class Config
{
	/**
	 * @var Arr
	 */
	protected $arr;

	/**
	 * @var array
	 */
	protected $config = [];
	/**
	 * @var array
	 */
	protected $settings = [];


	/**
	 * Constructor
	 *
	 * @param Arr   $arr
	 * @param array $config
	 */
	public function __construct(Arr $arr, array $config = [])
	{
		$this->arr = $arr;

		$this->setConfig($config);
	}


	/**
	 * @return array
	 */
	public function getConfig() : array
	{
		return $this->config;
	}

	/**
	 * @param array $config
	 *
	 * @return Config
	 */
	public function setConfig(array $config)
	{
		$this->config = [];

		$this->mergeConfig($config);

		return $this;
	}

	/**
	 * @param array $config
	 *
	 * @return $this
	 */
	public function mergeConfig(array $config)
	{
		$this->config = array_merge_recursive($this->config, $config);
		$this->settings = $this->config;

		return $this;
	}


	/**
	 * @param string|array $path
	 * @param mixed        $default
	 *
	 * @return mixed
	 */
	public function get($path, $default = null)
	{
		return $this->arr->get($path, $this->settings, $default);
	}

	/**
	 * @param string|array $path
	 * @param mixed        $value
	 *
	 * @return Config
	 */
	public function set($path, $value)
	{
		$this->arr->set($this->settings, $path, $value);

		return $this;
	}


	/**
	 * @param      $path
	 * @param null $default
	 *
	 * @return mixed
	 */
	public function config($path, $default = null)
	{
		return $this->arr->get($path, $this->config, $default);
	}
}