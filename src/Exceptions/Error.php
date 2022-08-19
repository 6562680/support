<?php

namespace Gzhegow\Support\Exceptions;

use Gzhegow\Support\Domain\Exceptions\ExceptionTrait;


/**
 * Error
 */
class Error extends \Error implements
    ErrorThrowable
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