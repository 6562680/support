<?php

namespace Gzhegow\Support\Exceptions;

use Throwable;
use Gzhegow\Support\Exceptions\Traits\ExceptionTrait;


/**
 * LogicException
 */
class LogicException extends \LogicException
{
    use ExceptionTrait;


    /**
     * Constructor
     *
     * @param string|array $message
     * @param mixed        $payload
     * @param mixed        ...$arguments
     */
    public function __construct($message, $payload = null, ...$arguments)
    {
        [ $message, $code, $previous ] = $this->parse($message, $payload, ...$arguments);

        parent::__construct($message, $code, $previous);
    }
}
