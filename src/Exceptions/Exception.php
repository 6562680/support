<?php

namespace Gzhegow\Support\Exceptions;

use Gzhegow\Support\Domain\Exceptions\ExceptionTrait;


/**
 * Exception
 */
class Exception extends \Exception implements
    ExceptionThrowable
{
    use ExceptionTrait;


    /**
     * Constructor
     *
     * @param string|array $message
     * @param int          $code
     * @param \Throwable   $previous
     */
    public function __construct($message = "", $code = null, $previous = null)
    {
        $message = $this->parseMessage($message);

        parent::__construct($message, $code ?? -1, $previous);
    }
}