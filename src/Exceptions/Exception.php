<?php

namespace Gzhegow\Support\Exceptions;

use Throwable;
use Gzhegow\Support\Php;
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
		$debug = $this->getDebug();
		$php = $this->getPhp();

		$messages = (array) $messages;

		array_walk_recursive($messages, function ($message) {
			if (! ( is_string($message) || is_int($message) )) {
				throw new \InvalidArgumentException('Messages should be strings or integers', null, $this);
			}
		});

		[ $errors, $messages ] = $php->kwargs($messages);

		$this->err = $errors;
		$this->msg = implode(PHP_EOL, $messages);
		$this->payload = $payload;
		$this->report = [
			'msg'     => $this->msg,
			'err'     => $errors,
			'payload' => $payload,
			'trace'   => array_map([ $debug, 'trace' ], $this->getTrace()),
		];

		parent::__construct($this->msg, $code = -1, $previous);
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
		return $this->report;
	}


	/**
	 * @return Debug
	 */
	protected function getDebug() : Debug
	{
		return $this->debug = $this->debug ?? new Debug();
	}

	/**
	 * @return Php
	 */
	protected function getPhp() : Php
	{
		return $this->php = $this->php ?? new Php();
	}
}