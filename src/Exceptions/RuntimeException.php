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
     * @param string|array   $message
     * @param mixed          $payload
     * @param Throwable|null $previous
     */
    public function __construct($message, $payload = null, Throwable $previous = null)
    {
        $this->parse($message, $payload);

        parent::__construct($this->text, -1, $previous);
    }
}
