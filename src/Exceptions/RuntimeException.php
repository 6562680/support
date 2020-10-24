<?php

namespace Gzhegow\Support\Exceptions;

use Throwable;
use Gzhegow\Support\Php;

/**
 * Class RuntimeException
 */
class RuntimeException extends \RuntimeException
{
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
	 * Constructor
	 *
	 * @param                $messages
	 * @param                $payload
	 * @param Throwable|null $previous
	 */
	public function __construct($messages, $payload = null, Throwable $previous = null)
	{
		$messages = (array) $messages;

		array_walk_recursive($messages, function ($message) {
			if (! is_scalar($message)) {
				throw new \InvalidArgumentException('Messages should be scalars', null, $this);
			}
		});

		$php = $this->getPhp();

		[ $errors, $messages ] = $php->kwargs($messages);

		$this->err = $errors;
		$this->msg = implode(PHP_EOL, $messages);
		$this->payload = $payload;

		$report[ 'msg' ] = $this->msg;
		$report[ 'err' ] = $errors;
		$report[ 'payload' ] = $payload;
		$report[ 'trace' ] = array_map(function ($trace) use ($php) {
			unset($trace[ 'type' ]);
			unset($trace[ 'args' ]);

			$trace[ 'args' ] = $php->traceArgs($trace[ 'args' ]);

			return $trace;
		}, $this->getTrace());

		$message = $this->msg . PHP_EOL . json_encode($report, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

		parent::__construct($message, $code = -1, $previous);
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
	 * @return Php
	 */
	protected function getPhp() : Php
	{
		return new Php();
	}
}