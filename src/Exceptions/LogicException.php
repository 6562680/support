<?php

namespace Gzhegow\Support\Exceptions;

use Throwable;
use Gzhegow\Support\Exceptions\Domain\ExceptionTrait;
use Gzhegow\Support\Exceptions\Domain\ExceptionInterface;


/**
 * LogicException
 */
class LogicException extends \LogicException
    implements ExceptionInterface
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


    /**
     * @return int
     */
    protected function loadCode() : int
    {
        if (! isset($this->code)) {
            $class = get_class($this);

            $parentCodes = defined('parent::' . ( $const = 'THE_CODE_LIST' ))
                ? parent::$$const
                : [];

            $codes = array_replace(
                $parentCodes,
                self::THE_CODE_LIST
            );

            $code = null
                ?? $codes[ $class ]
                ?? crc32($this->name);

            $this->code = $code;
        }

        return $this->code;
    }
}
