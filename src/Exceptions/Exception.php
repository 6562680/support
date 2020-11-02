<?php

namespace Gzhegow\Support\Exceptions;

use Throwable;
use Gzhegow\Support\Php;
use Gzhegow\Support\Type;
use Gzhegow\Support\Debug;

/**
 * Class Exception
 */
class Exception extends \Exception
{
	/**
	 * @var Debug
	 */
	protected $debug;
	/**
	 * @var Php
	 */
	protected $php;
	/**
	 * @var Type
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string
	 */
	protected $msg;
	/**
	 * @var array
	 */
	protected $err = [];
	/**
	 * @var mixed
	 */
	protected $payload;

	/**
	 * @var array
	 */
	protected $report;


	/**
	 * Constructor
	 *
	 * @param mixed          $messages
	 * @param mixed          $payload
	 * @param Throwable|null $previous
	 */
	public function __construct($messages, $payload = null, Throwable $previous = null)
	{
		$this->loadDependencies();

		$messages = $this->type->listval($messages);

		array_walk_recursive($messages, function ($message) {
			if (! ( is_string($message) || is_int($message) )) {
				throw new \InvalidArgumentException('Messages should be strings or integers', null, $this);
			}
		});

		[ $errors, $messages ] = $this->php->kwargs($messages);

		$this->name = str_replace('\\', '.', get_class($this));
		$this->err = $errors;
		$this->msg = implode(PHP_EOL, $messages);
		$this->payload = $payload;

		parent::__construct($this->msg, -1, $previous);
	}


	/**
	 * @return void
	 */
	protected function loadDependencies() : void
	{
		$this->debug = new Debug();
		$this->php = new Php();
		$this->type = new Type();
	}


	/**
	 * @return string
	 */
	public function getName() : string
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getMsg() : string
	{
		return $this->msg;
	}

	/**
	 * @return array
	 */
	public function getErr() : array
	{
		return $this->err;
	}

	/**
	 * @return mixed
	 */
	public function getPayload()
	{
		return $this->payload;
	}


	/**
	 * @return array
	 */
	public function getReport() : array
	{
		return [
			'name'    => $this->name,
			'msg'     => $this->msg,
			'err'     => $this->err,
			'payload' => $this->payload,
			'trace'   => array_map([ $this->debug, 'trace' ], $this->getTrace()),
		];
	}
}