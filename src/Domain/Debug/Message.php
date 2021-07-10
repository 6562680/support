<?php


namespace Gzhegow\Support\Domain\Debug;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Message
 */
class Message
{
    /**
     * @var string
     */
    protected $message;
    /**
     * @var array
     */
    protected $arguments;


    /**
     * Constructor
     *
     * @param string|array $message
     * @param array        ...$arguments
     */
    public function __construct($message, ...$arguments)
    {
        $placeholders = is_array($message)
            ? $message
            : [ $message ];

        $text = array_shift($placeholders);
        if (! is_string($text)) {
            throw new InvalidArgumentException('Message should be string: %s', $message);
        }

        $text = trim($text);
        if ('' === $text) {
            throw new InvalidArgumentException('Message should be non-empty: %s', $message);
        }

        $placeholders = array_replace($placeholders, $arguments);

        $this->message = $text;
        $this->arguments = $placeholders ?: null;
    }


    /**
     * @return array
     */
    public function toArray() : array
    {
        return array_merge([ $this->message ], $this->arguments ?? []);
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
    public function getArguments() : array
    {
        return $this->arguments;
    }


    /**
     * @return null|array
     */
    public function hasArguments() : ?array
    {
        return $this->arguments;
    }
}
