<?php


namespace Gzhegow\Support\Domain\Debug;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * DebugMessage
 */
class DebugMessage
{
    /**
     * @var string
     */
    protected $message;
    /**
     * @var array
     */
    protected $placeholders;


    /**
     * Constructor
     *
     * @param string|array $message
     * @param array        ...$arguments
     */
    public function __construct($message, ...$arguments)
    {
        $args = [];
        $kwargs = [];
        foreach ( func_get_args() as $argument ) {
            if (is_array($argument)) {
                foreach ( $argument as $key => $val ) {
                    is_int($key)
                        ? ( $args[] = $val )
                        : ( $kwargs[ $key ] = $val );
                }
            } else {
                $args[] = $argument;
            }
        }

        $text = array_shift($args);
        $text = trim($text);

        if ('' === $text) {
            throw new InvalidArgumentException(
                'The `message` should be non-empty string: %s', $message
            );
        }

        $placeholders = array_merge($args, $kwargs);

        $this->message = $text;
        $this->placeholders = $placeholders;
    }


    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * @return null|array
     */
    public function getPlaceholders() : array
    {
        return $this->placeholders;
    }


    /**
     * @return array
     */
    public function toArray() : array
    {
        return array_merge(
            [ $this->message ],
            $this->placeholders ?? []
        );
    }
}