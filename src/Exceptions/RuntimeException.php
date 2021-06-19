<?php

namespace Gzhegow\Support\Exceptions;

use Throwable;
use Gzhegow\Support\Exceptions\Traits\ExceptionTrait;


/**
 * RuntimeException
 */
class RuntimeException extends \RuntimeException
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
