<?php

namespace Gzhegow\Support\Exceptions;

use Gzhegow\Support\Exceptions\Domain\ExceptionTrait;


/**
 * RuntimeException
 */
class RuntimeException extends \RuntimeException
{
    const THE_CODE_LIST = [
        RuntimeException::class => -1,
    ];


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
        $code = $this->loadCode();

        [ $message, $previous ] = $this->parse($message, $payload, ...$arguments);

        parent::__construct($message, $code, $previous);
    }


    /**
     * @return int
     */
    protected function loadCode() : int
    {
        if (0 === ( $code = $this->code )) {
            $class = get_class($this);
            $name = str_replace('\\', '.', $class);

            $parentCodes = [];
            $current = $class;
            while ( true ) {
                if (! defined($constName = $current . '::THE_CODE_LIST')) break;

                $parentCodes += constant($constName);
                $current = get_parent_class($current);
            }

            $codes = array_replace(
                $parentCodes,
                static::THE_CODE_LIST
            );

            $code = null
                ?? $codes[ $class ]
                ?? crc32($name);

            $this->name = $name;
        }

        return $code;
    }
}
